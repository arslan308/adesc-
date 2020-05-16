<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Desc extends Model
{ 
    protected $fillable = [
        'shop_domain', 'product_id', 'variant_id','description',
    ];
}
