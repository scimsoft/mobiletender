<?php
namespace App\Traits;

use App\UnicentaModels\Product;
use Illuminate\Support\Facades\Log;

trait ProductTrait{



    public function getCategoryProducts($id)
    {
        switch ($id) {
            case 'DRINKS':
            case '4fabf8cc-c05c-492c-91cb-f0b751d41cee':
                $products = Product::where('category', '4fabf8cc-c05c-492c-91cb-f0b751d41cee')->orderBy('name')->paginate(200);
                //dd($products);
                break;

            case 'FOOD':
            case 'bc143237-358d-4899-a170-5e7ba308e9a3':
                $products = Product::where('category', 'bc143237-358d-4899-a170-5e7ba308e9a3')
                    ->orWhere('category','a9769f52-af9f-4e80-8594-034ee3d18304')
                    ->orderBy('name')->paginate(200);
                break;

            case 'COFFEE':
            case '05b70271-edd3-48b9-8f28-13ac701372a9':
                $products = Product::where('category', '05b70271-edd3-48b9-8f28-13ac701372a9')->orderBy('name')->paginate(200);
                break;

            case 'COCTELES':
            case 'c6fc7eaa-2f80-4a4e-bdea-bac9e070089f':
                $products = Product::where('category', 'c6fc7eaa-2f80-4a4e-bdea-bac9e070089f')->orderBy('name')->paginate(200);
                break;

            case 'COPAS':
            case '9b4abf09-14e8-45db-97fa-1062c4c24574':
                $products = Product::where('category', '9b4abf09-14e8-45db-97fa-1062c4c24574')->orderBy('name')->paginate(200);
                break;

            case 'VINOS':
            case 'f91c6698-c108-4cb7-a691-216e587fd8a8':
                $products = Product::where('category', 'f91c6698-c108-4cb7-a691-216e587fd8a8')->orderBy('name')->paginate(200);
                break;

            case 'OTROS':
                $products = Product::where('category','0983bed0-8f5c-45c4-bfd4-d0b59152646f')
                    ->orWhere('category','51fd59b5-578f-4d66-b00b-f46c33336df2')
                    ->orWhere('category','26c209c2-d731-4e24-938b-d87ebaa2b7d9')
                    ->orWhere('category','fb462214-11ca-4e17-8ac5-4f24d68e7ba2')->orderBy('CATEGORY')->paginate(200);;
                break;
            default:
                $products = [];
        }

        //Log::debug('productos en product controller getproductsformcategory');
        foreach ($products as $product) {
            // Log::debug('productos en product controller getproductsformcategory'.$product);
            if (!empty($product->image)) {
                $product->image = base64_encode($product->image);
            }

        }
        return $products;
    }
}