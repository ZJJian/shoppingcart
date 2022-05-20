<?php

use App\Models\Products;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        $data = [
//            [['sku'=>'sku01'],['name'=>'Smart Watch', 'price' => 100, 'qty' => 10, 'image' => 'watch.jpg']],
//            [['sku'=>'sku02'],['name'=>'Wallet', 'price' => 200, 'qty' => 10, 'image' => 'wallet.jpg']],
//            [['sku'=>'sku03'],['name'=>'Headphones', 'price' => 150, 'qty' => 10, 'image' => 'headphones.jpg']],
//            [['sku'=>'sku04'],['name'=>'Digital Camera', 'price' => 300, 'qty' => 10, 'image' => 'camera.jpg']],
//        ];
////        foreach($data as $d){
//            Products::updateOrCreate(['sku'=>'sku01'],['name'=>'Smart Watch', 'price' => 100, 'qty' => 10, 'image' => 'watch.jpg']);
////        }
        Products::updateOrCreate(['sku'=>'sku01'],['name'=>'Smart Watch', 'price' => 100, 'qty' => 10, 'image' => 'watch.jpg']);

        Products::updateOrCreate(['sku'=>'sku02'],['name'=>'Wallet', 'price' => 200, 'qty' => 10, 'image' => 'wallet.jpg']);

        Products::updateOrCreate(['sku'=>'sku03'],['name'=>'Headphones', 'price' => 150, 'qty' => 10, 'image' => 'headphones.jpg']);

        Products::updateOrCreate(['sku'=>'sku04'],['name'=>'Digital Camera', 'price' => 300, 'qty' => 10, 'image' => 'camera.jpg']);


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
