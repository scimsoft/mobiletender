<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\UnicentaModels\Product;
use App\Traits\UnicentaPayedTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function redirect;
use stdClass;

class AdminReceiptController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $receipts = DB::select("SELECT receipts.id,receipts.datenew, receipts.person, payments.payment, payments.total 
                    FROM receipts, payments
                    where receipts.id = payments.receipt
                    and payments.payment in('cash','tarjeta','online')
                    order by receipts.datenew desc
                    limit 100;");

        return view('admin.receipt.index',compact('receipts'));
    }

    public function delete($id){
            DB::delete("delete from taxlines where receipt = '$id'");
            DB::delete("delete from payments where receipt = '$id'");
            DB::delete("delete from ticketlines where ticket = '$id'");
            DB::delete("delete from tickets where id = '$id'");
            DB::delete("delete from receipts where id = '$id'");
        //INSERT INTO receipts
        //INSERT INTO tickets
        //INSERT INTO ticketline
        //INSERT INTO payments
        //INSERT INTO taxlines
        return $this->index();
    }

    public function edit($id){
        $ticketlines = DB::select("Select * from ticketlines where ticket = '$id'");

        $receiptlines = [];
        foreach ($ticketlines as $ticketline){
            $object = new stdClass();
            $object->id = $ticketline->ticket;
            $object->line = $ticketline->line;
            $product = Product::find($ticketline->product);
            $object->productid = $product->id;
            $object->productname = $product->name;
            $object->price = $ticketline->price;
            $receiptlines[]=$object;

        }

        return view ('admin.receipt.edit',compact('receiptlines'));

    }

    public function deletereceiptline($id,$line){
        DB::delete("DELETE FROM ticketlines where ticket='$id' and line = '$line'");
        $total = DB::select("SELECT SUM(price) as TOTAL from ticketlines where ticket='$id'");


        $totalIVA = $total[0]->TOTAL * 1.1;
        DB::update("UPDATE payments SET total = '$totalIVA' where receipt = '$id'");

        return $this->edit($id);
    }

    public function changepaymenttype(Request $request){
        DB::update("UPDATE payments set payment = '$request->paymenttype' where receipt='$request->ticket_id'");
        return "success";
    }


}
