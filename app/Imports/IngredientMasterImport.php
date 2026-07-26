<?php

namespace App\Imports;

use App\Models\IngredientCategory;
use App\Models\IngredientGroup;
use App\Models\IngredientMaster;
use App\Support\IngredientImportNormalizer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IngredientMasterImport implements SkipsEmptyRows, ToCollection, WithHeadingRow
{
    private string $actor;

    private array $result = [
        'created_groups' => 0,
        'created_categories' => 0,
        'created_ingredients' => 0,
        'updated_ingredients' => 0,
        'unchanged_ingredients' => 0,
        'category_group_mismatches' => 0,
        'processed_rows' => 0,
    ];

    public function __construct(?string $actor = null)
    {
        $this->actor = $actor ?? '';
    }

    public function collection(Collection $rows): void
    {
        if ($rows->isEmpty()) {
            throw ValidationException::withMessages([
                'ingredient_file' => ['File Excel tidak memiliki data ingredient.'],
            ]);
        }

        DB::transaction(function () use ($rows) {
            foreach ($rows as $index => $row) {
                $excelRow = $index + 2;
                $data = $this->prepareRow($row);

                $validator = Validator::make($data, [
                    'group' => 'required|string|max:255',
                    'category' => 'required|string|max:255',
                    'item' => 'required|string|max:255',
                    'unit' => 'required|string|max:255',
                ], [], [
                    'group' => 'BOM Category',
                    'category' => 'BOM Sub-Category',
                    'item' => 'BOM Item',
                    'unit' => 'Unit',
                ]);

                if ($validator->fails()) {
                    throw ValidationException::withMessages([
                        'ingredient_file' => [
                            'Baris Excel '.$excelRow.': '.implode(', ', $validator->errors()->all()),
                        ],
                    ]);
                }

                $group = IngredientGroup::where('name', $data['group'])->first();

                if (! $group) {
                    $group = new IngredientGroup;
                    $group->name = $data['group'];
                    $group->created_by = $this->actor;
                    $group->save();

                    $this->result['created_groups']++;
                }

                // Nama subcategory menjadi relasi kanonis. Jika baris berikutnya
                // menyebut group berbeda, gunakan subcategory yang sudah dibuat.
                $category = IngredientCategory::where('name', $data['category'])->first();

                if (! $category) {
                    $category = new IngredientCategory;
                    $category->ingredient_master_group_id = $group->id;
                    $category->name = $data['category'];
                    $category->created_by = $this->actor;
                    $category->save();

                    $this->result['created_categories']++;
                } elseif ((int) $category->ingredient_master_group_id !== (int) $group->id) {
                    $this->result['category_group_mismatches']++;
                }

                $ingredient = IngredientMaster::where('name', $data['item'])->first();

                if (! $ingredient) {
                    $ingredient = new IngredientMaster;
                    $ingredient->ingredient_master_category_id = $category->id;
                    $ingredient->name = $data['item'];
                    $ingredient->unit = $data['unit'];
                    $ingredient->price = 0;
                    $ingredient->created_by = $this->actor;
                    $ingredient->save();

                    $this->result['created_ingredients']++;
                } elseif (
                    (int) $ingredient->ingredient_master_category_id !== (int) $category->id
                    || $ingredient->unit !== $data['unit']
                ) {
                    $ingredient->ingredient_master_category_id = $category->id;
                    $ingredient->unit = $data['unit'];
                    $ingredient->updated_by = $this->actor;
                    $ingredient->save();

                    $this->result['updated_ingredients']++;
                } else {
                    $this->result['unchanged_ingredients']++;
                }

                $this->result['processed_rows']++;
            }
        });
    }

    public function result(): array
    {
        return $this->result;
    }

    private function prepareRow($row): array
    {
        return [
            'group' => IngredientImportNormalizer::group($this->value($row, [
                'jenis_pengeluaran_bom_category',
                'bom_category',
                'category',
            ])),
            'category' => IngredientImportNormalizer::category($this->value($row, [
                'bom_sub_category',
                'sub_category',
            ])),
            'item' => IngredientImportNormalizer::item($this->value($row, [
                'jenis_item_bom_item',
                'bom_item',
                'nama_item',
            ])),
            'unit' => IngredientImportNormalizer::unit($this->value($row, ['unit'])),
        ];
    }

    private function value($row, array $keys)
    {
        foreach ($keys as $key) {
            if (isset($row[$key])) {
                return $row[$key];
            }
        }

        return null;
    }
}
