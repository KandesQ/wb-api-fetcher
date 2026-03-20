<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger("income_id")->unique();
            $table->string("number")->nullable();

            $table->date("date")->nullable();
            $table->date("last_change_date")->nullable();
            
            $table->string("supplier_article")->nullable();
            $table->string("tech_size")->nullable();
            
            $table->integer("barcode")->nullable();
            $table->integer("quantity")->nullable();
            
            $table->string("total_price")->nullable();
            $table->string("date_close")->nullable();
            $table->string("warehouse_name")->nullable();
            
            $table->integer("nm_id")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incomes');
    }
}
