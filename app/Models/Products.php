<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';
    protected $guarded = [];


    /**
     * @param $request
     * @return mixed
     */
    public static function createProduct($request)
    {

        $validate = self::validateProduct($request);
        if ($validate !== true) return json_encode($validate);

        Products::create([
            'name' => $request['name'],
            'category' => $request['category'],
        ]);

        return self::getProducts($request['category']);
    }


    /**
     * @param $categoryName
     * @return mixed
     */
    public static function getProducts($category)
    {
        return Products::where('category', $category)->get();
    }


    /**
     * @param $request
     * @return mixed
     */
    public static function deleteProduct($request)
    {
        Products::where('id', $request['id'])->delete();
        return self::getProducts($request['category']);
    }


    private static function validateProduct($request)
    {
        $errors = [];

        if (empty(htmlspecialchars($request['name']))) $errors['message']['name'] = 'Поле "Название" обязательно для заполнения';

        $productName = Products::where('name', $request['name'])->first();

        if (!empty($productName)) $errors['message']['name'] = 'Такой товар уже добавлен в категорию ' . $productName->category;

        return (!empty($errors)) ? $errors : true;
    }
}
