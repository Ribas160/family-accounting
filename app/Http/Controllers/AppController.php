<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Doughnut;
use App\Models\Payments;
use App\Models\Products;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AppController extends Controller
{

    /**
     * @param Request $request
     * @return string
     */
    public function createCategory(Request $request)
    {
        return Categories::createCategory($request);
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return Categories::getCategories();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function deleteCategory(Request $request)
    {
        $products = Products::where('category', $request['name'])->get();
        foreach ($products as $product) {
            Payments::deleteCategory(Products::where('id', $product->id)->get());
            Products::deleteProduct(['id' => $product->id, 'category' => $product->category]);
        }
        return Categories::deleteCategory($request);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function createProduct(Request $request) {
        $products =  Products::createProduct($request);
        Payments::setCategory(Products::get());
        return $products;
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function getProducts(Request $request) {
        return Products::getProducts($request['category']);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function deleteProduct(Request $request) {
        Payments::deleteCategory(Products::where('id', $request['id'])->get());
        return Products::deleteProduct($request);
    }


    public function getHistory(Request $request)
    {
        return Payments::getHistory($request);
    }


    /**
     * @param Request $request
     */
    public function scan(Request $request)
    {
        $receipt = Receipt::scan($request['data']);
        Log::debug(print_r($receipt, true));
        if ($receipt['code'] !== 1) return ['error' => true, 'message' => $receipt['data']];
        Payments::savePayment($receipt['data']['json']);
        Payments::setCategory(Products::get());
        return ['error' => false, 'message' => 'Товары из чека сохранены'];
    }


    /**
     * @return array
     */
    public function doughnut(Request $request)
    {
        return Doughnut::index($request);
    }
}
