<?php

namespace App\Http\Controllers;

use App\Traits\SharedTicketTrait;
use Illuminate\Support\Facades\Session;


class CheckOutController extends Controller
{
    use SharedTicketTrait;
    public function checkout(){

        $totalBasketPrice= $this->getSumTicketLines(Session::get('ticketID'));

       return view('order.checkout',compact('totalBasketPrice'));
    }

    public function setTableNumber($table_number){
       $this->moveTable(Session::get('ticketID'),$table_number);
       Session::put('tableNumber',$table_number);

    }
}