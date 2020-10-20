<?php
namespace Tests;
use App\Http\Controllers\UnicentaSharedTicketController;
use App\UnicentaModels\SharedTicket;


class SharedTicketsTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */

    public function testTableHasNoOpenTicket(){
        $sharedTicketController = new UnicentaSharedTicketController();
        self::assertFalse($sharedTicketController->hasTicket(self::TABLENUMBER));
    }

    public function testInsertSharedTicket(){
        $sharedTicket = new SharedTicket();
        $sharedTicketController = new UnicentaSharedTicketController();
        $sharedTicketController->createEmptyTicket($sharedTicket,self::TABLENUMBER);
        self::assertNotEmpty($sharedTicketController->getTicket(self::TABLENUMBER));
    }

    public function testUpdateSharedTicket(){
        $this->assertTrue(true);

    }

    public function testClearSharedTicket(){
        $sharedTicketController = new UnicentaSharedTicketController();
        $sharedTicketController->clearOpenTableTicket(self::TABLENUMBER);
        self::assertFalse($sharedTicketController->hasTicket(self::TABLENUMBER));
    }



}
