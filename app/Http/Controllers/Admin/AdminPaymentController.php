<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\PrinterTrait;
use Illuminate\Http\Request;
use App\Traits\UnicentaPayedTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use function redirect;
use function view;

class AdminPaymentController extends Controller
{
    //
    use PrinterTrait;
    use UnicentaPayedTrait;

    public function paypanel(){
        $places = DB::select('select id,name from places order by ABS(id)');
        $tickets = DB::select('select * from sharedtickets where length(id)<3');
        $openTicket = [];
        $openTicketSum= [];

        foreach ( $tickets as $ticket) {
            $openTicket[] = $ticket->id;

        }
        foreach($places as $place){
            $openTicketSum[] = $this->getSumTicketLines($place->id);

        }
        return view ('admin.payment',compact(['places','openTicket','openTicketSum']));

    }
    public function pay($tableId){
       $lines =  $this->getTicketLines($tableId);
       $totalBasketPrice = $this->getSumTicketLines($tableId);
       Session::put('tableID',$tableId) ;
       Session::put('ticketID',$tableId) ;
       return view ('admin.basket',compact(['lines','totalBasketPrice','tableId']));
    }

    public function payed($tableId,$mode){

        $lines =  $this->getTicketLines($tableId);

        $header = "Chiringuito Playa Alta \n Paseo de lo Gavilanes s/n \n Isla Canela \n CIF: 29479010W \n +34 618065010 ";

        $this->printInvoice($header,$lines);

        $this->setTicketPayed($tableId,$mode);
        return redirect(route('paypanel'));
    }

    public function closecash(){
        $totals = $this->getClosedCash();
        return view('admin.closecash',compact(['totals']));

    }

    public function printmoney(){
        $totals = $this->getClosedCash();

        return view('admin.closecash',compact(['totals']));
    }

    public function closemoney(){
        $totals = $this->getClosedCash();
        $this->closeCashDB();
        $this->printClosedCash($totals);
        $totals = $this->getClosedCash();
        return view('admin.closecash',compact(['totals']));
    }

    public function movementsIndex(){

        $movements = $this->getMovementsLines();
        return view('admin.movements',compact('movements'));
    }

    public function addmovement(Request $request){
        $payment = $request->payment;
        $total = $request->total;
        if($payment != 'cashin'){
            $total = 0 - $total;
        }
        $notes = $request->notes;
        $this->addMovementFromForm($payment,$total,$notes);
        return $this->movementsIndex();
        }


}
