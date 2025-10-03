<?php

namespace App\Http\Controllers\Backend;

use App\Models\ProductRecipe;
use App\Models\Product;
use App\Models\IngredientMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class ProductRecipeController extends Controller
{
    public function index(): View
    {
        return view('backend.product.recipe.index');
    }

    public function create(): View
    {
        $products = Product::all();
        $ingredientMasters = IngredientMaster::all();

        return view('backend.product.recipe.create', compact('products', 'ingredientMasters'));
    }

    public function store(Request $request): RedirectResponse | JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:product,id',
            'ingredient_master_id' => 'required|exists:ingredient_masters,id',
            'qty' => 'required|numeric|min:0',
        ]);

        $existingRecipe = ProductRecipe::where('product_id', $validated['product_id'])
                                     ->where('ingredient_master_id', $validated['ingredient_master_id'])
                                     ->first();

        if ($existingRecipe) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This ingredient is already added to the product recipe.',
                ], 400);
            }

            return redirect()->back()
                           ->withInput()
                           ->with('error', 'This ingredient is already added to the product recipe.');
        }

        $productRecipe = ProductRecipe::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product Recipe created successfully.',
                'data' => $productRecipe->load('ingredientMaster')
            ]);
        }

        if ($request->has('from_edit')) {
            return redirect()->route('product.recipe.edit', $validated['product_id'])
                            ->with('success', 'Ingredient added successfully.');
        }

        return redirect()->route('product.recipe.index')
                        ->with('success', 'Product Recipe created successfully.');
    }

    public function show(ProductRecipe $productRecipe): View
    {
        $productRecipe->load(['product', 'ingredientMaster']);
        
        return view('product-recipes.show', compact('productRecipe'));
    }

    public function edit($product_id): View
    {
        $product = Product::with(['product_recipes.ingredientMaster'])->findOrFail($product_id);
        $ingredientMasters = IngredientMaster::all();

        return view('backend.product.recipe.update', compact('product', 'ingredientMasters'));
    }

    public function update(Request $request, $recipe_id): RedirectResponse | JsonResponse
    {
        $productRecipe = ProductRecipe::findOrFail($recipe_id);
        
        if ($request->ajax() && $request->has('qty') && !$request->has('ingredient_master_id')) {
            $validated = $request->validate([
                'qty' => 'required|numeric|min:0',
            ]);
            
            $productRecipe->update(['qty' => $validated['qty']]);
            
            return response()->json([
                'success' => true,
                'message' => 'Quantity updated successfully.',
                'data' => $productRecipe->load('ingredientMaster')
            ]);
        }
        
        $validated = $request->validate([
            'product_id' => 'required|exists:product,id',
            'ingredient_master_id' => 'required|exists:ingredient_masters,id',
            'qty' => 'required|numeric|min:0',
        ]);

        if ($productRecipe->ingredient_master_id != $validated['ingredient_master_id']) {
            $existingRecipe = ProductRecipe::where('product_id', $validated['product_id'])
                                         ->where('ingredient_master_id', $validated['ingredient_master_id'])
                                         ->where('id', '!=', $recipe_id)
                                         ->first();

            if ($existingRecipe) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This ingredient is already added to the product recipe.',
                    ], 400);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'This ingredient is already added to the product recipe.');
            }
        }

        $productRecipe->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product Recipe updated successfully.',
                'data' => $productRecipe->load('ingredientMaster')
            ]);
        }

        return redirect()->route('product.recipe.edit', $productRecipe->product_id)
                        ->with('success', 'Product Recipe updated successfully.');
    }

    public function destroy($recipe_id): JsonResponse|RedirectResponse
    {
        $productRecipe = ProductRecipe::findOrFail($recipe_id);
        $product_id = $productRecipe->product_id;
        $productRecipe->delete();
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product Recipe deleted successfully.'
            ]);
        }
        
        return redirect()->route('product.recipe.edit', $product_id)
                        ->with('success', 'Product Recipe deleted successfully.');
    }

    public function getByProduct(Product $product): View
    {
        $productRecipes = ProductRecipe::with('ingredientMaster')
                                     ->where('product_id', $product->id)
                                     ->get();
        
        return view('product-recipes.by-product', compact('productRecipes', 'product'));
    }

    public function datatable(Request $request): JsonResponse
    {
        $products = Product::with(['product_recipes.ingredientMaster'])
                          ->select('product.*')
                          ->get();

        $data = [];
        foreach ($products as $index => $product) {
            $ingredientsCount = $product->product_recipes->count();
            
            $data[] = [
                'id' => $product->id,
                'checkbox' => '<input type="checkbox" name="selected[]" value="' . $product->id . '">',
                'name' => $product->name,
                'ingredients_count' => $ingredientsCount,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
                'action' => $this->generateActionButtons($product),
                'ingredients' => $product->product_recipes->map(function($recipe) {
                    return [
                        'id' => $recipe->id,
                        'ingredient_name' => $recipe->ingredientMaster->name,
                        'ingredient_unit' => $recipe->ingredientMaster->unit,
                        'qty' => $recipe->qty,
                    ];
                })
            ];
        }

        return response()->json([
            'draw' => $request->get('draw'),
            'recordsTotal' => $products->count(),
            'recordsFiltered' => $products->count(),
            'data' => $data
        ]);
    }

    private function generateActionButtons($product): string
    {
        $buttons = '';
        
        $buttons .= '<a href="' . route('product.recipe.edit', ['product_id' => $product->id]) . '" 
                        class="btn btn-xs btn-success" title="Edit Recipe">
                        <i class="fa fa-edit"></i>
                    </a> ';

        return $buttons;
    }

}