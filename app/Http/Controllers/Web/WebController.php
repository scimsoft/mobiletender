<?php
/**
 * Created by PhpStorm.
 * User: Gerrit
 * Date: 07/11/2020
 * Time: 11:25
 */

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;

class WebController extends Controller
{
    public function web()
    {
        return view('web.webindex');
    }

    public function products()
    {
        return view('web.webproducts');
    }
}