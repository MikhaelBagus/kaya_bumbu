<?php

namespace App\Http\Controllers\Backend;

use App\Models\IngredientMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\Paginator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

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
        $select = [
            'ingredient_masters.*',
        ];

        $dataDb = IngredientMaster::select($select)->category($request->ingredient_category_id)->with('ingredient_category');

        return DataTables::eloquent($dataDb)
            ->addColumn(
                'action',
                function ($dataDb) {
                    return '<a style="font-size: 24px;" href="' . route('ingredient.show', $dataDb->id) . '" id="tooltip" title="' . trans('global.show') . '"><span class="label label-primary label-sm"><i class="fa fa-arrows-alt"></i></span></a>
                        <a style="font-size: 24px;" href="'.route('ingredient.edit', [$dataDb->id]).'" id="tooltip" title="'.trans('global.update').'"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
                        <a style="font-size: 24px;" href="#" data-message="'.trans('auth.delete_confirmation', ['name' => $dataDb->name]).'" data-href="'.route('ingredient.destroy', [$dataDb->id]).'" id="tooltip" data-method="DELETE" data-title="'.trans('global.delete').'" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
                }
            )
            ->addColumn(
                'checkbox',
                function ($dataDb) {
                    return $dataDb->id;
                }
            )
            ->make(true);
    }

    /**
     * Select2 AJAX endpoint
     */
    public function select2(Request $request): JsonResponse
    {
        try {
            $perPage = 10;
            $page    = $request->page ?? 1;
            $term = $request->term;

            Paginator::currentPageResolver(
                function () use ($page) {
                    return $page;
                }
            );

            $count = IngredientMaster::count();

            if($count > $perPage){
                $perPage = $count;
            }

            $dataDb = IngredientMaster::select('id', 'name as text', 'unit')->where('name', 'LIKE', '%'.$request->term.'%')->paginate($perPage);

            return $dataDb;
        }
        catch (\Exception $exception) {
            // dd($exception->getMessage());
            return $exception->getCode();
        }

        // $term = $request->get('term');
        // $page = $request->get('page', 1);
        // $perPage = 10;

        // $query = IngredientMaster::query();
        
        // if ($term) {
        //     $query->where('name', 'like', "%{$term}%");
        // }

        // $ingredients = $query->paginate($perPage, ['*'], 'page', $page);

        // $data = [];
        // foreach ($ingredients as $ingredient) {
        //     $data[] = [
        //         'id' => $ingredient->id,
        //         'text' => $ingredient->name . ' (' . $ingredient->unit . ')'
        //     ];
        // }

        // return response()->json([
        //     'data' => $data,
        //     'pagination' => [
        //         'more' => $ingredients->hasMorePages()
        //     ],
        //     'total' => $ingredients->total(),
        //     'per_page' => $ingredients->perPage()
        // ]);
    }
}