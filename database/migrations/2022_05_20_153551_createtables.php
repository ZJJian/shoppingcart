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
        Schema::dropIfExists('products');
        Schema::create('products', function (Blueprint $table) {
            $table->string('name');
            $table->string('sku',10)->unique();
            $table->decimal('price',7);
            $table->decimal('qty',5,0);
            $table->string('image');
            $table->timestamps();
            $table->primary('sku');
        });

        Schema::dropIfExists('generated_order_id');
        Schema::create('generated_order_id', function (Blueprint $table) {
            $table->string('order_id', 40)->unique();
            $table->string('status',10);
            $table->timestamps();
            $table->primary('order_id');
        });

        Schema::dropIfExists('orders');
        Schema::create('orders', function (Blueprint $table) {
            $table->string('order_id',40)->unique();
            $table->string('status',30);
            $table->decimal('total_price',7);
            $table->unsignedBigInteger('user_id')->comment("users.id");
            $table->timestamps();
            $table->primary('order_id');
            $table->index('user_id');
        });

        Schema::dropIfExists('order_lines');
        Schema::create('order_lines', function (Blueprint $table) {
            $table->string('order_id',40);
            $table->string('order_line_number',5);
            $table->string('sku',10);
            $table->decimal('net_price',7);
            $table->decimal('line_total',7);
            $table->decimal('qty',5);
            $table->timestamps();
            $table->primary(['order_id', 'order_line_number']);
        });

        Schema::dropIfExists('addresses');
        Schema::create('addresses', function (Blueprint $table) {
            $table->string('order_id',40);
            $table->string('type',10);
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->timestamps();
            $table->primary(['order_id', 'type']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('generated_order_id');
        Schema::dropIfExists('products');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_lines');
        Schema::dropIfExists('addresses');
    }
}
