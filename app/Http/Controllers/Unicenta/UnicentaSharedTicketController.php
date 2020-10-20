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

    public function hasTicket($table_number)
    {
        if (isEmpty(DB::select('Select content from sharedtickets where id =' . $table_number))) {
            return false;
        } else {
            return true;
        }
    }

    public function getTicketLines($table_number)
    {

        $sharedTicket = $this->getTicket($table_number);
        $ticketLines = [];
        foreach ($sharedTicket->m_aLines as $ticketLine) {
            $ticketLines[] = json_encode($ticketLine);
        }
        return $ticketLines;

    }

    public function getTicket2($table_number){
        $existingticketlines = DB::select('Select content from sharedtickets where id =' . $table_number);
        $sharedTicket = json_decode($existingticketlines[0]->content);
        return $sharedTicket;
    }
    //TODO move object creacion from json to constructor


    public function createEmptyTicket(SharedTicket $sharedTicket, $table_number)
    {
        //INSERT empty sharedticket
        $SQLString = "INSERT into sharedtickets VALUES ($table_number,'Gerrit','" . json_encode($sharedTicket) . "',0,0,null)";
        Log::debug('INSERT SQLSTRING sharedticket: ' . $SQLString);
        DB::insert($SQLString);
    }

    public function addProductsToTicket($products, $table_number)
    {
        $sharedTicket = $this->getTicket($table_number);
        $numberLines = count($sharedTicket->m_aLines);
        foreach ($products as $product) {
            $numberLines += 1;
            $sharedTicket->m_aLines[] = new SharedTicketLines($sharedTicket, $product, $numberLines);
        }
        $this->updateOpenTable($sharedTicket, $table_number);


    }

    private function updateOpenTable(SharedTicket $sharedTicket, $table_number)
    {
        $UpdateSharedTicketSQLString = "UPDATE sharedtickets SET content ='" . json_encode($sharedTicket) . "'WHERE id = $table_number";
        //echo($UpdateSharedTicketSQLString);
        DB::update($UpdateSharedTicketSQLString);

        $UpdatePlacesSQLString = "UPDATE places SET waiter = 'app', ticketid = '" . $sharedTicket->m_sId . "', occupied = '" . Carbon::create($sharedTicket->m_dDate) . "' WHERE (id = " . $table_number . ")";
        //Log::debug('SQLSTRING UPDATE places : '. $SQLString);
        DB::update($UpdatePlacesSQLString);

    }

    public function clearOpenTableTicket($table_number)
    {
        $SQLString = "DELETE from sharedtickets WHERE id = " . $table_number;
        DB::delete($SQLString);
    }

    public function removeTicketLine($table_number, $ticketLineNumber)
    {
        $sharedTicket = ($this->getTicket($table_number));
        if ($sharedTicket->m_aLines[$ticketLineNumber]->updated) {
            array_splice($sharedTicket->m_aLines, $ticketLineNumber, 1);
            $this->updateOpenTable($sharedTicket, $table_number);
            return true;
        } else {
            return false;
        }

    }

    public function setTicketLinePrinted($TABLENUMBER, $ticketLineNumber)
    {
        $sharedTicket = ($this->getTicket($TABLENUMBER));
        $ticketLine = $sharedTicket->m_aLines[$ticketLineNumber];
        $ticketLine->updated = false;
        $this->updateOpenTable($sharedTicket, $TABLENUMBER);

    }

}
