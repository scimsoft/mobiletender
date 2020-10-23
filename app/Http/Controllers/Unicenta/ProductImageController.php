<?php
namespace App\Http\Controllers;


use App\UnicentaModels\Product;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
/*
 * Controller to serve Image Blobs as images
 * adding cache headers for browser caching
 * TODO adding the png extension in blade and exploding in controller a bit ugly*/
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