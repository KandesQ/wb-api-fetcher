<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string("g_number")->nullable();
            
            $table->date("date")->nullable();
            $table->date("last_change_date")->nullable();
            
            $table->string("supplier_article")->nullable();
            $table->string("tech_size")->nullable();
            
            $table->integer("barcode")->nullable();

            $table->string("total_price")->nullable();
            $table->string("discount_percent")->nullable();

            $table->boolean("is_supply")->nullable();
            $table->boolean("is_realization")->nullable();

            $table->string("promo_code_discount")->nullable();
            $table->string("warehouse_name")->nullable();
            $table->string("country_name")->nullable();
            $table->string("oblast_okrug_name")->nullable();
            $table->string("region_name")->nullable();

            $table->unsignedBigInteger("income_id")->nullable();

            // unique
            $table->string("sale_id")->unique();
            
            $table->string("odid")->nullable();
            $table->string("spp")->nullable();
            $table->string("for_pay")->nullable();
            $table->string("finished_price")->nullable();
            $table->string("price_with_disc")->nullable();
            
            $table->integer("nm_id")->nullable();

            $table->string("subject")->nullable();
            $table->string("category")->nullable();
            $table->string("brand")->nullable();

            $table->boolean("is_storno")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
