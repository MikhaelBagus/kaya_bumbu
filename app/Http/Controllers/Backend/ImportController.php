<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\ProductIngredientImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
	public function import1() 
    {
        Excel::import(new ProductIngredientImport, 'PRODUCTUPDATE.xlsx');
        
        return view('backend.product.index');
    }
}