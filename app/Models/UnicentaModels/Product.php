<?php

namespace App\Models\UnicentaModels;


use App\Models\ProductAdOn;


use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    use Uuids;

    protected $table = 'products';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'name', 'pricebuy','pricesell','code','reference','taxcat','category', 'detail'
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category');
    }

    public function product_cat(){
        return $this->hasOne(Products_Cat::class,'product','id');
    }

    public function product_addons(){
        return $this->hasMany(ProductAdOn::class,'product_id','id');
    }

}
