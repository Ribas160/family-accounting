<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Doughnut extends Model
{
    public static function index($request)
    {
        $categories = DB::table('categories')->get();
        $value = [];
        foreach ($categories as $category) {
            $payments = DB::table('payments')
                ->where([
                    ['category', $category->name],
                    ['date', 'LIKE', '%' . $request['date'] . '%']
                ])
                ->get();
            $price = 0;
            foreach ($payments as $payment) {
                $price = $price + (float) $payment->price;
            }
            $value['labels'][] = $category->name;
            $value['backgroundColor'][] = $category->color;
            $value['data'][] = $price;
        }
        $otherPayments = DB::table('payments')
            ->where([
                ['category', 'Другое'],
                ['date', 'LIKE', '%' . $request['date'] . '%']
            ])
            ->get();
        $value['labels'][] = 'Другое';
        $value['backgroundColor'][] = 'grey';
        $otherPrice = 0;
        foreach ($otherPayments as $otherPayment) {
            $otherPrice = $otherPrice + (float) $otherPayment->price;
        }
        $value['data'][] = $otherPrice;
        return $value;
    }
}
