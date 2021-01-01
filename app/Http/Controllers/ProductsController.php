<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use DB;

class ProductsController extends Controller
{
    //
    public function getProducts(){
        $products = Products::all();

        return $products;
    }

    public function samplequery()
    {
        $product = DB::select("SELECT * from products p INNER JOIN sellers s ON p.seller_id = s.seller_id");

        return $product;
    }
}
