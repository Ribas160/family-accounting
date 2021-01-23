<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{

    protected $table = 'payments';
    protected $guarded = [];

    /**
     * @param $payment
     */
    public static function savePayment($payment)
    {
        foreach ($payment['items'] as $item) {
            preg_match('/[a-zA-ZА-яА-Я][\s\S]+/', $item['name'], $name);
            Payments::create([
                'store' => $payment['user'],
                'product' => $name[0],
                'price' => substr_replace($item['price'], ",", -2, 0),
                'date' => date('Y-m-d', strtotime($payment['dateTime'])),
            ]);
        }
    }


    /**
     * @param $products
     */
    public static function setCategory($products)
    {
        foreach ($products as $product) {
            Payments::where('product', 'LIKE', '%' . $product->name . '%')->update(['category' => $product->category]);
        }
    }


    /**
     * @param $products
     */
    public static function deleteCategory($products)
    {
        foreach ($products as $product) {
            Payments::where('product', 'LIKE', '%' . $product->name . '%')->update(['category' => 'Другое']);
        }
    }


    /**
     * @return mixed
     */
    public static function getHistory()
    {
       return Payments::where('date', 'LIKE', '%' . date('Y-m') . '%')->orderBy('date', 'asc')->get();
    }
}
