<?php

namespace App\Services\IngredientImport;

use App\Models\IngredientCategory;
use App\Models\IngredientGroup;
use App\Models\IngredientMaster;
use App\Support\IngredientImportNormalizer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

class IngredientPreImportCleanup
{
    private string $actor;

    private array $result = [
        'normalized_groups' => 0,
        'normalized_categories' => 0,
        'normalized_items' => 0,
        'normalized_units' => 0,
        'reassigned_categories' => 0,
        'deleted_duplicate_items' => [],
        'merged_duplicate_items' => [],
        'duplicate_usage' => [],
        'converted_recipes' => [],
    ];

    public function __construct(?string $actor = null)
    {
        $this->actor = $actor ?? '';
    }

    public function run(): array
    {
        $this->normalizeMasters();
        $this->alignCanonicalCategories();
        $this->removeUnusedDuplicateItems(['NAGASARI', 'SAYUR SOP']);
        $this->mergeDuplicateItems([
            'THINWALL CUP - 100ML',
            'THINWALL CUP - 150ML',
            'THINWALL KOTAK 1000ML',
        ]);
        $this->ensureNoUnexpectedActiveDuplicates();
        $this->convertRecipeUnit('AYAM FILLET DADA', 'KG', 'GRAM', 1000);
        $this->convertRecipeUnit('AYAM FILLET PAHA', 'KG', 'GRAM', 1000);

        return $this->result;
    }

    private function normalizeMasters(): void
    {
        IngredientGroup::withTrashed()->orderBy('id')->each(function (IngredientGroup $group) {
            $name = IngredientImportNormalizer::group($group->name);

            if ($group->name !== $name) {
                $group->name = $name;
                $group->updated_by = $this->actor;
                $group->saveQuietly();
                $this->result['normalized_groups']++;
            }
        });

        IngredientCategory::withTrashed()->orderBy('id')->each(function (IngredientCategory $category) {
            $name = IngredientImportNormalizer::category($category->name);

            if ($category->name !== $name) {
                $category->name = $name;
                $category->updated_by = $this->actor;
                $category->saveQuietly();
                $this->result['normalized_categories']++;
            }
        });

        IngredientMaster::withTrashed()->orderBy('id')->each(function (IngredientMaster $ingredient) {
            $name = IngredientImportNormalizer::item($ingredient->name);
            $unit = IngredientImportNormalizer::unit($ingredient->unit);
            $changed = false;

            if ($ingredient->name !== $name) {
                $ingredient->name = $name;
                $this->result['normalized_items']++;
                $changed = true;
            }

            if ($ingredient->unit !== $unit) {
                $ingredient->unit = $unit;
                $this->result['normalized_units']++;
                $changed = true;
            }

            if ($changed) {
                $ingredient->updated_by = $this->actor;
                $ingredient->saveQuietly();
            }
        });
    }

    private function alignCanonicalCategories(): void
    {
        $assignments = [
            'MINYAK, LEMAK & SANTAN' => 'BAHAN BAKU',
            'PRODAK OLAHAN & SIAP SAJI' => 'BAHAN JADI',
        ];

        foreach ($assignments as $categoryName => $groupName) {
            $category = IngredientCategory::where('name', $categoryName)->first();

            if (! $category) {
                continue;
            }

            $group = IngredientGroup::where('name', $groupName)->first();

            if (! $group) {
                throw new RuntimeException('Ingredient group '.$groupName.' tidak ditemukan.');
            }

            if ((int) $category->ingredient_master_group_id !== (int) $group->id) {
                $category->ingredient_master_group_id = $group->id;
                $category->updated_by = $this->actor;
                $category->saveQuietly();
                $this->result['reassigned_categories']++;
            }
        }
    }

    private function removeUnusedDuplicateItems(array $names): void
    {
        foreach ($names as $name) {
            $ingredients = IngredientMaster::where('name', $name)->orderBy('id')->get();

            if ($ingredients->count() < 2) {
                continue;
            }

            $usages = $ingredients->mapWithKeys(function (IngredientMaster $ingredient) {
                return [$ingredient->id => $this->usageFor($ingredient)];
            });

            $canonical = $ingredients
                ->sort(function (IngredientMaster $left, IngredientMaster $right) use ($usages) {
                    $usageComparison = $usages[$right->id]['total'] <=> $usages[$left->id]['total'];

                    return $usageComparison !== 0
                        ? $usageComparison
                        : $left->id <=> $right->id;
                })
                ->first();

            $this->result['duplicate_usage'][$name] = [
                'canonical_id' => $canonical->id,
                'records' => $usages->all(),
            ];

            foreach ($ingredients as $ingredient) {
                if ($ingredient->id === $canonical->id) {
                    continue;
                }

                if ($usages[$ingredient->id]['total'] > 0) {
                    continue;
                }

                $ingredient->forceDelete();
                $this->result['deleted_duplicate_items'][] = [
                    'id' => $ingredient->id,
                    'name' => $name,
                ];
            }
        }
    }

