<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\ProductIngredientImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
	public function index() 
    {
        Excel::import(new ProductIngredientImport, 'ImportIngredient.xlsx');
        // Excel::import(new ProductIngredientImport, 'UpdateIngredient.xlsx');
        
        return view('backend.product.index');
    }
}