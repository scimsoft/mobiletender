<?php
namespace App\Http\Controllers;


use App\UnicentaModels\Product;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;

/**
 * Created by PhpStorm.
 * User: Gerrit
 * Date: 20/10/2020
 * Time: 14:57
 */

class ProductImageController extends Controller
{

    public function getImage($prodcutImageID){
        $productID=explode(".",$prodcutImageID);
        $rendered_buffer= Product::all()->find($productID[0])->image;

        $response = Response::make($rendered_buffer);
        $response->header('Content-Type', 'image/png');
        $response->header('Cache-Control','max-age=2592000');
        return $response;
    }

}