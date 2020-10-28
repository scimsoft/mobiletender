<?php
/**
 * Created by PhpStorm.
 * User: Gerrit
 * Date: 27/10/2020
 * Time: 10:43
 */

namespace Tests;



use App\Traits\PrinterTrait;

class PrinterTraitTest extends TestCase
{
    use PrinterTrait;

    public function testPrinterConnection(){
        $printer = $this->connectToPrinter();
        self::assertNotEmpty($printer);



}

}
