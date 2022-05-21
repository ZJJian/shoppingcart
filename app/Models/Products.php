<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $guarded = []; //設定空白黑名單 = 開放所有欄位操作
    protected $primaryKey = ['sku'];//updateOrCreate需要的複合鍵，非DB primary key
    public $incrementing = false;
    protected $keyType = 'string';//主鍵設定為string

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = 'mysql';
    }

    /**
     * response format in this service
     * @param  $code
     * @param  $msg
     * @param  $data
     *
     * @return array
     *
     */
    private function responseFormat($code, $msg, $data = []): array
    {
        return [
            'status' => $code,
            'msg' => $msg,
            'data' => $data,
        ];
    }


    /**
     * @return array
     */
    public function getProducts(): array
    {
        try {
            $products = Products::all();

            return Products::responseFormat(200, 'Success', $products->toArray());

        } catch (Exception $exception) {
            return Products::responseFormat($exception->getCode(), $exception->getMessage());
        }

    }


}
