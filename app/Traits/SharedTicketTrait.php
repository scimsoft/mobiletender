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
use Illuminate\Support\Facades\DB;

trait SharedTicketTrait
{
    public function getTicket($table_number)
    {
        $existingticketlines = DB::select('Select content from sharedtickets where id =' . $table_number);
        $ticketlinenumber = 0;
        $sharedTicket = new SharedTicket();
        $muser = new SharedTicketUser();
        $sharedTicket->m_User = $muser;
        $activeCash = DB::select('Select money FROM closedcash where dateend is null')[0];
        $sharedTicket->m_sActiveCash = $activeCash->money;
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
        return $sharedTicket;
    }

}