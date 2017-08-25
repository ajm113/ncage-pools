<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';


    /**
     * Fetch all products from database for displaying results to page or other applications. This method does not support filtering.
     *
     * @return array
     */
    public static function fetchAllProducts()
    {
        return self::get()->toArray();
    }

    /**
     * Fetch all products from database for displaying results to page or other applications. This method does not support filtering.
     *
     * @param int $productId
     * @return array
     */
    public static function fetchProduct($productId)
    {
        $productId = intval($productId);

        return self::limit(1)
        ->where('id', $productId)
        ->first()
        ->toArray();
    }
}
