<?php

namespace App\Http\Controllers;

use App\Traits\SharedTicketTrait;

use App\UnicentaModels\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Traits\ProductTrait;
use Illuminate\Support\Str;



class OrderController extends Controller
{
    //
    use SharedTicketTrait;
    use ProductTrait;

    public function order()
    {
        $this->checkForSessionTicketId();
        $totalBasketPrice = $this->getTotalBasketValue();
        $products = $this->getCategoryProducts('DRINKS');
        return view('order.order', compact(['products','totalBasketPrice']));
    }

    public function showProductsFromCategory($category){
        $products = $this->getCategoryProducts($category);
        $totalBasketPrice = $this->getTotalBasketValue();
        return view('order.order', compact(['products','totalBasketPrice']));
    }

    public function addProduct($productID){
        $product[] = Product::all()->find($productID);
        $this->addProductsToTicket($product,Session::get('ticketID'));
        return $this->getTotalBasketValue();
    }

    private function checkForSessionTicketId()
    {
        $ticketID = Session::get('ticketID');
        Log::debug('checkForSessionTicketId: Session TicketID: '.$ticketID);
        if (is_null($ticketID)){
            $ticket = $this->createEmptyTicket();
            $newTicketID = Str::uuid()->toString();
            $this->saveEmptyTicket($ticket, $newTicketID);
            Session::put('ticketID',$newTicketID);
        }
    }



    private function getTotalBasketValue()
    {
        $totalBasket = $this->getSumTicketLines(Session::get('ticketID'));
        return $totalBasket;


    }



//    public function menu(){
//        $controllerproducts = $this->getCategoryProducts('FOOD');
//        return view('order.menu', compact('controllerproducts'));
//    }
//
//
//    public function addOrderLine(Request $request){
//        Log::debug("Entering controller: ".$request->get('orderline'));
//        $inputArray = json_decode($request->get('orderline'),true);
//        $orderline = new MobileOrderLines();
//        $orderline->mobile_order_id = Session::get('order_id');
//        $orderline->product_ID = $inputArray[1];
//        $orderline->price = $inputArray[2];
//        $orderline->save();
//        return response()->json(['status' => true]);
//    }
//
//    public function addProduct($productID)
//    {
//
//        $orderline = new MobileOrderLines();
//        $orderline->mobile_order_id = Session::get('order_id');
//        $orderline->product_ID = $productID;
//        $product = Product::find($productID);
//        $orderline->price = $product->pricesell;
//        $productcategory = $product->category;
//        Log::debug('Getting product price del producto: '.$productID);
//        Log::debug('Getting product price: '.$product->pricesell);
//        $orderline->save();
//        $controllerproducts = $this->getCategoryProducts($productcategory);
//        Session::put('status','Producto añadido');
//        return response()->json(['status' => true]);
//        //return view('order.neworder', compact('controllerproducts'));
//    }
//
//    public function getOrderTotal($id){
//        Log::debug('Entered in getOrderTotal with order_id:'.$id);
//
//      // Log::debug('mobileOrderLines:'.MobileOrder::find($id)->mobileOrderLines->sum('price'));
//        if(MobileOrder::find($id)->mobileOrderLines) {
//
//            $order_total = MobileOrder::find($id)->mobileOrderLines->sum('price');
//            Session::put('order_total',$order_total);
//            return $order_total;
//        }else{
//            return '0.00';
//        }
//
//    }
//
//    public function getBasket($id=null){
//        Log::debug('Entered in getBasket($id) wuth id:'.$id);
//        Session::remove('status');
//        $pendientesDePedir=false;
//        $sePuedePagar=false;
//        if(!empty($id)) {
//            $order = MobileOrder::find($id);
//            $orderlines = $order->mobileOrderLines;
//            foreach ($orderlines as $orderline) {
//                if ($orderline->printed == 0) $pendientesDePedir = true;
//
//            }
//            if($pendientesDePedir==false || $order->status < 2) $sePuedePagar=true;
//            return view('order.basket',compact('orderlines','sePuedePagar','pendientesDePedir'));
//        }else{
//            redirect()->action('HomeController@index');
//        }
//
//    }
//
//    public function destroyOrderLine($id)
//    {
//        $orderline = MobileOrderLines::find($id);
//        $orderid = $orderline->mobileOrder->id;
//        if ($orderline->printed) {
//            Session::put('status', 'No se puede eliminar este producto');
//        } else {
//
//        Session::put('status', 'Producto elimnado');
//
//
//        $orderline->delete();
//        Session::flash('message', 'Successfully deleted the nerd!');
//    }
//       return $this->getBasket($orderid);
//    }
//

//
//    public function getProductsFromCategoryforAdmin($id){
//        Session::put('status','');
//        $products = $this->getCategoryProducts($id);
//        return view('admin.products.index', compact('products'));
//    }
//
//    /**
//     * @param $id
//     * @return mixed
//     */

//    public function callwaiter($id){
//        $order = MobileOrder::find($id);
//        $order -> status = 9;
//        $order -> save();
//
//    }
//
//    /**
//     * @param $tablename
//     */
//    public function createNewOrder($tablename)
//    {
//        Log::debug("Entering index -- creando order_id");
//        $order = new MobileOrder();
//        $order->status = 1;
//
//            $order->table_number = $tablename;
//            Session::put('table_number', $tablename);
//
//        $order->save();
//        Session::put('order_id', $order->id);
//    }
//
//    /**
//     * @param $tablename
//     */
//    public function getOrderFromUnicenta($tablename,$unicenta)
//    {
//        Log::debug('Entered in recovering shared ticket');
//        $mobileorder = MobileOrder::where('table_number', $tablename)->where('status', '<', 2)->latest('updated_at')->first();;
//        if(!empty($mobileorder)) {
//            $orderlines = $mobileorder->mobileOrderLines;
//            foreach ($orderlines as $orderline) {
//                $orderline->forceDelete();
//            }
//        }else{
//            $mobileorder = new MobileOrder();
//            $mobileorder->table_number = $tablename;
//            $mobileorder->save();
//        }
//        $productlists = json_decode($unicenta->content)->m_aLines;
//
//        foreach ($productlists as $productlist) {
//            $mobileorderline=new MobileOrderLines();
//            $mobileorderline->mobile_order_id = $mobileorder->id;
//            $mobileorderline->product_id=$productlist->productid;
//            $mobileorderline->price = $productlist->price;
//            $mobileorderline->printed = 1;
//            $mobileorderline->save();
//                   }
//
//
//
//
//
//        Session::put('order_id', $mobileorder->id);
//        Session::put('table_number', $tablename);
//    }
}
