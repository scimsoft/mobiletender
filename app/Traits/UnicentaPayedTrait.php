<?php
/**
 * Created by PhpStorm.
 * User: Gerrit
 * Date: 08/11/2020
 * Time: 15:06
 */
namespace App\Traits;

use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


trait UnicentaPayedTrait
{
    use SharedTicketTrait;

    public function setTicketPayed( $tableNumber, $paymentType='cash')
    {
        /*
         *  UPDATE ticketsnum SET ID = LAST_INSERT_ID(ID + 1)
         *
         */
        $ticket = $this->getTicket($tableNumber);
        DB::update("UPDATE ticketsnum SET ID = LAST_INSERT_ID(ID + 1)");



        DB::update('UPDATE ticketsnum SET ID = LAST_INSERT_ID(ID + 1)');
        //$ticketid = DB::select("SELECT LAST_INSERT_ID()");
        $ticketid = DB::getPdo()->lastInsertId();
        //dd($ticketid);
        /*
         *
         *
         *
         * INSERT INTO receipts (ID, MONEY, DATENEW, ATTRIBUTES, PERSON) VALUES ('fa06f234-d749-4801-a122-75fe6e006689', 'bfd6b036-6250-4e64-b7eb-bb028bcef5f1', '2020-11-08 14:56:27.808', _binary'<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n<!DOCTYPE properties SYSTEM \"http://java.sun.com/dtd/properties.dtd\">\r\n<properties>\r\n<comment>uniCenta oPOS</comment>\r\n</properties>\r\n', null)
         */
        $id = $ticket->m_sId;
        $money = DB::Select('SELECT money FROM closedcash where dateend is null;')[0]->money;
        $datenew = Carbon::now();
        $attributes = null;
        $person = auth()->user()->name;
        //dd($money->money);
        $insertReceiptSQL = "INSERT INTO receipts (ID, MONEY, DATENEW, ATTRIBUTES, PERSON) VALUES ('$id', '$money', '$datenew', null, '$person')";
        DB::insert($insertReceiptSQL);
        /*
         *
         * $insertSQL = "INSERT INTO receipts (ID, MONEY, DATENEW, ATTRIBUTES, PERSON) VALUES ('fa06f234-d749-4801-a122-75fe6e006689', 'bfd6b036-6250-4e64-b7eb-bb028bcef5f1', '2020-11-08 14:56:27.808', _binary'<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n<!DOCTYPE properties SYSTEM \"http://java.sun.com/dtd/properties.dtd\">\r\n<properties>\r\n<comment>uniCenta oPOS</comment>\r\n</properties>\r\n', null)";
         * INSERT INTO tickets (ID, TICKETTYPE, TICKETID, PERSON, CUSTOMER, STATUS) VALUES ('fa06f234-d749-4801-a122-75fe6e006689', 0, 8, '0', null, 0)
         */
        $insertTicketSQL="INSERT INTO tickets (ID, TICKETTYPE, TICKETID, PERSON, CUSTOMER, STATUS) VALUES ('$id', 0, '$ticketid', 0, null, 0)";
        DB::insert($insertTicketSQL);
        /*
         * UPDATE tickets SET STATUS = 8 WHERE TICKETTYPE = 0 AND TICKETID = 0
         *
         *
         * INTO ticketlines (TICKET, LINE, PRODUCT, ATTRIBUTESETINSTANCE_ID, UNITS, PRICE, TAXID, ATTRIBUTES) VALUES ('fa06f234-d749-4801-a122-75fe6e006689', 0, '0d5a6cdd-3a5e-4365-9975-0eb173108198', null, 1.0, 2.2727272727272725, '001', _binary'<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n<!DOCTYPE properties SYSTEM \"http://java.sun.com/dtd/properties.dtd\">\r\n<properties>\r\n<comment>uniCenta oPOS</comment>\r\n<entry key=\"product.taxcategoryid\">001</entry>\r\n<entry key=\"product.warranty\">false</entry>\r\n<entry key=\"product.memodate\">2018-01-01 00:00:01.0</entry>\r\n<entry key=\"product.verpatrib\">false</entry>\r\n<entry key=\"product.reference\">aguagas</entry>\r\n<entry key=\"product.name\">Agua Gas</entry>\r\n<entry key=\"product.service\">false</entry>\r\n<entry key=\"product.com\">false</entry>\r\n<entry key=\"product.code\">aguagas</entry>\r\n<entry key=\"product.constant\">false</entry>\r\n<entry key=\"ticket.updated\">true</entry>\r\n<entry key=\"product.printer\">1</entry>\r\n<entry key=\"product.categoryid\">4fabf8cc-c05c-492c-91cb-f0b751d41cee</entry>\r\n<entry key=\"product.vprice\">false</entry>\r\n</properties>\r\n')
         */
        /*
         * SELECT ID, PRODUCT, PRODUCT_BUNDLE, QUANTITY FROM products_bundle WHERE PRODUCT = '0d5a6cdd-3a5e-4365-9975-0eb173108198'
         *
         * UPDATE stockcurrent SET UNITS = (UNITS + -1.0) WHERE LOCATION = '0' AND PRODUCT = '0d5a6cdd-3a5e-4365-9975-0eb173108198' AND ATTRIBUTESETINSTANCE_ID IS NULL
         */



        /*
        *  INSERT INTO stockcurrent (LOCATION, PRODUCT, ATTRIBUTESETINSTANCE_ID, UNITS) VALUES ('0', '0d5a6cdd-3a5e-4365-9975-0eb173108198', null, -1.0)
        *
        * INSERT INTO stockdiary (ID, DATENEW, REASON, LOCATION, PRODUCT, ATTRIBUTESETINSTANCE_ID, UNITS, PRICE, AppUser) VALUES ('98c99c73-e90b-4549-bf11-04cfbb1c291f', '2020-11-08 14:56:27.808', -1, '0', '0d5a6cdd-3a5e-4365-9975-0eb173108198', null, -1.0, 2.2727272727272725, 'Administrator')
        */

        $ticketLines = $this->getTicketLines($tableNumber);
        $linenumber= 0;
        foreach ($ticketLines as $ticketLine){

            $insertTicketLineSQL="INSERT INTO ticketlines (TICKET, LINE, PRODUCT, ATTRIBUTESETINSTANCE_ID, UNITS, PRICE, TAXID, ATTRIBUTES) VALUES ('$id', $linenumber, '$ticketLine->productid', null, 1.0, $ticketLine->price, '001',null)";
            DB::insert($insertTicketLineSQL);
            $updateStockSQL =( "UPDATE stockcurrent SET UNITS = (UNITS + -1.0) WHERE LOCATION = '0' AND PRODUCT = '$ticketLine->productid' AND ATTRIBUTESETINSTANCE_ID IS NULL");
            DB::update($updateStockSQL);
            $insertStockCurrent="INSERT INTO stockcurrent (LOCATION, PRODUCT, ATTRIBUTESETINSTANCE_ID, UNITS) VALUES ('0', '$ticketLine->productid', null, -1.0)";
            DB::insert($insertStockCurrent);
            $stockDiaryID=Str::uuid();

            $insertStockDairy = "INSERT INTO stockdiary (ID, DATENEW, REASON, LOCATION, PRODUCT, ATTRIBUTESETINSTANCE_ID, UNITS, PRICE, AppUser) VALUES ('$stockDiaryID', '$datenew', -1, '0', '$ticketLine->productid', null, -1.0, $ticketLine->price, '$person')";
           // dd($insertStockDairy);
            DB::insert($insertStockDairy);
            $linenumber++;
        }



         /*
         * INSERT INTO payments (ID, RECEIPT, PAYMENT, TOTAL, TRANSID, RETURNMSG, TENDERED, CARDNAME, VOUCHER) VALUES ('4f9b20f2-95ea-46e0-9ad2-974fef60a596', 'fa06f234-d749-4801-a122-75fe6e006689', 'bank', 2.4999999999999996, null, _binary'Aceptar', 0.0, null, null)
         */

         $total = $this->getSumTicketLines($tableNumber)*1.1;

         $paymentID = Str::uuid();
         $insertPaymentSQL ="INSERT INTO payments (ID, RECEIPT, PAYMENT, TOTAL, TRANSID, RETURNMSG, TENDERED, CARDNAME, VOUCHER) VALUES ('$paymentID', '$id' , '$paymentType', '$total', 'no ID', null, '$total', null, null)";
         DB::insert($insertPaymentSQL);
         /*
         * INSERT INTO taxlines (ID, RECEIPT, TAXID, BASE, AMOUNT)  VALUES ('9c5f2533-74a2-40ee-a499-0cc71a299f05', 'fa06f234-d749-4801-a122-75fe6e006689', '001', 2.2727272727272725, 0.22727272727272727)
         */
         $tax=0.1*$total;
         $taxid = Str::uuid();
         $insertTaxLineSQL = "INSERT INTO taxlines (ID, RECEIPT, TAXID, BASE, AMOUNT)  VALUES ('$taxid', '$id', '001', '$total', '$tax')";
         DB::insert($insertTaxLineSQL);

         /*
         * DELETE FROM sharedtickets WHERE ID = '1'
         */

         $deleteSharedTicket = "DELETE FROM sharedtickets WHERE id = '$tableNumber'";
        // DB::delete($deleteSharedTicket);

        $this->clearOpenTableTicket($tableNumber);

         //$this->saveEmptyTicket($this->createEmptyTicket(),$tableNumber);
         /* INSERT INTO lineremoved (NAME, TICKETID, PRODUCTNAME, UNITS) VALUES ('Administrator', 'Void', 'Ticket Deleted', 0.0)
         * */

    }
}