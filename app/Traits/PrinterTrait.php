<?php
/**
 * Created by PhpStorm.
 * User: Gerrit
 * Date: 23/10/2020
 * Time: 21:34
 */

namespace App\Traits;


use function e;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;
use function lcfirst;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use function PHPUnit\Framework\isEmpty;
use Throwable;

trait PrinterTrait
{


    public function printTicket($header, $lines)
    {

            $printer = $this->connectToPrinter();

            $printer->text("\n \n");
            $printer->setTextSize(2, 2);
            $printer->text($header);
            $printer->text("\n \n");
            $printer->setTextSize(1, 1);
            foreach ($lines as $line) {
                $printer->text($line->attributes->product->name);
                $printer->text("\n");
            }


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