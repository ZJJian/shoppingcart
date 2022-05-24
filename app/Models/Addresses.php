<?php

namespace App\Models;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class Addresses extends Model
{

    protected $table = 'addresses';
    protected $guarded = []; //設定空白黑名單 = 開放所有欄位操作
    protected $primaryKey = ['order_id', 'type'];//updateOrCreate需要的複合鍵，非DB primary key
    public $incrementing = false;
    protected $keyType = 'string';//主鍵設定為string

    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id', 'order_id');
    }

    //first_name, last_name, address1, address2, city, state, zip, phone, email
    /*
    * set<Column>Attribute
    * get<Column>Attribute
    * 用於 ORM 撈取欄位額外做的處理 (加密)
    * @param $value
    * @return mixed
    */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Crypt::encryptString($value);
    }

    public function getNameAttribute($value)
    {
        try {
            $value = Crypt::decryptString($value);
        } catch (DecryptException $e) {
            Log::debug('Decrypt address[name] error: ' . $e->getMessage());
        }
        return $value;
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = Crypt::encryptString($value);
    }

    public function getAddressAttribute($value)
    {
        try {
            $value = Crypt::decryptString($value);
        } catch (DecryptException $e) {
            Log::debug('Decrypt address[address] error: ' . $e->getMessage());
        }
        return $value;
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = Crypt::encryptString($value);
    }

    public function getPhoneAttribute($value)
    {
        try {
            $value = Crypt::decryptString($value);
        } catch (DecryptException $e) {
            Log::debug('Decrypt address[phone] error: ' . $e->getMessage());
        }
        return $value;
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = Crypt::encryptString($value);
    }

    public function getEmailAttribute($value)
    {
        try {
            $value = Crypt::decryptString($value);
        } catch (DecryptException $e) {
            Log::debug('Decrypt address[email] error: ' . $e->getMessage());
        }
        return $value;
    }

}
