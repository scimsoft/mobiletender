<?php
/**
 * Created by PhpStorm.
 * User: Gerrit
 * Date: 23/10/2020
 * Time: 21:34
 */
namespace App\Traits;



trait PrinterTrait{



//    public function printTicket($lines)
//    {
//
//        Log::debug('printerline: ' . $lines);
//        Log::debug('printer datos: ' . config('app.kitchen-printer-ip') . ' port: ' . config('app.kitchen-printer-port'));
//        try {
//            $connector = new NetworkPrintConnector(config('app.kitchen-printer-ip'), config('app.kitchen-printer-port'), 3);
//            $printer = new Printer($connector);
//            $printer->text("\n \n");
//            $printer->setTextSize(2, 2);
//            $printer->text($lines);
//            $printer->text("\n \n");
//            $printer->cut();
//            $printer -> getPrintConnector() -> write(PRINTER::ESC . "B" . chr(4) . chr(1));
//            $printer -> getPrintConnector() -> write(PRINTER::ESC . "B" . chr(4) . chr(1));
//            $printer->close();
//        } catch (Throwable $e) {
//            return abort('503', 'No se puede imprimir el pedido, avisa a la camarera por favor');
//        }
//    }


}