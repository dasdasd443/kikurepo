<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Exceptions\Handler;

use App\Models\Products;
use App\Models\Categories;
use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

use DB;

class RenderController extends Controller
{
    //
    public function dashboard()
    {
        return Inertia::render('Dashboard');
    }

    public function browse($category = null)
    {   

        if($category == null)
        {
            $products = Products::all();
            return Inertia::render('ShowProducts',['products'=>$products]);
        }
        else
        {
            $category = str_replace("-"," ",$category);

            $category_id = Categories::where('category_name','like','%'.$category.'%')->get();

            $products = DB::select("SELECT * from products p INNER JOIN sellers s ON p.seller_id = s.seller_id
            WHERE category_id LIKE '%".$category_id[0]["category_id"]."%'");

            //$products = Products::where('category_id',$category_id[0]["category_id"])->get();

            return Inertia::render('ShowProducts',['products' => $products]);
        }
    }

    public function product_details($product_id)
    {
        $product = Products::find($product_id);
        $product_photos = $product->photos()->get();
        $product_reviews = array("product_reviews" => $product->reviews()->get(),"average"=>$product->reviews()->avg('product_stars'),"count"=>$product->reviews()->count());

        return Inertia::render('ProductPage',['product_details' => $product,'product_photos' => $product_photos,'product_reviews'=>$product_reviews]);
    }

    public function my_cart(Request $request)
    {
        if(isset($_COOKIE['cart_orders']))
        {
            $get_cart_cookie = $_COOKIE['cart_orders'];

            $decoded_cart_cookie = json_decode($get_cart_cookie);

            $cart_array = array();

            foreach ($decoded_cart_cookie as $value)
            {
                $product_details = array(
                    Products::find($value->product_id),
                    $value->quantity,
                    Products::find($value->product_id)->photos->take(1)
                );
                array_push($cart_array,$product_details);
            }
        }else{
            $cart_array = 0;
            $decoded_cart_cookie = 0;
        }

        if(Auth::check())
        {
            $addresses = array(
                'billing_address' => Address::find(User::find(Auth::id())->pluck('billing_address'))->first(),
                'shipping_address' => Address::find(User::find(Auth::id())->pluck('shipping_address'))->first()
            );
        }
        else
        {
            $addresses = 0;
        }
        
        //return $cart_array;
        return Inertia::render('Profile/MyCart',['cart_details' => $cart_array,"cart_cookie" => $decoded_cart_cookie,"addresses"=>$addresses]);
    }
}
