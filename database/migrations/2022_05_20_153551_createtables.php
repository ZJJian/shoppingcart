<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createtables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('customers'))
        {
            Schema::create('customers', function (Blueprint $table) {
                $table->bigIncrements('customer_id');
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('products'))
        {
            Schema::create('products', function (Blueprint $table) {
                //$table->bigIncrements('product_id');
                $table->string('name');
                $table->string('sku',10)->unique();
                $table->decimal('price',7,2);
                $table->decimal('qty',5);
                $table->string('image');
                $table->timestamps();
                $table->primary('sku');
            });
        }

        if (!Schema::hasTable('orders'))
        {
            Schema::create('orders', function (Blueprint $table) {
                //$table->id();
                $table->string('order_id',10)->unique();
                $table->string('status',10);
                $table->decimal('total_price',7,2);
                $table->unsignedBigInteger('customer_id')->comment("customers.customers_id");
                $table->timestamps();
                $table->primary('order_id');
            });
        }

        if (!Schema::hasTable('order_lines'))
        {
            Schema::create('order_lines', function (Blueprint $table) {
                //$table->id();
                $table->string('order_id',10);
                $table->string('order_line_number',5);
                $table->string('sku',10);
                $table->decimal('net_price',7,2);
                $table->decimal('line_total',7,2);
                $table->decimal('qty',5);
                $table->timestamps();
                $table->primary(['order_id', 'order_line_number']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
        Schema::dropIfExists('products');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_lines');

    }
}
