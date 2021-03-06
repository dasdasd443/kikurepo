<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    use HasFactory;

    protected $primaryKey = 'photo_id';

    public function product(){
        return $this->belongsTo('App\Models\Products','product_id','product_id');
    }
}
