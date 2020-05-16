<?php

namespace App;

use Illuminate\Database\Eloquent\Model; 

class Shop extends Model
{
    protected $softDelete = true;
    protected $fillable = [
        'user_id','domain', 'access_token', 
    ];

    //
}
