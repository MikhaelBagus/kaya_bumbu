<?php

namespace App\Http\Controllers\Backend;

use App\Models\IngredientMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;

class IngredientMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $ingredientMasters = IngredientMaster::paginate(15);
        
        return view('ingredient-masters.index', compact('ingredientMasters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('ingredient-masters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
        ]);

        $ingredientMaster = IngredientMaster::create($validated);

        return redirect()->route('ingredient-masters.index')
                        ->with('success', 'Ingredient Master created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(IngredientMaster $ingredientMaster): View
    {
        $ingredientMaster->load('productRecipes.product');
        
        return view('ingredient-masters.show', compact('ingredientMaster'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IngredientMaster $ingredientMaster): View
    {
        return view('ingredient-masters.edit', compact('ingredientMaster'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IngredientMaster $ingredientMaster): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
        ]);

        $ingredientMaster->update($validated);

        return redirect()->route('ingredient-masters.index')
                        ->with('success', 'Ingredient Master updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IngredientMaster $ingredientMaster): RedirectResponse
    {
        try {
            $ingredientMaster->delete();
            
            return redirect()->route('ingredient-masters.index')
                            ->with('success', 'Ingredient Master deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('ingredient-masters.index')
                            ->with('error', 'Cannot delete ingredient master. It may be used in product recipes.');
        }
    }

    /**
     * API: Get all ingredient masters
     */
    public function apiIndex(): JsonResponse
    {
        $ingredientMasters = IngredientMaster::all();
        
        return response()->json([
            'success' => true,
            'data' => $ingredientMasters
        ]);
    }

    /**
     * API: Get specific ingredient master
     */
    public function apiShow(IngredientMaster $ingredientMaster): JsonResponse
    {
        $ingredientMaster->load('productRecipes.product');
        
        return response()->json([
            'success' => true,
            'data' => $ingredientMaster
        ]);
    }

    /**
     * API: Store new ingredient master
     */
    public function apiStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
        ]);

        $ingredientMaster = IngredientMaster::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ingredient Master created successfully',
            'data' => $ingredientMaster
        ], 201);
    }

    /**
     * API: Update ingredient master
     */
    public function apiUpdate(Request $request, IngredientMaster $ingredientMaster): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
        ]);

        $ingredientMaster->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ingredient Master updated successfully',
            'data' => $ingredientMaster
        ]);
    }

    /**
     * API: Delete ingredient master
     */
    public function apiDestroy(IngredientMaster $ingredientMaster): JsonResponse
    {
        try {
            $ingredientMaster->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Ingredient Master deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete ingredient master. It may be used in product recipes.'
            ], 400);
        }
    }
}