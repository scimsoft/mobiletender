<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UnicentaModels\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use function is_null;

class AdminStockController extends Controller
{
    //

    public function currentStockIndex($cat = null){
        $categories = Category::orderByRaw('CONVERT(catorder, SIGNED)')->get();
        if(!is_null($cat)){
            $currentStockQuery="SELECT id ,name, units FROM  products left join stockcurrent  on stockcurrent.product = products.id where products.category='$cat'";
        }else{
            $currentStockQuery="SELECT id ,name, units FROM  products left join stockcurrent  on stockcurrent.product = products.id;";
        }
            $stocks= DB::select($currentStockQuery);
        return view('admin.stock.index',compact('stocks','categories'));


    }


    public function addStock(Request $request){

        $product_id = $request->product_id;
        $units = $request->units;
        $stockDiaryID=Str::uuid();
        $datenew = Carbon::now();
        $insertStockDairy = "INSERT INTO stockdiary (ID, DATENEW, REASON, LOCATION, PRODUCT, ATTRIBUTESETINSTANCE_ID, UNITS, PRICE, AppUser) VALUES ('$stockDiaryID', '$datenew', 1, '0', '$product_id', null, '$units', 0, 'stockApp')";
        DB::insert($insertStockDairy);
        //Log::debug('Insert Stock'.$insertStockDairy);
        $updateStockSQL = ("UPDATE stockcurrent SET UNITS = (UNITS + ' $units') WHERE LOCATION = '0' AND PRODUCT = '$product_id' AND ATTRIBUTESETINSTANCE_ID IS NULL");
        $control = DB::update($updateStockSQL);
        if (!$control) {
            $insertStockCurrent = "INSERT INTO stockcurrent (LOCATION, PRODUCT, ATTRIBUTESETINSTANCE_ID, UNITS) VALUES ('0', '$product_id', null, ' $units')";
            DB::insert($insertStockCurrent);
        }
        return $updateStockSQL ;


    }

}
