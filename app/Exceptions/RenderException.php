<?php

namespace App\Exceptions;

use Exception;
use App\Exceptions\Handler;

class RenderException extends Handler
{
    //
    public function register( )
    {
        $this->reportable(function(InvalidOrderException $e){
            dd('render error fuckoff');
        });
    }
}
