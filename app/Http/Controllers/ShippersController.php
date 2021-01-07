<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Shippers;

class ShippersController extends Controller
{
    //
    function availableShippers()
    {
        $shippers = Shippers::all();

        return $shippers;
    }
}
