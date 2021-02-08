<?php
/**
 * Created by PhpStorm.
 * User: Gerrit
 * Date: 12/12/2020
 * Time: 14:51
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Traits\PrinterTrait;
use App\Traits\SharedTicketTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use function redirect;
use function retry;

class AdminOrderController extends Controller
{
    use SharedTicketTrait;
    use PrinterTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $openorders=$this->getOpenOrders();
        $openSums= [];
        foreach ($openorders as $openorder){
            $openSums[]= $this->getSumTicketLines($openorder->id);

        }

        return view('admin.orders',compact(['openorders','openSums']) );
    }

    public function admintable($id){
        Session::put('ticketID',$id);
        Session::put('tableNumber',$id);
        return redirect()->route('basket');
    }
    public function delete($id){
        $this->clearOpenTableTicket($id);
        Session::forget('ticketID');
        Session::forget('tableNumber');
        return $this->index();
    }

    public function send_bill($ticketID)
    {
        $ticket= $this->getTicket($ticketID);
        $header="Mesa: ".$ticketID;
        try{
            $this->printBill($header,$ticket->m_aLines);

        }catch (\Exception $e){
            Session::flash('error','No se ha podido imprimir el ticket. Por favor avisa a nuestro personal.');
            Log::error("Error Printing printerbridge error msg:" .$e);
        }
        Log::debug('return from printOrder');
        return back();
    }

}