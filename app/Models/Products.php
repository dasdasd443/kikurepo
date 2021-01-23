<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';


    public function photos()
    {
        return $this->hasMany('App\Models\Photos', 'product_id', 'product_id');
    }

    public function seller()
    {
        return $this->belongsTo('App\Models\Seller', 'seller_id', 'seller_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Categories','category_id','category_id');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Reviews', 'product_id', 'product_id');
    }
}
