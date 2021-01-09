<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    //
    public function requestUser()
    {
        return Auth::user();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/dashboard');
    }

    public function checkoutPayment(Request $request) 
    {
        // Set your secret key. Remember to switch to your live secret key in production!
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey('sk_test_51HuvwMJuH4Qnm7aCavhjtXrVXW2W36fHq0xoD6ZHLowZp8Rp1rXAbSS9ms4azLGkohUQ3o185nrwRBJSqRmV69eH001Rl5VbPc');

        $intent = \Stripe\PaymentIntent::create([
        'amount' => $request->payment,
        'currency' => 'usd',
        // Verify your integration in this guide by including this parameter
        'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);

        echo json_encode(array('client_secret' => $intent->client_secret));
    }

    public function addToCart(Request $request)
    {
        
        if(isset($_COOKIE['cart_orders']))
        {
            $encoded_cart_orders = $_COOKIE['cart_orders'];

            $decoded_cart_orders = json_decode($encoded_cart_orders,true);

            $product_id = $request->product_id;

            $isFound = false;

            foreach ($decoded_cart_orders as &$item)
            {
                if ($item["product_id"] == $product_id)
                {
                    $isFound = true;
                    $item["quantity"]+=1;
                    
                    break;
                }
            }

            if(!$isFound)
            {
                $array = array('product_id'=>$product_id,'quantity'=>1);
                array_push($decoded_cart_orders,$array);
            }
            echo json_encode($decoded_cart_orders);
            
            setcookie('cart_orders',json_encode($decoded_cart_orders),time() +  7 * 24 * 60 * 60 * 1000);

            
        }
        else
        {
            $item = array(array('product_id'=>$request->product_id,'quantity'=>1));

            setcookie('cart_orders',json_encode($item),time() +  7 * 24 * 60 * 60 * 1000);
        }

        
    }
}
