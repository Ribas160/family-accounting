<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';
    protected $guarded = [];

    /**
     * @param $name
     * @param $color
     * @return string
     */
    public static function createCategory($request)
    {
        $validate = self::validateCategory($request);
        if ($validate !== true) return json_encode($validate);

        Categories::create([
           'name' => $request['name'],
           'color' => $request['color'],
        ]);

        return self::getCategories();
    }

    /**
     * @return mixed
     */
    public static function getCategories()
    {
        return Categories::all();
    }

    /**
     * @param $request
     * @return mixed
     */
    public static function deleteCategory($request)
    {
        Categories::where('id', $request['id'])->delete();
        return self::getCategories();
    }

    /**
     * @param $request
     * @return array|bool
     */
    private static function validateCategory($request)
    {
        $errors = [];

        if (empty($request['name'])) $errors['message']['name'] =  'Поле обязательно для заполнения';
        if (empty($request['color'])) $errors['message']['color'] =  'Поле обязательно для заполнения';
        if (!empty($errors)) return $errors;

        $categoryName = Categories::where('name', $request['name'])->first();
        $categoryColor = Categories::where('color', $request['color'])->first();

        if (!empty($categoryName)) $errors['message']['name'] = 'Категория с таким названием уже существует';
        if (!empty($categoryColor)) $errors['message']['color'] = 'Категория с таким цветом уже существует';

        return (!empty($errors)) ? $errors : true;
    }
}
