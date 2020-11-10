<?php
/**
 * Created by PhpStorm.
 * User: Gerrit
 * Date: 27/10/2020
 * Time: 10:43
 */

namespace Tests;


use App\Traits\PrinterTrait;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;

class PrinterTraitTest extends TestCase
{
    use PrinterTrait;

    public function testPrinterConnection()
    {
        $printer = $this->connectToPrinter();
        self::assertNotEmpty($printer);
        $printer->close();
    }

    public function NotestPrintLine()
    {

        $connector = new NetworkPrintConnector(config('app.printer-ip'), config('app.printer-port'), 3);

        $profile = CapabilityProfile::load('TM-T88II');

        $printer = new Printer($connector,$profile);
        $printer->selectCharacterTable(3);

        $printer->text("\n \n");
        $printer->text("Test\n");
        $printer->text("Test \n");
        $printer->setTextSize(2, 2);
        $printer->text("Caña \n");
        $printer->text("Test");
        $printer->text("\n \n");
        $printer->cut();
        $printer->close();
    }

    public function testCodePageForSpanish(){
        $connector = new NetworkPrintConnector(config('app.printer-ip'), config('app.printer-port'), 3);

        $profile = CapabilityProfile::load('CT-S651');
        $printer = new Printer($connector,$profile);
        $codepages=$profile->getCodePages();
        foreach($codepages as $codepage) {


            $printer->selectCharacterTable(intval($codepage->getId()));
            $printer->setTextSize(2, 2);

            $printer->text($codepage->getName().":");
            $printer->text("Ca\0xF1a \n");
            $printer->getPrintConnector()->write(PRINTER::ESC . "B" . chr(4) . chr(1));



        }
        $printer->close();

}

}
