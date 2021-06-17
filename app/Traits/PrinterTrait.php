<?php
/**
 * Created by PhpStorm.
 * User: Gerrit
 * Date: 23/10/2020
 * Time: 21:34
 */

namespace App\Traits;


use Carbon\Carbon;
use function config;
use function e;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use function is_array;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use function PHPUnit\Framework\isEmpty;
use Throwable;

trait PrinterTrait
{

    protected $printer;
    protected $footer = '';
    public function printOrder($header, $lines, $printernumber=1)
    {

        $this->connectToPrinter($printernumber);
        $this->printLogo('app.logo');
        $this->printer -> setJustification(Printer::JUSTIFY_CENTER);
        $this->printHeader($header,2);
        $this->printer -> setJustification(Printer::JUSTIFY_LEFT);
        foreach ($lines as $line) {
            $this->printer->setTextSize(2, 2);
            $this->printer->text($line->attributes->product->name . "\n");
            }
        $this->printFooter();
        return true;
    }

    public function printTicket($header, $lines){
        $this->connectToPrinter(1);

        $this->printLogo('app.logo');

        $this->printHeader($header,2);
        $this->printProductLinesAndPrices($lines);
        $this->printFooter();
    }

    public function printClosedCash( $lines){
        $this->connectToPrinter(1);
        $this->printLogo('app.logo');
        $this->printer -> setJustification(Printer::JUSTIFY_CENTER);
        $this->printHeader("Closed Cash Report \n " ,2);
        $this->printTwoColumnHeader();
        $total= $this->printTwoColumnLines($lines);
        $this->printTwoClumnFooter($total);
        $this->printFooter();
    }

    public function printInvoice($header, $lines){

        $this->connectToPrinter(1);

        $this->printer -> pulse(0,148,49);
        $this->printer -> setJustification(Printer::JUSTIFY_CENTER);
        $this->printLogo('app.ticketlogo');

        $this->printHeader($header,1);

        $this->printProductLinesAndPrices($lines);

        $this->footer = "Gracias por la visita y no olvide de siguernos en @PlayaAlta. \n\n Servicio de mesa digital por: horecalo.com";
        $this->printFooter();
    }

    /**
     * @param $header
     * @return Printer|void
     */
    private function printHeader($header,$size)
    {

        $this->printer->setTextSize($size, $size);
        $this->printer->text($header . "\n");
    }

    private function printLogo($logokey){
        $this->printer -> setJustification(Printer::JUSTIFY_CENTER);
        $logo = EscposImage::load(config($logokey));
        $this->printer->bitImage($logo);
    }






    /**
     * @param $printer
     */
    private function printFooter(): void
    {

        $this->printer->setTextSize(1, 1);
        $this->printer->text($this->footer . "\n\n");
        $this->printer->cut();
        $this->printer->getPrintConnector()->write(PRINTER::ESC . "B" . chr(4) . chr(1));
        $this->printer->getPrintConnector()->write(PRINTER::ESC . "B" . chr(4) . chr(1));
        $this->printer->close();
    }


    /**
     * @param $lines
     */
    private function printProductLinesAndPrices($lines): void
    {
        $this->printTwoColumnHeader();
        $totalPrice = 0;
        $this->printer->setTextSize(1, 1);
        foreach ($lines as $line) {
            $productName = $line->attributes->product->name;
            $productPrice = number_format($line->price * 1.1, 2, ",", ".") . " ";
            $totalPrice += $line->price * 1.1;
            $printtext = $this->columnify($productName, $productPrice, 40, 12, 4);
            $this->printer->text($printtext);
        }
        $this->printTwoClumnFooter($totalPrice);
    }

    private function printTwoColumnLines($lines)
    {

        $totalPrice = 0;
        $this->printer->setTextSize(1, 1);
        foreach ($lines as $line) {
            $totalPrice += $line->total;
            $printtext = $this->columnify($line->payment, $line->total, 40, 12, 4);
            $this->printer->text($printtext);
        }
        return $totalPrice;
    }

    public function connectToPrinter($printernumber)
    {
        try {
            Log::debug('ip:' . config('app.printer-ip'));

            $printerIP = explode(',',config('app.printer-ip'));
            $printerPort = explode(',',config('app.printer-port'));
            $connector = new NetworkPrintConnector($printerIP[$printernumber-1], $printerPort[$printernumber-1], 3);
         //   $profile = CapabilityProfile::load('xp-n160ii');
            $this->printer = new Printer($connector);
            $this->printer->selectCharacterTable(1);
            $this->printer->selectPrintMode(Printer::MODE_FONT_B);


        } catch (Throwable $e) {

            Session('status', 'No se puede imprimir el pedido, avisa a la camarera por favor');
            return abort('503', 'No se puede imprimir el pedido, avisa a la camarera por favor');
        }
    }







    private function columnify($leftCol, $rightCol, $leftWidth, $rightWidth, $space = 4)
    {
        $leftWrapped = wordwrap($leftCol, $leftWidth, "\n", true);
        $rightWrapped = wordwrap($rightCol, $rightWidth, "\n", true);

        $leftLines = explode("\n", $leftWrapped);
        $rightLines = explode("\n", $rightWrapped);
        $allLines = array();
        for ($i = 0; $i < max(count($leftLines), count($rightLines)); $i ++) {
            $leftPart = str_pad(isset($leftLines[$i]) ? $leftLines[$i] : "", $leftWidth, " ");
            $rightPart = str_pad(isset($rightLines[$i]) ? $rightLines[$i] : "", $rightWidth, " ");
            $allLines[] = $leftPart . str_repeat(" ", $space) . $rightPart;
        }
        //dd($allLines);
        return implode("\n",$allLines ) . "\n";

    }

    private function printTwoColumnHeader(): void
    {
        $this->printer->setJustification(Printer::JUSTIFY_LEFT);
        $this->printer->setTextSize(1, 1);
        $this->printer->setEmphasis();

        $this->printer->text($this->columnify('Producto', 'Precio', 40, 12, 4));
        $this->printer->text("----------------------------------------------------------\n");
    }

    /**
     * @param $totalPrice
     */
    private function printTwoClumnFooter($totalPrice): void
    {
        $this->printer->text("==========================================================\n");
        $this->printer->text($this->columnify('IVA', number_format($totalPrice * 0.1, 2, ",", ".") . '', 40, 12, 4));
        $this->printer->setTextSize(2, 2);
        $printtext = $this->columnify("TOTAL", number_format($totalPrice, 2, ",", ".") . "", 18, 12, 4);
        $this->printer->setEmphasis();
        $this->printer->text($printtext);
    }

}