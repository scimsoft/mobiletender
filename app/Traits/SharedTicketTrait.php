<?php
/**
 * Created by PhpStorm.
 * User: Gerrit
 * Date: 20/10/2020
 * Time: 13:10
 */

namespace App\Traits;


use App\UnicentaModels\SharedTicket;
use App\UnicentaModels\SharedTicketLines;
use App\UnicentaModels\SharedTicketProduct;
use App\UnicentaModels\SharedTicketUser;
use Carbon\Carbon;
use function count;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



trait SharedTicketTrait
{
    public function hasTicket($table_number)
    {
        $sharedTicket = DB::select('Select content from sharedtickets where id ="' . $table_number.'"');
        if (count($sharedTicket)>0) {
            return true;
        } else {
            return false;
        }
    }
    public function getTicket($table_number)
    {
        $existingticketlines = DB::select("Select content from sharedtickets where id ='$table_number'");
        $ticketlinenumber = 0;
        $sharedTicket = $this->createEmptyTicket();
        if(count($existingticketlines)>0) {
            $productLists = json_decode($existingticketlines[0]->content)->m_aLines;
            foreach ($productLists as $productList) {
                $categoryid = $productList->attributes->{'product.categoryid'};
                $code = $productList->attributes->{'product.code'};
                $name = $productList->attributes->{'product.name'};
                $reference = $productList->attributes->{'product.reference'};
                $printto = $productList->attributes->{'product.printer'};
                $pricesell = $productList->price;
                $id = $productList->productid;
                $sharedTicketProduct = new SharedTicketProduct($reference, $name, $code, $categoryid, $printto, $pricesell, $id);
                $sharedTicket->m_aLines[] = ((new SharedTicketLines($sharedTicket, $sharedTicketProduct, $ticketlinenumber, $productList->{'updated'})));
                $ticketlinenumber = $ticketlinenumber + 1;
            }
        }
        return $sharedTicket;
    }

    /**
     * @return SharedTicket
     */
    public function createEmptyTicket()
    {
        $sharedTicket = new SharedTicket();
        $muser = new SharedTicketUser();
        $sharedTicket->m_User = $muser;
        $activeCash = DB::select('Select money FROM closedcash where dateend is null')[0];
        $sharedTicket->m_sActiveCash = $activeCash->money;
        return $sharedTicket;
    }

    public function saveEmptyTicket(SharedTicket $sharedTicket, $table_number)
    {
        //INSERT empty sharedticket
        $SQLString = "INSERT into sharedtickets VALUES ('".$table_number."','Gerrit','" . json_encode($sharedTicket) . "',0,0,null)";
        Log::debug('INSERT SQLSTRING sharedticket: ' . $SQLString);
        DB::insert($SQLString);
    }


    public function getSumTicketLines($sharedTicketID){
        $sharedTicket = $this->getTicket($sharedTicketID);
        $sum = 0;
        foreach ($sharedTicket->m_aLines as $line){
            $sum+=$line->price;
        }
        return $sum;
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

    public function getTicketLines($table_number)
    {

        $sharedTicket = $this->getTicket($table_number);
        $ticketLines = [];
        foreach ($sharedTicket->m_aLines as $ticketLine) {
            $ticketLines[] = json_encode($ticketLine);
        }
        return $ticketLines;

    }

    private function updateOpenTable(SharedTicket $sharedTicket, $table_number)
    {
        $UpdateSharedTicketSQLString = "UPDATE sharedtickets SET content ='" . json_encode($sharedTicket) . "'WHERE id = '$table_number'";
        //echo($UpdateSharedTicketSQLString);
        DB::update($UpdateSharedTicketSQLString);

        $UpdatePlacesSQLString = "UPDATE places SET waiter = 'app', ticketid = '" . $sharedTicket->m_sId . "', occupied = '" . Carbon::create($sharedTicket->m_dDate) . "' WHERE (id = '" . $table_number . "')";
        //Log::debug('SQLSTRING UPDATE places : '. $SQLString);
        DB::update($UpdatePlacesSQLString);

    }
    public function moveTable($TABLENUMBER, $new_table_nr)
    {
        $updateSQL = "update sharedtickets set id = '$new_table_nr' where id ='$TABLENUMBER' ";
        Log::debug('SQL: '.$updateSQL);
        DB::update($updateSQL);
    }

}