<?php

namespace App\Http\Controllers;

use App\UnicentaModels\SharedTicket;
use App\UnicentaModels\SharedTicketLines;
use App\UnicentaModels\SharedTicketProduct;
use App\UnicentaModels\SharedTicketUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\SharedTicketTrait;
use function json_decode;
use function PHPUnit\Framework\isEmpty;

class UnicentaSharedTicketController extends Controller
{
    //
    use SharedTicketTrait;









    public function getTicket2($table_number){
        $existingticketlines = DB::select('Select content from sharedtickets where id =' . $table_number);
        $sharedTicket = json_decode($existingticketlines[0]->content);
        return $sharedTicket;
    }
    //TODO move object creacion from json to constructor












    public function setTicketLinePrinted($TABLENUMBER, $ticketLineNumber)
    {
        $sharedTicket = ($this->getTicket($TABLENUMBER));
        $ticketLine = $sharedTicket->m_aLines[$ticketLineNumber];
        $ticketLine->updated = false;
        $this->updateOpenTable($sharedTicket, $TABLENUMBER);

    }



}
