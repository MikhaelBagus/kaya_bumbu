<?php

namespace Tests\Feature;

use App\Services\IngredientImport\IngredientPreImportCleanup;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class IngredientPreImportCleanupTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
                'foreign_key_constraints' => false,
            ],
        ]);

        DB::purge();
        DB::reconnect('sqlite');

        Schema::create('ingredient_master_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('created_by')->default('');
            $table->string('updated_by')->default('');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('ingredient_master_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingredient_master_group_id');
            $table->string('name');
            $table->string('created_by')->default('');
            $table->string('updated_by')->default('');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('ingredient_masters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingredient_master_category_id');
            $table->string('name');
            $table->string('unit');
            $table->double('price')->default(0);
            $table->string('created_by')->default('');
            $table->string('updated_by')->default('');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('product_recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->foreignId('ingredient_master_id');
            $table->double('qty');
            $table->string('created_by')->default('');
            $table->string('updated_by')->default('');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('product_name')->default('');
            $table->string('unit')->default('');
            $table->double('po_qty')->default(0);
            $table->timestamps();
        });
    }

    public function test_it_moves_thinwall_relations_and_deletes_duplicate_items(): void
    {
        $now = now();

        DB::table('ingredient_master_groups')->insert([
            'id' => 1,
            'name' => 'Packaging',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('ingredient_master_categories')->insert([
            'id' => 1,
            'ingredient_master_group_id' => 1,
            'name' => 'Kemasan',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('ingredient_masters')->insert([
            $this->ingredient(68, 'Thinwall Cup - 100ml', $now),
            $this->ingredient(301, 'Thinwall Cup - 100 ml', $now),
            $this->ingredient(75, 'Thinwall Cup - 150ml', $now),
            $this->ingredient(311, 'Thinwall Cup - 150 ml', $now),
            $this->ingredient(242, 'Thinwall Kotak 1000 ml', $now),
            $this->ingredient(302, 'Thinwall Kotak 1000ml', $now),
        ]);

        DB::table('product')->insert([
            ['id' => 1, 'name' => 'Product 1'],
            ['id' => 2, 'name' => 'Product 2'],
            ['id' => 3, 'name' => 'Product 3'],
            ['id' => 4, 'name' => 'Product 4'],
            ['id' => 5, 'name' => 'Product 5'],
            ['id' => 6, 'name' => 'Product 6'],
            ['id' => 7, 'name' => 'Product 7'],
            ['id' => 8, 'name' => 'Product 8'],
            ['id' => 9, 'name' => 'Product 9'],
        ]);

        DB::table('product_recipes')->insert([
            $this->recipe(1, 1, 68, $now),
            $this->recipe(2, 2, 68, $now),
            $this->recipe(3, 3, 301, $now),
            $this->recipe(4, 4, 75, $now),
            $this->recipe(5, 5, 75, $now),
            $this->recipe(6, 6, 311, $now),
            $this->recipe(7, 7, 242, $now),
            $this->recipe(8, 8, 242, $now),
            $this->recipe(9, 9, 302, $now),
        ]);

        DB::table('purchase_items')->insert([
            'id' => 1,
            'purchase_id' => 1,
            'product_id' => 301,
            'product_name' => 'Thinwall Cup - 100 ml',
            'unit' => 'pcs',
            'po_qty' => 10,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $result = (new IngredientPreImportCleanup('test'))->run();

        $this->assertSame([
            68 => 'THINWALL CUP - 100ML',
            75 => 'THINWALL CUP - 150ML',
            242 => 'THINWALL KOTAK 1000ML',
        ], DB::table('ingredient_masters')->orderBy('id')->pluck('name', 'id')->all());

        $this->assertSame(3, DB::table('product_recipes')->where('ingredient_master_id', 68)->count());
        $this->assertSame(3, DB::table('product_recipes')->where('ingredient_master_id', 75)->count());
        $this->assertSame(3, DB::table('product_recipes')->where('ingredient_master_id', 242)->count());
        $this->assertSame(0, DB::table('product_recipes')->whereIn(
            'ingredient_master_id',
            [301, 311, 302]
        )->count());
        $this->assertSame(68, DB::table('purchase_items')->value('product_id'));
        $this->assertCount(3, $result['merged_duplicate_items']);

        $secondResult = (new IngredientPreImportCleanup('test-second-pass'))->run();

        $this->assertSame([], $secondResult['merged_duplicate_items']);
        $this->assertSame(3, DB::table('ingredient_masters')->count());
    }

    private function ingredient(int $id, string $name, $now): array
    {
        return [
            'id' => $id,
            'ingredient_master_category_id' => 1,
            'name' => $name,
            'unit' => 'pcs',
            'price' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }

    private function recipe(int $id, int $productId, int $ingredientId, $now): array
    {
        return [
            'id' => $id,
            'product_id' => $productId,
            'ingredient_master_id' => $ingredientId,
            'qty' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }
}
