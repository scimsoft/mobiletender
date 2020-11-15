<?php
/**
 * Created by PhpStorm.
 * User: Gerrit
 * Date: 27/10/2020
 * Time: 10:43
 */

namespace Tests;


use App\Traits\PrinterTrait;
use function mb_convert_encoding;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
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

        $profile = CapabilityProfile::load('xp-n160ii');

        $printer = new Printer($connector,$profile);

        $codePages = $profile -> getCodePages();

        $printer->selectCharacterTable(1145);

        $printer -> getPrintConnector()-> write(Printer::FS . ".");
        $printer -> getPrintConnector() -> write("Caña");

        $printer->text("Test");
        $printer->text("\n \n");



        $printer->close();
    }

    public function testcharcodes(){
        include(dirname(__FILE__) . '/resources/character-encoding-test-strings.inc');
        try {
            // Enter connector and capability profile (to match your printer)
           // $connector = new FilePrintConnector("php://stdout");
            $connector = new NetworkPrintConnector(config('app.printer-ip'), config('app.printer-port'), 3);

            $profile = CapabilityProfile::load("default");

            /* Print a series of receipts containing i18n example strings */
            $printer = new Printer($connector, $profile);
            $printer -> selectPrintMode(Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_EMPHASIZED | Printer::MODE_DOUBLE_WIDTH);
            $printer -> text("Implemented languages\n");
            $printer -> selectPrintMode();
            foreach ($inputsOk as $label => $str) {
                $printer -> setEmphasis(true);
                $printer -> text($label . ":\n");
                $printer -> setEmphasis(false);
                $printer -> text($str);
            }
            $printer -> feed();

            $printer -> selectPrintMode(Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_EMPHASIZED | Printer::MODE_DOUBLE_WIDTH);
            $printer -> text("Works in progress\n");
            $printer -> selectPrintMode();
            foreach ($inputsNotOk as $label => $str) {
                $printer -> setEmphasis(true);
                $printer -> text($label . ":\n");
                $printer -> setEmphasis(false);
                $printer -> text($str);
            }
            $printer -> cut();

            /* Close printer */
            $printer -> close();
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }
    }

    public function NotestPrintChars(){
        $connector = new NetworkPrintConnector(config('app.printer-ip'), config('app.printer-port'), 3);

        $profile = CapabilityProfile::load('xp-n160ii');

        $printer = new Printer($connector,$profile);
        //$printer->selectCharacterTable(53);

        $connector->write(Printer::FS . '.');
        for ($char = 1; $char <= 500; $char++) {

            $printer->text(chr($char));
        }
        $printer->text("\n");
        $printer->cut();
        $printer->close();
    }

    public function NOtestCodePageForSpanish(){
        $connector = new NetworkPrintConnector(config('app.printer-ip'), config('app.printer-port'), 3);

        $profile = CapabilityProfile::load('CT-S651');
        $printer = new Printer($connector,$profile);
        $codepages=$profile->getCodePages();




            $printer->setTextSize(2, 2);
            $printer->getPrintConnector()->write(PRINTER::ESC . "t" . chr(2) );

            $printer->text("\n");





        $printer->close();

}

}
