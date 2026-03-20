<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->date("date")->nullable();
            $table->date("last_change_date")->nullable();

            $table->string("supplier_article")->nullable();
            $table->string("tech_size")->nullable();
            $table->integer("barcode");
            $table->integer("quantity")->nullable();
            $table->integer("quantity_full")->nullable();

            $table->boolean("is_supply")->nullable();
            $table->boolean("is_realization")->nullable();

            $table->string("warehouse_name");
            
            $table->integer("in_way_to_client")->nullable();
            $table->integer("in_way_from_client")->nullable();

            $table->integer("nm_id");
            $table->string("subject")->nullable();
            $table->string("category")->nullable();
            $table->string("brand")->nullable();
            $table->integer("sc_code");
            
            $table->string("price")->nullable();
            $table->string("discount")->nullable();

            $table->unique(["nm_id", "sc_code", "barcode", "warehouse_name"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
