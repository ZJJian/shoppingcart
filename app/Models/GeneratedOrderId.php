<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratedOrderId extends Model
{
    use HasFactory;

    protected $table = 'generated_order_id';
    protected $guarded = []; //設定空白黑名單 = 開放所有欄位操作
    protected $primaryKey = ['order_id'];//updateOrCreate需要的複合鍵，非DB primary key
    public $incrementing = false;
    protected $keyType = 'string';//主鍵設定為string


}
