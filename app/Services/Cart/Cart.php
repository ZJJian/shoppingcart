<?php

namespace App\Services\Cart;

use App\Models\Products;
use Illuminate\Support\Facades\Log;

class Cart
{
    const IDENTIFIER = 'CART';
    const CARTCOUNT = 'CARTCOUNT';

    public function __construct()
    {
        if (session_id() == '') {
            session_start();
        }
        if (!session()->has(self::IDENTIFIER)) {
            session()->put(self::IDENTIFIER, []);
            session()->put(self::CARTCOUNT, 0);
        }
    }

    public function add(String $sku)
    {
        $entry = $this->getEntry($sku);
        $entry['quantity']++;
        $this->save($sku, $entry);

        return $entry['quantity'];
    }

    public function remove(String $sku)
    {
        $entry = $this->getEntry($sku);
        $entry['quantity'] = max(0, --$entry['quantity']);
        $this->save($sku, $entry);

        return $entry['quantity'];
    }

    public function getQuantity(String $sku)
    {
        $entry = $this->getEntry($sku);
        return $entry['quantity'] ?? 0;
    }

    public function setQuantity(String $sku, $qty)
    {
        $entry = $this->getEntry($sku);
        if ($entry['quantity'] > 0) {
            $entry['quantity'] = (int) $qty;
        }
        $this->save($sku, $entry);
        return $entry['quantity'];
    }

    public function count()
    {
        $total = 0;
        foreach ($this->getAll() as $entry) {
            $total += ($entry['quantity'] > 0) ? $entry['quantity'] : 0;
        }
        return $total;
    }

    public function getAllData()
    {
        $cart = [];
        foreach ($this->getAll() as $entry) {
            if ($entry['quantity'] > 0) {
                $product = array_merge($entry,Products::where('sku', $entry['item'])->first()->toArray());
                $cart[$entry['item']] = $product;
            }
        }
        return $cart;
    }

    public function getAll()
    {
        return session()->get(self::IDENTIFIER);
    }

    public function clear()
    {
        session()->forget(self::IDENTIFIER);
        session()->forget(self::CARTCOUNT);
    }

    public function save($sku,$data)
    {
        session()->put(self::IDENTIFIER.'.'.$sku, $data);
        session()->put(self::CARTCOUNT, $this->count());
    }

    private function getEntry(String $sku)
    {
        foreach ($this->getAll() as $entry) {
            if (isset($entry['item']) && $entry['item'] == $sku) {
                Log::debug('[getEntry] ==sku : ' . json_encode($sku));
                return $entry;
            }
        }

        $new_entry = [
            'item' => $sku,
            'quantity' => 0,
        ];
        $this->save($sku, $new_entry);
        return $new_entry;
    }
}
