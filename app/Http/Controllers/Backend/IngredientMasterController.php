<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Imports\IngredientMasterImport;
use App\Models\IngredientMaster;
use App\Models\Log;
use App\Services\IngredientImport\IngredientPreImportCleanup;
use App\Support\IngredientImportNormalizer;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;
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
        $request->merge([
            'name' => IngredientImportNormalizer::item($request->input('name')),
            'unit' => IngredientImportNormalizer::unit($request->input('unit')),
        ]);

        $validated = $request->validate([
            'ingredient_master_category_id' => 'required|exists:ingredient_master_categories,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('ingredient_masters', 'name'),
            ],
            'unit' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
        ]);

        $ingredientMaster = IngredientMaster::create($validated);

        $redirectUrl = $request->get('previousUrl', route('ingredient.index'));

        return redirect($redirectUrl)
                        ->with('success', 'Ingredient Master created successfully.');
    }

    /**
     * Import BOM category, subcategory, item, and unit from Excel.
     */
    public function importExcel(): RedirectResponse
    {
        $filePath = public_path('imports/Data Ingredient.xlsx');

        if (! is_file($filePath)) {
            return redirect()->route('ingredient.index')
                ->with('failed', 'Import gagal. File public/imports/Data Ingredient.xlsx tidak ditemukan.');
        }

        try {
            $user = Sentinel::getUser();
            $actor = $user ? $user->email : null;

            $result = DB::transaction(function () use ($actor, $filePath) {
                $cleanup = new IngredientPreImportCleanup($actor);
                $cleanupResult = $cleanup->run();
                $import = new IngredientMasterImport($actor);

                Excel::import($import, $filePath);

                return [
                    'cleanup' => $cleanupResult,
                    'import' => $import->result(),
                ];
            });

            $importResult = $result['import'];
            $cleanupResult = $result['cleanup'];
            $message = sprintf(
                'Import selesai: %d baris diproses, %d group baru, %d subcategory baru, %d item baru, %d item diperbarui, dan %d item tidak berubah.',
                $importResult['processed_rows'],
                $importResult['created_groups'],
                $importResult['created_categories'],
                $importResult['created_ingredients'],
                $importResult['updated_ingredients'],
                $importResult['unchanged_ingredients']
            );

            $message .= sprintf(
                ' Pre-import: %d duplikat kosong dihapus dan %d product recipe dikonversi ke gram.',
                count($cleanupResult['deleted_duplicate_items']),
                collect($cleanupResult['converted_recipes'])->sum('recipe_count')
            );

            if ($importResult['category_group_mismatches'] > 0) {
                $message .= sprintf(
                    ' %d baris dengan group berbeda mengikuti relasi subcategory yang sudah ada.',
                    $importResult['category_group_mismatches']
                );
            }

            return redirect()->route('ingredient.index')->with('success', $message);
        } catch (ValidationException $exception) {
            $message = collect($exception->errors())->flatten()->first()
                ?? 'Import gagal karena isi file Excel tidak valid.';

            return redirect()->route('ingredient.index')
                ->with('failed', $message);
        } catch (Throwable $exception) {
            report($exception);

            return redirect()->route('ingredient.index')
                ->with('failed', 'Import gagal. Tidak ada data yang disimpan. Silakan periksa format dan isi file Excel.');
        }
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

        $request->merge([
            'name' => IngredientImportNormalizer::item($request->input('name')),
            'unit' => IngredientImportNormalizer::unit($request->input('unit')),
        ]);

        $validated = $request->validate([
            'ingredient_master_category_id' => 'required|exists:ingredient_master_categories,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('ingredient_masters', 'name')->ignore($ingredient->id),
            ],
            'unit' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
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
        $ingredientDb = IngredientMaster::findOrFail($ingredient_id);

        try {
            if(!$ingredientDb->productRecipes->isEmpty()){

                return redirect()->route('ingredient.index')
                            ->with('failed', 'Failed To Delete Ingredient');
            }
            else{
                $ingredientDb->deleted_by = Sentinel::getUser()->email;
                $ingredientDb->save();

                $logDb = new Log();
                $logDb->user_id     = Sentinel::getUser()->id;
                $logDb->action      = 'Delete '.$ingredientDb->name;
                $logDb->menu        = 'Ingredient Group';
                $logDb->item_id     = $ingredientDb->id;
                $logDb->created_by  = Sentinel::getUser()->email;
                $logDb->save();

                IngredientMaster::where('id', $ingredient_id)->delete();

                return redirect()->route('ingredient.index')
                            ->with('success', 'Ingredient Master deleted successfully.');
            }
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

        $dataDb = IngredientMaster::select($select)->category($request->ingredient_category_id)->group($request->ingredient_group_id)->with('ingredient_category','ingredient_category.ingredient_group');

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
    public function select2(Request $request)
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

            $dataDb = IngredientMaster::select('id', 'name as text', 'unit', 'price')->where('name', 'LIKE', '%'.$request->term.'%')->paginate($perPage);

            return $dataDb;
        }
        catch (\Exception $exception) {
            // dd($exception->getMessage());
            return $exception->getMessage();
        }
    }
}
