<?php

namespace App\Http\Controllers\Backend;

use App\Models\IngredientMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class IngredientMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('backend.ingredient.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.ingredient.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ingredient_master_category_id' => 'required|exists:ingredient_master_categories,id',
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
        ]);

        $ingredientMaster = IngredientMaster::create($validated);

        $redirectUrl = $request->get('previousUrl', route('ingredient.index'));
        
        return redirect($redirectUrl)
                        ->with('success', 'Ingredient Master created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($ingredient_id): View
    {
        $ingredient = IngredientMaster::with('productRecipes.product')->findOrFail($ingredient_id);
        
        return view('backend.ingredient.detail', compact('ingredient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($ingredient_id): View
    {
        $ingredient = IngredientMaster::findOrFail($ingredient_id);
        
        return view('backend.ingredient.update', compact('ingredient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $ingredient_id): RedirectResponse
    {
        $ingredient = IngredientMaster::findOrFail($ingredient_id);
        
        $validated = $request->validate([
            'ingredient_master_category_id' => 'required|exists:ingredient_master_categories,id',
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
        ]);

        $ingredient->update($validated);

        $redirectUrl = $request->get('previousUrl', route('ingredient.index'));

        return redirect($redirectUrl)
                        ->with('success', 'Ingredient Master updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ingredient_id): RedirectResponse
    {
        $ingredient = IngredientMaster::findOrFail($ingredient_id);
        
        try {
            $ingredient->delete();
            
            return redirect()->route('ingredient.index')
                            ->with('success', 'Ingredient Master deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('ingredient.index')
                            ->with('error', 'Cannot delete ingredient master. It may be used in product recipes.');
        }
    }

    /**
     * DataTable for AJAX requests
     */
    public function datatable(Request $request): JsonResponse
    {
        $query = IngredientMaster::query();

        return DataTables::of($query)
            ->addColumn('checkbox', function ($ingredient) {
                return '<input type="checkbox" name="selected[]" value="' . $ingredient->id . '">';
            })
            ->addColumn('action', function ($ingredient) {
                $actions = '';
                
                $actions .= '<a href="' . route('ingredient.show', $ingredient->id) . '" 
                           class="btn btn-xs btn-primary" title="View">
                           <i class="fa fa-eye"></i></a> ';
                
                $actions .= '<a href="' . route('ingredient.edit', $ingredient->id) . '" 
                           class="btn btn-xs btn-warning" title="Edit">
                           <i class="fa fa-edit"></i></a> ';
                
                $actions .= '<form method="POST" action="' . route('ingredient.destroy', $ingredient->id) . '" 
                           style="display:inline;" onsubmit="return confirm(\'Are you sure?\')">
                           ' . csrf_field() . method_field('DELETE') . '
                           <button type="submit" class="btn btn-xs btn-danger" title="Delete">
                           <i class="fa fa-trash"></i></button></form>';
                
                return $actions;
            })
            ->rawColumns(['checkbox', 'action'])
            ->make(true);
    }

    /**
     * Select2 AJAX endpoint
     */
    public function select2(Request $request): JsonResponse
    {
        $term = $request->get('term');
        $page = $request->get('page', 1);
        $perPage = 10;

        $query = IngredientMaster::query();
        
        if ($term) {
            $query->where('name', 'like', "%{$term}%");
        }

        $ingredients = $query->paginate($perPage, ['*'], 'page', $page);

        $data = [];
        foreach ($ingredients as $ingredient) {
            $data[] = [
                'id' => $ingredient->id,
                'text' => $ingredient->name . ' (' . $ingredient->unit . ')'
            ];
        }

        return response()->json([
            'data' => $data,
            'pagination' => [
                'more' => $ingredients->hasMorePages()
            ],
            'total' => $ingredients->total(),
            'per_page' => $ingredients->perPage()
        ]);
    }
}