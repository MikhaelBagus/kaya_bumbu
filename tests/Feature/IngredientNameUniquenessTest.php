<?php

namespace Tests\Feature;

use App\Models\IngredientCategory;
use App\Models\IngredientGroup;
use App\Models\IngredientMaster;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class IngredientNameUniquenessTest extends TestCase
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
            $table->unsignedBigInteger('ingredient_master_group_id');
            $table->string('name');
            $table->string('created_by')->default('');
            $table->string('updated_by')->default('');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('ingredient_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ingredient_master_category_id');
            $table->string('name');
            $table->string('unit');
            $table->double('price')->default(0);
            $table->string('created_by')->default('');
            $table->string('updated_by')->default('');
            $table->timestamps();
            $table->softDeletes();
        });

    }

    public function test_names_are_normalized_and_unique_in_all_ingredient_master_tables(): void
    {
        $group = new IngredientGroup;
        $group->name = '  Bahan   Baku ';
        $group->save();

        $this->assertSame('BAHAN BAKU', $group->fresh()->name);
        $this->assertCodeRejectsDuplicate(function () {
            $duplicate = new IngredientGroup;
            $duplicate->name = 'bahan baku';
            $duplicate->save();
        });

        $category = new IngredientCategory;
        $category->ingredient_master_group_id = $group->id;
        $category->name = 'Produk Olahan & Siap Saji';
        $category->save();

        $this->assertSame('PRODAK OLAHAN & SIAP SAJI', $category->fresh()->name);
        $this->assertCodeRejectsDuplicate(function () use ($group) {
            $duplicate = new IngredientCategory;
            $duplicate->ingredient_master_group_id = $group->id;
            $duplicate->name = 'prodak olahan & siap saji';
            $duplicate->save();
        });

        $ingredient = new IngredientMaster;
        $ingredient->ingredient_master_category_id = $category->id;
        $ingredient->name = 'Thinwall Cup - 100 ml';
        $ingredient->unit = 'pcs';
        $ingredient->price = 0;
        $ingredient->save();

        $this->assertSame('THINWALL CUP - 100ML', $ingredient->fresh()->name);
        $this->assertCodeRejectsDuplicate(function () use ($category) {
            $duplicate = new IngredientMaster;
            $duplicate->ingredient_master_category_id = $category->id;
            $duplicate->name = 'thinwall cup - 100ml';
            $duplicate->unit = 'pcs';
            $duplicate->price = 0;
            $duplicate->save();
        });
    }

    private function assertCodeRejectsDuplicate(callable $callback): void
    {
        try {
            $callback();
            $this->fail('Expected the model uniqueness guard to reject the duplicate.');
        } catch (ValidationException $exception) {
            $this->assertSame(
                ['Nama sudah digunakan. Nama harus unik.'],
                $exception->errors()['name']
            );
        }
    }
}
