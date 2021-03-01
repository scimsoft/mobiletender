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
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use function PHPUnit\Framework\isEmpty;
use Throwable;

trait PrinterTrait
{


    public function printTicket($header, $lines)
    {
        $printer = $this->printHeader($header);

        foreach ($lines as $line) {
            //Log::debug('printline: ' . $line->attributes->product->name);
            $printer->setTextSize(1, 1);
            //$printer->text($line->attributes->product->name . "\n");
            $printer->textRaw(mb_convert_encoding($line->attributes->product->name . "\n",  "CP1252"));
        }
        $this->printFooter($printer);
        return true;
    }

    public function printBill($header, $lines){
        $printer = $this->printHeader($header);
        $totalPrice = 0;
        foreach ($lines as $line) {

            $productName = $line->attributes->product->name;
            Log::debug('printName: ' . $productName);
            $productPrice = number_format($line->price*1.1,2,",",".") . " ";
            $totalPrice += $line->price*1.1;
            Log::debug('printPrice: ' . $productPrice);
            $printtext = $this->columnify($productName, $productPrice,22,12,4);
            Log::debug('printline: ' . $printtext);
            $printer->setTextSize(1, 1);
            //$printer->text($printtext);
            $printer->textRaw(mb_convert_encoding($printtext,  "UTF-8"));
        }
        $printtext = $this->columnify("TOTAL", number_format($totalPrice,2,",",".")."",22,12,4);
        $printer->text("\n\n");
        $printer->setEmphasis();
        $printer->text($printtext);
        $this->printFooter($printer);
        return true;

    }

    public function connectToPrinter()
    {
        try {
            Log::debug('ip:' . config('app.printer-ip'));
            $connector = new NetworkPrintConnector(config('app.printer-ip'), config('app.printer-port'), 3);
         //   $profile = CapabilityProfile::load('xp-n160ii');
            $printer = new Printer($connector);
          //  $printer->selectCharacterTable(6);


        } catch (Throwable $e) {

            Session('status', 'No se puede imprimir el pedido, avisa a la camarera por favor');
            return abort('503', 'No se puede imprimir el pedido, avisa a la camarera por favor');
        }
        return $printer;
    }

    /**
     * @param $header
     * @return Printer|void
     */
    private function printHeader($header)
    {
        $printer = $this->connectToPrinter();
        $logo = EscposImage::load(config('app.logo'));
        $printer->bitImage($logo);
        $printer->setTextSize(2, 2);
        $printer->text($header . "\n\n");
        return $printer;
    }

    /**
     * @param $printer
     */
    private function printFooter($printer): void
    {
        $printer->text("\n\n");
        $printer->cut();
        $printer->getPrintConnector()->write(PRINTER::ESC . "B" . chr(4) . chr(1));
        $printer->getPrintConnector()->write(PRINTER::ESC . "B" . chr(4) . chr(1));
        $printer->close();
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
        return implode($allLines, "\n") . "\n";
    }


}