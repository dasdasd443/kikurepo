<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $primaryKey = 'seller_id';

    public function products()
    {
        return $this->hasMany('App\Models\Products', 'seller_id', 'seller_id');
    }

    public function manager()
    {
        return $this->hasOne('App\Models\User', 'id', 'seller_manager');
    }
}
