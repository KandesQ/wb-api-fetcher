<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string("g_number");

            $table->date("date")->nullable();
            $table->date("last_change_date")->nullable();

            $table->string("supplier_article")->nullable();
            $table->string("tech_size")->nullable();
            
            $table->integer("barcode");
            
            $table->string("total_price")->nullable();

            $table->integer("discount_percent")->nullable();
            
            $table->string("warehouse_name")->nullable();
            $table->string("oblast")->nullable();

            $table->unsignedBigInteger("income_id")->nullable();

            $table->string("odid")->nullable();

            $table->string("nm_id");

            $table->string("subject")->nullable();
            $table->string("category")->nullable();
            $table->string("brand")->nullable();

            $table->boolean("is_cancel")->nullable();

            $table->date("cancel_dt")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
