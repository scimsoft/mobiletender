<?php
/**
 * Created by PhpStorm.
 * User: Gerrit
 * Date: 02/06/2020
 * Time: 18:31
 */

namespace App\UnicentaModels;


use JsonSerializable;

class SharedTicketLines
{
    public $m_sTicket;
    public $m_iLine;
    public $multiply;
    public $price;
    public $tax;
    public $attributes;
    public $productid;
    public $updated;
    public $newprice;


    public function __construct($ticket,$product,$count,$updated=true)
    {
        $this->m_sTicket = $ticket->m_sId;
        $this->m_iLine = $count;
        $this->multiply = 1.0;
        $this->price = $product->pricesell;
        $this->tax=new TaxCat();
        $this->attributes = new ProductAttributes($product);
        $this->productid = $product->id;
        $this ->updated = $updated;
        $this->newprice=0;
    }
    public function setPrinted(){
        $this->attributes->setPrinted();
    }
    public function setLineNumber($count){
        $this->m_iLine = $count;
    }




}

class TaxCat
{
    public $id = '001';
    public $name = 'Tax Standard';
    public $taxcategoryid = '001';
    public $rate = 0.1;
    public $cascade = false;

    public function __construct()
    {

    }
}

class ProductAttributes implements JsonSerializable
{
    public $taxcategoryid = '001';
    protected $product;
    protected $updated = true;

    public function __construct($product)
    {
        $this->product = $product;

    }

    public function setPrinted(){
        $this->updated=false;
    }

    public function getPrinted(){
        return $this->updated;
    }


    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
        return [

            "product.taxcategoryid" => $this->taxcategoryid,
            "product.warranty" => "false",
            "product.memodate" => "2018-01-01 00:00:01.0",
            "product.verpatrib" => "false",
            "product.reference" => $this->product->reference,
            "product.name" => $this->product->name,
            "product.com" => "false",
            "product.code" => $this->product->code,
            "product.constant" => "false",
            "ticket.updated" => $this->updated,
            "product.categoryid" => $this->product->category,
            "product.printer" => $this->product->printto,
            "product.vprice" => "false",



            ];
    }
}