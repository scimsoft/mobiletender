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
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use function PHPUnit\Framework\isEmpty;
use Throwable;

trait PrinterTrait
{


    public function printTicket($header, $lines)
    {
        $printer = $this->connectToPrinter();


            $logo = EscposImage::load(config('app.logo'));
            $printer->bitImageColumnFormat($logo);





            $printer->setTextSize(2, 2);

            $printer->text($header."\n\n");


            foreach ($lines as $line) {
                Log::debug('primtline: '.$line->attributes->product->name);
                $printer->text($line->attributes->product->name."\n");

            }
            $printer->text("\n\n\n");


            $printer->cut();
            $printer->getPrintConnector()->write(PRINTER::ESC . "B" . chr(4) . chr(1));
            $printer->getPrintConnector()->write(PRINTER::ESC . "B" . chr(4) . chr(1));
            $printer->close();
            return true;



    }

    public function connectToPrinter()
    {
        try {
            Log::debug('ip:' . config('app.printer-ip'));
            $connector = new NetworkPrintConnector(config('app.printer-ip'), config('app.printer-port'), 3);
            $printer = new Printer($connector);


        } catch (Throwable $e) {

            Session('status','No se puede imprimir el pedido, avisa a la camarera por favor');
            return abort('503', 'No se puede imprimir el pedido, avisa a la camarera por favor');
        }
        return $printer;
    }


}