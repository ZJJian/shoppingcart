<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderLines;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $guarded = []; //設定空白黑名單 = 開放所有欄位操作
    protected $primaryKey = ['order_id'];//updateOrCreate需要的複合鍵，非DB primary key
    public $incrementing = false;
    protected $keyType = 'string';//主鍵設定為string

    public function orderLine()
    {
        return $this->hasMany(OrderLines::class, 'order_id', 'order_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:m:i');
    }

}
