<?php

namespace App\Http\Controllers;

use App\Traits\PrinterTrait;
use App\Traits\SharedTicketTrait;
use App\Models\UnicentaModels\SharedTicket;
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

    public function checkout()
    {
        $sharedTicketID = Session::get('ticketID');
        $totalBasketPrice = $this->getSumTicketLines($sharedTicketID);
        $newLinesPrice = $this->getSumNewTicketLines($sharedTicketID);
        $tablenames = DB::select('select id,name from places order by id');
        return view('order.checkout', compact(['totalBasketPrice', 'newLinesPrice', 'tablenames']));
    }

    public function confirmForTable($table_number)
    {
        $ticketID = Session::get('ticketID');
        $this->moveTable($ticketID, $table_number);
        Session::put('tableNumber', $table_number);
        Session::put('ticketID', $table_number);
        return $this->printOrder($table_number);
    }

    public function printOrder($ticketID)
    {
        $ticket = $this->getTicket($ticketID);
        $header = "Mesa: " . $ticketID;
        try {
            $this->printTicket($header, $this->getUnprintedTicetLines($ticket));
            $this->setUnprintedTicketLinesAsPrinted($ticket, $ticketID);
            if (config('customoptions.clean_table_after_order')) {
                $this->updateOpenTable($this->createEmptyTicket(), Session::get('ticketID'));
            }
        } catch (\Exception $e) {
            Session::flash('error', 'No se ha podido imprimir el ticket. Por favor avisa a nuestro personal.');
            Log::error("Error Printing printerbridge error msg:" . $e);
        }
        Log::debug('return from printOrder');
        Session::flash('status', 'Su pedido se esta preparando');
        return redirect()->route('order');
    }

    private function getUnprintedTicetLines(SharedTicket $ticket)
    {
        $lines_to_print = null;
        foreach ($ticket->m_aLines as $ticket_line) {
            // Log::debug('line updated:'.$ticket_line->attributes->updated);
            if ($ticket_line->attributes->updated == 1) {
                $lines_to_print[] = $ticket_line;

            }
        }

        return $lines_to_print;
    }

    /**
     * @param $ticket_lines
     * @return array|null
     */
    private function setUnprintedTicketLinesAsPrinted(SharedTicket $ticket, $ticketID)
    {
        $lines_to_print = null;
        foreach ($ticket->m_aLines as $ticket_line) {
            if ($ticket_line->attributes->updated) {
                $lines_to_print[] = $ticket_line;
                $ticket_line->setPrinted();
            }
        }
        $this->updateOpenTable($ticket, $ticketID);
        return $lines_to_print;
    }

    public function printOrderEfectivo($ticketID)
    {
        $this->footer = 'PAGAR en Efectivo';
        $this->printFastOrder($ticketID);
        Session::flash('status', 'Su cuenta esta pedida');
        return redirect()->route('order');
    }

    public function printOrderPagado($ticketID){
        $this->footer = 'PAGADO Online';
        $this->printFastOrder($ticketID);
        Session::flash('status', 'Su cuenta esta pagado');
        return redirect()->route('order');
    }

    public function printFastOrder($ticketID)
    {
        $ticket = $this->getTicket($ticketID);
        $header = "Mesa: " . $ticketID;
        try {
            $this->printBill($header, $this->getTicketLines($ticketID));

        } catch (\Exception $e) {
            Session::flash('error', 'No se ha podido imprimir el ticket. Por favor avisa a nuestro personal.');
            Log::error("Error Printing printerbridge error msg:" . $e);
        }
        if(config('clean_table_after_order')) {
            $this->updateOpenTable($this->createEmptyTicket(), Session::get('ticketID'));
        }

    }

    public function printOrderTarjeta($ticketID)
    {
        $this->footer = 'PAGAR con Tarjeta';
        $this->printFastOrder($ticketID);
        Session::flash('status', 'Su cuenta esta pedida');
        return redirect()->route('order');
    }

    public function printOrderOnline($ticketID)
    {
        $this->footer = 'PAGADO online';
        $this->printFastOrder($ticketID);
        Session::flash('status', 'Su cuenta esta pagado');
        return redirect()->route('order');
    }

    public function setPickUpId()
    {
        $pickup_ID = DB::table('pickup_number')->max('id');
        $pickup_ID = $pickup_ID + 1;
        DB::statement("UPDATE pickup_number set id = " . $pickup_ID . ";");
        $this->moveTable(Session::get('ticketID'), $pickup_ID);

        Session::put('tableNumber', $pickup_ID);
        Session::put('ticketID', $pickup_ID);
        Session::put('isPickup', true);
        return redirect()->route('pay');
    }

    public function pay()
    {
        $sharedTicketID = Session::get('ticketID');
        //dd($sharedTicketID);
        $totalBasketPrice = $this->getSumTicketLines($sharedTicketID);
        $newLinesPrice = $this->getSumNewTicketLines($sharedTicketID);
        $tablenames = DB::select('select id,name from places order by id');
        return view('order.pay', compact(['totalBasketPrice', 'newLinesPrice', 'tablenames']));
    }


}