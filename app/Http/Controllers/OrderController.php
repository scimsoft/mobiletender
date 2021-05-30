<?php

namespace App\Http\Controllers;

use App\Models\ProductAdOn;
use App\Models\UnicentaModels\Category;
use App\Traits\SharedTicketTrait;

use App\Models\UnicentaModels\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Traits\ProductTrait;
use Illuminate\Support\Str;
use function json_encode;


class OrderController extends Controller
{
    use SharedTicketTrait;
    use ProductTrait;
    protected $categories;

    public function order()
    {
        $this->checkForSessionTicketId();
        $totalBasketPrice = $this->getTotalBasketValue();
        $categories = Category::where('catshowname',1 )->orderByRaw('CONVERT(catorder, SIGNED)')->get();
        $products = $this->getCategoryProducts($categories[0]->id);

        return view('order.order', compact(['categories','products','totalBasketPrice']));
    }
    public function menu()
    {
        $this->checkForSessionTicketId();
        $totalBasketPrice = $this->getTotalBasketValue();
        $categories = Category::orderByRaw('CONVERT(catorder, SIGNED)')->get();
        $products = $this->getCategoryProducts($categories[0]->id);
        return view('order.menu', compact(['categories','products','totalBasketPrice']));
    }

    public function orderForTableNr($tablenumber)
    {
        $ticketID = Session::get('ticketID');
       // Log::debug('checkForSessionTicketId: Session TicketID: ' . $ticketID);
       // Log::debug('checkForSessionTicketId: is_null: ' . is_null($ticketID));
       // Log::debug('checkForSessionTicketId: hasTicket: ' . $this->hasTicket($ticketID));
        Session::put('ticketID',$tablenumber);
        Session::put('tableNumber',$tablenumber);
        $webadmin = Auth::check() && Auth::user()->isWaiter();
        //dd($webadmin);
        //TODO posible ver si mesa no esta vacio pero no tiene productos
        if (($this->hasTicket($tablenumber) < 1)) {
            if($this->hasTicket($ticketID)>0 && !$webadmin ){
                $this->moveTable($ticketID,$tablenumber);
                return redirect()->route('checkout');
            }else {
                $this->saveEmptyTicket($this->createEmptyTicket(), $tablenumber);
            }
        }

        return $this->order();


    }

    public function showProductsFromCategoryForMenu($category){

        $products = $this->getCategoryProducts($category);
        $totalBasketPrice = $this->getTotalBasketValue();
        $categories = Category::orderByRaw('CONVERT(catorder, SIGNED)')->get();
        return view('order.menu', compact(['categories','products','totalBasketPrice']));
    }
    public function showProductsFromCategory($category){
        $this->checkForSessionTicketId();
        $products = $this->getCategoryProducts($category);
        $totalBasketPrice = $this->getTotalBasketValue();
        $categories = Category::orderBy('catorder')->get();
        return view('order.order', compact(['categories','products','totalBasketPrice']));
    }

    public function addProduct($productID){
        $product[] = Product::all()->find($productID);
        $this->addProductsToTicket($product,Session::get('ticketID'));
        $totalBasketValue = $this->getTotalBasketValue();
        $addOnProducts=ProductAdOn::where('product_id',$productID)->get();
        $addOnProductsName=[];
        foreach ($addOnProducts as $addOnProduct){
            $addOnProductsName[]=[$addOnProduct->adon_product_id,Product::find($addOnProduct->adon_product_id)->name,$addOnProduct->price];
        }


        return [json_encode($totalBasketValue),json_encode($addOnProductsName)];
    }

    public function addAddOnProduct(){
        $productID = request()->get('product_id');
        $price = request()->get('price');
        $product[] = Product::all()->find($productID);
        $product[0]->pricesell=$price/1.1;
        $this->addProductsToTicket($product,Session::get('ticketID'));
        $totalBasketValue = $this->getTotalBasketValue();
        return json_encode($totalBasketValue);
    }

    public function cancelProduct($ticketLine){
        $this->removeTicketLine(Session::get('ticketID'),$ticketLine);
        return redirect()->route('basket');
    }

    public function showBasket(){
        $unprintedlines = false;
        $ticketLines=$this->getTicket(Session::get('ticketID'))->m_aLines;
        foreach ($ticketLines as $ticketLine){
            $products[]=Product::all()->find($ticketLine->productid);
            if($ticketLine->attributes->updated == "true"){
                $unprintedlines = true;
            }
            $lines[]=$ticketLine;
        }
        $totalBasketPrice = $this->getTotalBasketValue();
        if(isset($lines)){
            return view('order.basket',compact(['lines','totalBasketPrice','unprintedlines']));
        } else{
            return redirect()->route('order');
        }
    }

    public function checkForSessionTicketId()
    {
        $ticketID = Session::get('ticketID');
//        Log::debug('checkForSessionTicketId: Session TicketID: '.$ticketID);
//        Log::debug('checkForSessionTicketId: is_null: '.is_null($ticketID));
//        Log::debug('checkForSessionTicketId: hasTicket: '.$this->hasTicket($ticketID));
        if (is_null($ticketID) or ($this->hasTicket($ticketID)<1)){
            $ticket = $this->createEmptyTicket();
            $newTicketID = Str::uuid()->toString();
            $this->saveEmptyTicket($ticket, $newTicketID);
            Session::put('ticketID',$newTicketID);
            Session::forget('tableNumber');
        }
    }





    private function getTotalBasketValue()
    {
        $totalBasket = $this->getSumTicketLines(Session::get('ticketID'));
        return $totalBasket;
    }




}
