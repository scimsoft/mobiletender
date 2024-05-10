<?php
namespace App\Http\Controllers;


use App\Models\UnicentaModels\Product;
use Illuminate\Support\Facades\Response;
use Illuminate\Routing\Controller;

/**
 * Created by PhpStorm.
 * User: Gerrit
 * Date: 20/10/2020
 * Time: 14:57
 */
class ProductImageController extends Controller
{

    public function getImage($prodcutImageID)
    {
        $productID=explode(".", $prodcutImageID);
        $rendered_buffer= Product::find($productID[0])->image;
        if ($rendered_buffer == null) {
            $rendered_buffer = file_get_contents(public_path('img/no-image.png'));
        }
        $response = Response::make($rendered_buffer);
        $response->header('Content-Type', 'image/png');
        $response->header('Cache-Control', 'max-age=2592000');
        return $response;
    }

}
