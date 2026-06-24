<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\ProductIngredientImport;
use App\Imports\IngredientMasterImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
	public function index() 
    {
        // Excel::import(new ProductIngredientImport, 'ImportIngredient.xlsx');
        // Excel::import(new ProductIngredientImport, 'UpdateIngredient.xlsx');
        Excel::import(new IngredientMasterImport, 'ImportIngredientMaster.xlsx');
        
        return view('backend.product.index');
    }
}