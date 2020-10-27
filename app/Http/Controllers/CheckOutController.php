<?php

namespace App\Http\Controllers;

use App\Traits\SharedTicketTrait;
use App\UnicentaModels\SharedTicket;
use App\UnicentaModels\SharedTicketLines;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class CheckOutController extends Controller
{
    use SharedTicketTrait;
    public function checkout(){
        $sharedTicketID = Session::get('ticketID');
        $totalBasketPrice= $this->getSumTicketLines($sharedTicketID);
        $newLinesPrice = $this->getSumNewTicketLines($sharedTicketID);
       return view('order.checkout',compact(['totalBasketPrice','newLinesPrice']));
    }

    public function confirmForTable($table_number){
        $ticketID = Session::get('ticketID');
        $this->moveTable($ticketID,$table_number);
       Session::put('tableNumber',$table_number);
       Session::put('ticketID',$table_number);
       $this->printOrder($table_number);

    }

    public function printOrder($ticketID)
    {

        $ticket= $this->getTicket($ticketID);
        $lines_to_print = $this->setUnprintedTicketLinesAsPrinted($ticket,$ticketID);
        $this->sendToPrinter($lines_to_print);
    }

    private function sendToPrinter($lines_to_print)
    {
    }

    /**
     * @param $ticket_lines
     * @return array|null
     */
    private function setUnprintedTicketLinesAsPrinted(SharedTicket $ticket,$ticketID)
    {
        $lines_to_print = null;
        foreach ($ticket->m_aLines as $ticket_line) {
            if ($ticket_line->attributes->product->updated ='true') {
                $lines_to_print[] = $ticket_line;
                $ticket_line->setPrinted();
            }
        }
        $this->updateOpenTable($ticket,$ticketID);
        return $lines_to_print;
    }


}