    private function mergeDuplicateItems(array $names): void
    {
        foreach ($names as $name) {
            $ingredients = IngredientMaster::where('name', $name)->orderBy('id')->get();

            if ($ingredients->count() < 2) {
                continue;
            }

            $usages = $ingredients->mapWithKeys(function (IngredientMaster $ingredient) {
                return [$ingredient->id => $this->usageFor($ingredient)];
            });

            $canonical = $ingredients
                ->sort(function (IngredientMaster $left, IngredientMaster $right) use ($usages) {
                    $usageComparison = $usages[$right->id]['total'] <=> $usages[$left->id]['total'];

                    return $usageComparison !== 0
                        ? $usageComparison
                        : $left->id <=> $right->id;
                })
                ->first();

            $this->result['duplicate_usage'][$name] = [
                'canonical_id' => $canonical->id,
                'records' => $usages->all(),
            ];

            foreach ($ingredients as $ingredient) {
                if ($ingredient->id === $canonical->id) {
                    continue;
                }

                $movedRecipes = DB::table('product_recipes')
                    ->where('ingredient_master_id', $ingredient->id)
                    ->update([
                        'ingredient_master_id' => $canonical->id,
                        'updated_by' => $this->actor,
                        'updated_at' => now(),
                    ]);

                $movedPurchaseItems = Schema::hasTable('purchase_items')
                    ? DB::table('purchase_items')
                        ->where('product_id', $ingredient->id)
                        ->update([
                            'product_id' => $canonical->id,
                            'updated_at' => now(),
                        ])
                    : 0;

                $remainingUsage = $this->usageFor($ingredient);

                if ($remainingUsage['total'] > 0) {
                    throw new RuntimeException(sprintf(
                        'Relasi item duplikat %s ID %d belum seluruhnya dipindahkan.',
                        $name,
                        $ingredient->id
                    ));
                }

                $ingredient->forceDelete();

                $this->result['merged_duplicate_items'][] = [
                    'deleted_id' => $ingredient->id,
                    'canonical_id' => $canonical->id,
                    'name' => $name,
                    'moved_product_recipes' => $movedRecipes,
                    'moved_purchase_items' => $movedPurchaseItems,
                ];
            }
        }
    }

    private function usageFor(IngredientMaster $ingredient): array
    {
        $recipes = DB::table('product_recipes as recipe')
            ->leftJoin('product', 'product.id', '=', 'recipe.product_id')
            ->where('recipe.ingredient_master_id', $ingredient->id)
            ->select([
                'recipe.id',
                'recipe.product_id',
                'recipe.qty',
                'recipe.deleted_at',
                'product.name as product_name',
            ])
            ->orderBy('recipe.id')
            ->get();

        $purchaseItems = Schema::hasTable('purchase_items')
            ? DB::table('purchase_items')
                ->where('product_id', $ingredient->id)
                ->select(['id', 'purchase_id', 'product_name', 'unit', 'po_qty'])
                ->orderBy('id')
                ->get()
            : collect();

        return [
            'product_recipes' => $recipes->map(function ($recipe) {
                return [
                    'id' => $recipe->id,
                    'product_id' => $recipe->product_id,
                    'product_name' => $recipe->product_name,
                    'qty' => $recipe->qty,
                    'deleted_at' => $recipe->deleted_at,
                ];
            })->all(),
            'purchase_items' => $purchaseItems->map(function ($purchaseItem) {
                return [
                    'id' => $purchaseItem->id,
                    'purchase_id' => $purchaseItem->purchase_id,
                    'product_name' => $purchaseItem->product_name,
                    'unit' => $purchaseItem->unit,
                    'qty' => $purchaseItem->po_qty,
                ];
            })->all(),
            'total' => $recipes->count() + $purchaseItems->count(),
        ];
    }

    private function ensureNoUnexpectedActiveDuplicates(): void
    {
        $duplicateGroups = IngredientGroup::select('name')
            ->groupBy('name')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('name');

        $duplicateCategories = IngredientCategory::select('name')
            ->groupBy('name')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('name');

        $duplicateItems = IngredientMaster::select('name')
            ->groupBy('name')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('name');

        if ($duplicateGroups->isNotEmpty() || $duplicateCategories->isNotEmpty() || $duplicateItems->isNotEmpty()) {
            throw new RuntimeException(sprintf(
                'Masih ada data master duplikat. Group: %s; Category: %s; Item: %s.',
                $duplicateGroups->implode(', ') ?: '-',
                $duplicateCategories->implode(', ') ?: '-',
                $duplicateItems->implode(', ') ?: '-'
            ));
        }
    }

    private function convertRecipeUnit(string $itemName, string $fromUnit, string $toUnit, float $multiplier): void
    {
        $ingredients = IngredientMaster::where('name', $itemName)->orderBy('id')->get();

        if ($ingredients->isEmpty()) {
            $this->result['converted_recipes'][$itemName] = [
                'status' => 'item_not_found',
                'recipe_count' => 0,
            ];

            return;
        }

        if ($ingredients->count() > 1) {
            throw new RuntimeException('Item '.$itemName.' masih memiliki data duplikat.');
        }

        $ingredient = $ingredients->first();

        if ($ingredient->unit === $toUnit) {
            $this->result['converted_recipes'][$itemName] = [
                'status' => 'already_converted',
                'recipe_count' => 0,
            ];

            return;
        }

        if ($ingredient->unit !== $fromUnit) {
            throw new RuntimeException(sprintf(
                'Unit %s adalah %s, bukan %s atau %s.',
                $itemName,
                $ingredient->unit,
                $fromUnit,
                $toUnit
            ));
        }

        $recipes = DB::table('product_recipes')
            ->where('ingredient_master_id', $ingredient->id)
            ->get(['id', 'qty', 'deleted_at']);

        DB::table('product_recipes')
            ->where('ingredient_master_id', $ingredient->id)
            ->update([
                'qty' => DB::raw('qty * '.$multiplier),
                'updated_by' => $this->actor,
                'updated_at' => now(),
            ]);

        $ingredient->unit = $toUnit;
        $ingredient->updated_by = $this->actor;
        $ingredient->saveQuietly();

        $this->result['normalized_units']++;
        $this->result['converted_recipes'][$itemName] = [
            'status' => 'converted',
            'recipe_count' => $recipes->count(),
            'active_recipe_count' => $recipes->whereNull('deleted_at')->count(),
            'deleted_recipe_count' => $recipes->whereNotNull('deleted_at')->count(),
            'multiplier' => $multiplier,
        ];
    }
}
