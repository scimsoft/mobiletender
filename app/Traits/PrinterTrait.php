<?php
/**
 * Created by PhpStorm.
 * User: Gerrit
 * Date: 23/10/2020
 * Time: 21:34
 */

namespace App\Traits;


use function config;
use function e;
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
    public function printTicket($header, $lines,$printernumber=1)
    {
        $this->connectToPrinter($printernumber);
        $this->printHeader($header);

        foreach ($lines as $line) {
            //Log::debug('printline: ' . $line->attributes->product->name);
            $this->printer->setTextSize(2, 2);
            $this->printer->text($line->attributes->product->name . "\n");
            //$this->printer->textRaw(mb_convert_encoding($line->attributes->product->name . "\n",  "CP1252"));
        }
        $this->printFooter();
        return true;
    }

    public function printBill($header, $lines){
        $this->connectToPrinter(1);
        $this->printHeader($header);
        $totalPrice = 0;
        foreach ($lines as $line) {

            $productName = $line->attributes->product->name;
            //Log::debug('printName: ' . $productName);
            $productPrice = number_format($line->price*1.1,2,",",".") . " ";
            $totalPrice += $line->price*1.1;
            //Log::debug('printPrice: ' . $productPrice);
            $printtext = $this->columnify($productName, $productPrice,22,12,4);
            //Log::debug('printline: ' . $printtext);
            $this->printer->setTextSize(1, 1);
            $this->printer->text($printtext);
            //$this->printer->textRaw(mb_convert_encoding($printtext,  "UTF-8"));
        }
        $printtext = $this->columnify("TOTAL", number_format($totalPrice,2,",",".")."",22,12,4);
        $this->printer->text("\n\n");
        $this->printer->setEmphasis();
        $this->printer->text($printtext);
        $this->printFooter();


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
          //  $printer->selectCharacterTable(6);
            $this->printer->selectPrintMode(Printer::MODE_FONT_B);


        } catch (Throwable $e) {

            Session('status', 'No se puede imprimir el pedido, avisa a la camarera por favor');
            return abort('503', 'No se puede imprimir el pedido, avisa a la camarera por favor');
        }
    }

    /**
     * @param $header
     * @return Printer|void
     */
    private function printHeader($header)
    {

        $logo = EscposImage::load(config('app.logo'));
        $this->printer->bitImage($logo);
        $this->printer->setTextSize(2, 2);

        $this->printer->text($header . "\n\n");


    }




    /**
     * @param $printer
     */
    private function printFooter(): void
    {

        $this->printer->setJustification(Printer::JUSTIFY_CENTER);
        $this->printer->text($this->footer . "\n\n");
        $this->printer->cut();
        $this->printer->getPrintConnector()->write(PRINTER::ESC . "B" . chr(4) . chr(1));
        $this->printer->getPrintConnector()->write(PRINTER::ESC . "B" . chr(4) . chr(1));
        $this->printer->close();
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


}