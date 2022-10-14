<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStocksViews extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE VIEW stock_balance AS
          SELECT acc_products.id, name , IFNULL(sum(acc_invendetails.qty), 0) as stock_balance
            FROM acc_products
            LEFT JOIN acc_invendetails On acc_products.id = acc_invendetails.item_id
			INNER JOIN acc_invenmasters On acc_invenmasters.id = acc_invendetails.im_id
             group by name ");
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS stock_balance');
    }

}