<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddClosedCashStart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::table('closedcash')->insert([
        'MONEY' => 'START',
        'HOST' => '1',
        'HOSTSEQUENCE' => '1',
        'DATESTART' => Carbon::now() ,
        'NOSALES' => '1'
      ]
    );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
