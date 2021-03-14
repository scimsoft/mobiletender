<?php

namespace App\Models\UnicentaModels;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //

    protected $table = 'categories';
    protected $keyType = 'string';


    public function products()
    {
        return $this->hasMany('App\Product','CATEGORY','ID');
    }

}
