<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use DB;
use Validator;

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

    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'preview-image' => 'image|required|max:1999',
            'product-name' => 'required|min:6'
        ]);

        if($validator->fails()){
            return json_encode($validator->messages());
        }

    }
}
