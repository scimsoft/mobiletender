<?php

namespace App\Http\Controllers;

use App\Traits\PrinterTrait;
use App\Traits\SharedTicketTrait;
use App\UnicentaModels\SharedTicket;
use function config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;
use function redirect;


class CheckOutController extends Controller
{
    use SharedTicketTrait;
    use PrinterTrait;
    public function checkout(){
        $sharedTicketID = Session::get('ticketID');
        $totalBasketPrice= $this->getSumTicketLines($sharedTicketID);
        $newLinesPrice = $this->getSumNewTicketLines($sharedTicketID);
        $tablenames= DB::select('select id,name from places order by id');
       return view('order.checkout',compact(['totalBasketPrice','newLinesPrice','tablenames']));
    }

    public function confirmForTable($table_number){
        $ticketID = Session::get('ticketID');
        $this->moveTable($ticketID,$table_number);
       Session::put('tableNumber',$table_number);
       Session::put('ticketID',$table_number);
       return $this->printOrder($table_number);

    }

    public function printOrder($ticketID)
    {
        $ticket= $this->getTicket($ticketID);
        $header="Mesa: ".$ticketID;
        try{
            $this->printTicket($header,$this->getUnprintedTicetLines($ticket));
            $this->setUnprintedTicketLinesAsPrinted($ticket,$ticketID);
            if(config('customoptions.clean_table_after_order')==true){
                $this->updateOpenTable($this->createEmptyTicket(),Session::get('ticketID'));
            }
        }catch (\Exception $e){
            Session::flash('error','No se ha podido imprimir el ticket. Por favor avisa a nuestro personal.');
            Log::error("Error Printing printerbridge error msg:" .$e);
        }
        Log::debug('return from printOrder');
        return redirect()->route('basket');
    }



    /**
     * @param $ticket_lines
     * @return array|null
     */
    private function setUnprintedTicketLinesAsPrinted(SharedTicket $ticket,$ticketID)
    {
        $lines_to_print = null;
        foreach ($ticket->m_aLines as $ticket_line) {
            if ($ticket_line->attributes->updated) {
                $lines_to_print[] = $ticket_line;
                $ticket_line->setPrinted();
            }
        }
        $this->updateOpenTable($ticket,$ticketID);
        return $lines_to_print;
    }

    private function getUnprintedTicetLines(SharedTicket $ticket){
        $lines_to_print = null;
        foreach ($ticket->m_aLines as $ticket_line) {
            if ($ticket_line->attributes->updated) {
                $lines_to_print[] = $ticket_line;

            }
        }

        return $lines_to_print;
    }


}