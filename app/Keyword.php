<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    const AREA     = '1';
    const GENRE    = '2';
    const STATION  = '3';
    const REDIRECT = 'redirect';
    protected $table    = "keywords";
    public $timestamps  = false;
    protected $fillable = ['keywords','area','genre','url_shop_search','url_product_search'];
}
