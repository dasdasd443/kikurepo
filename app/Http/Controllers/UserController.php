<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function checkoutPayment() {
        // Set your secret key. Remember to switch to your live secret key in production!
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey('sk_test_51HuvwMJuH4Qnm7aCavhjtXrVXW2W36fHq0xoD6ZHLowZp8Rp1rXAbSS9ms4azLGkohUQ3o185nrwRBJSqRmV69eH001Rl5VbPc');

        $intent = \Stripe\PaymentIntent::create([
        'amount' => 1099,
        'currency' => 'usd',
        // Verify your integration in this guide by including this parameter
        'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);

        echo json_encode(array('client_secret' => $intent->client_secret));
    }
}
