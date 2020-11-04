<?php

namespace App\Http\Controllers;

use App\Models\ProductAdOn;
use App\Traits\SharedTicketTrait;

use App\UnicentaModels\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Traits\ProductTrait;
use Illuminate\Support\Str;
use function json_decode;
use function json_encode;


class OrderController extends Controller
{
    use SharedTicketTrait;
    use ProductTrait;

    public function order()
    {
        $this->checkForSessionTicketId();
        $totalBasketPrice = $this->getTotalBasketValue();
        $products = $this->getCategoryProducts('DRINKS');
        return view('order.order', compact(['products','totalBasketPrice']));
    }

    public function orderForTableNr($tablenumber)
    {
        $ticketID = Session::get('ticketID');
        Log::debug('checkForSessionTicketId: Session TicketID: ' . $ticketID);
        Log::debug('checkForSessionTicketId: is_null: ' . is_null($ticketID));
        Log::debug('checkForSessionTicketId: hasTicket: ' . $this->hasTicket($ticketID));
        if (($this->hasTicket($tablenumber) < 1)) {
            $this->saveEmptyTicket($this->createEmptyTicket(), $tablenumber);
        }
            Session::put('ticketID',$tablenumber);
            Session::put('tableNumber',$tablenumber);
            return $this->order();

    }


    public function showProductsFromCategory($category){
        $this->checkForSessionTicketId();
        $products = $this->getCategoryProducts($category);
        $totalBasketPrice = $this->getTotalBasketValue();
        return view('order.order', compact(['products','totalBasketPrice']));
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
        $ticketLines=$this->getTicket(Session::get('ticketID'))->m_aLines;
        foreach ($ticketLines as $ticketLine){
            $products[]=Product::all()->find($ticketLine->productid);
            $lines[]=$ticketLine;
        }
        $totalBasketPrice = $this->getTotalBasketValue();
        if(isset($lines)){

            return view('order.basket',compact(['lines','totalBasketPrice']));
        } else{
            return redirect()->route('order');
        }


    }

    private function checkForSessionTicketId()
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
