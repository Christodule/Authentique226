<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleQuotationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_quotation_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_quotation_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_combination_id')->nullable();
            $table->float('qty')->nullable();
            $table->float('price')->nullable();
            $table->float('total')->nullable();

            $table->foreign('sale_quotation_id')->references('id')->on('sale_quotations');
            $table->foreign('product_combination_id')->references('id')->on('product_combination');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_qoutation_details');
    }
}
