<?php
/**
 * Created by PhpStorm.
 * User: Gerrit
 * Date: 16/10/2020
 * Time: 13:24
 */

namespace Tests;

use function anInstanceOf;
use App\Http\Controllers\UnicentaSharedTicketController;
use App\Traits\SharedTicketTrait;
use App\UnicentaModels\Product;
use App\UnicentaModels\SharedTicket;
use App\UnicentaModels\SharedTicketLines;
use App\UnicentaModels\TicketLines;
use Illuminate\Support\Facades\DB;
use function json_encode;


class SharedTicketLineTest extends TestCase
{
    use SharedTicketTrait;

    protected $sharedTicket;

    public function testCreateSharedTicketWith2Products()
    {

        $this->sharedTicket = new SharedTicket();
        $this->sharedTicket->m_User = ['m_sId' => '0', 'm_sName' => 'Administrator'];
        $activeCash = DB::select('Select money FROM closedcash where dateend is null')[0];
        $this->sharedTicket->m_sActiveCash = $activeCash->money;
        $sharedTicketController = new UnicentaSharedTicketController();

        $product = Product::all()->first();
        $ticketLine = new SharedTicketLines($this->sharedTicket, $product, 1);
        $ticketLine2 = new SharedTicketLines($this->sharedTicket, $product, 2);
        $this->sharedTicket->m_aLines[] = $ticketLine;
        $this->sharedTicket->m_aLines[] = $ticketLine2;
        $sharedTicketController->saveEmptyTicket($this->sharedTicket, self::TABLENUMBER);
        self::assertNotEmpty($this->sharedTicket->m_sId);


    }

    public function testGetProductList()
    {
        $sharedTicketController = new UnicentaSharedTicketController();
        $productlist = $sharedTicketController->getTicketLines(self::TABLENUMBER);
        //dd('ProductList'.$productlist);
        self::assertEquals(2, count($productlist));
    }

    public function testGetTicketLinesSum(){
        $sharedTicketController = new UnicentaSharedTicketController();
        $sumTicketLines = $sharedTicketController->getSumTicketLines(self::TABLENUMBER);
        self::assertEquals(2, $sumTicketLines*1.1);
    }

    public function testAddOneTicketLine()
    {
        $product[] = Product::all()->first();
        $sharedTicketController = new UnicentaSharedTicketController();
        $sharedTicketController->addProductsToTicket($product, self::TABLENUMBER);
        $productlist = $sharedTicketController->getTicketLines(self::TABLENUMBER);
        self::assertEquals(3, count($productlist));
    }

    public function testAddMultipleTicketLines()
    {
        $allproducts = Product::all();
        //dd($allproducts);
        for ($i = 0; $i < 3; $i++) {
            $product[] = $allproducts[$i];

        }
        $sharedTicketController = new UnicentaSharedTicketController();
        $sharedTicketController->addProductsToTicket($product, self::TABLENUMBER);
        $productlist = $sharedTicketController->getTicketLines(self::TABLENUMBER);
        self::assertEquals(6, count($productlist));

    }

    public function testRemoveProduct()
    {
        $ticketLineNumber = 1;
        $sharedTicketController = new UnicentaSharedTicketController();
        $sharedTicketController->removeTicketLine(self::TABLENUMBER, $ticketLineNumber);
        $productlist = $sharedTicketController->getTicketLines(self::TABLENUMBER);
        self:
        self::assertEquals(5, count($productlist));

    }

    public function testSetTicketLinePrinted(){
        $ticketLineNumber = 0;
        $sharedTicketController = new UnicentaSharedTicketController();
        $sharedTicketController->setTicketLinePrinted(self::TABLENUMBER, $ticketLineNumber);
        $sharedTicket = $sharedTicketController->getTicket(self::TABLENUMBER);
        self::assertEquals(false,$sharedTicket->m_aLines[$ticketLineNumber]->updated);
    }

    public function NOtestGetSharedTicket2(){
        $sharedTicketController = new UnicentaSharedTicketController();
        $sharedTicket = $sharedTicketController->getTicket2(self::TABLENUMBER);

        self::assertTrue($sharedTicket instanceof SharedTicket);
    }

    public function testClearSharedTicket()
    {
        $sharedTicketController = new UnicentaSharedTicketController();
        $sharedTicketController->clearOpenTableTicket(self::TABLENUMBER);
        self::assertFalse($sharedTicketController->hasTicket(self::TABLENUMBER));

    }

}
