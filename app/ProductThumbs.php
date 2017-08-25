<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductThumbs extends Model
{
    protected $table = 'product_thumbs';

    /**
     * Fetches thumb(s) for our product we want to add to.
     *
     * @param array $product
     * @param boolean $onlyCover
     * @return array
     */
    public static function fetchIntoProduct(array $product, $onlyCover = false)
    {
        return current(self::fetchIntoProducts([$product], $onlyCover));
    }

    /**
     * Fetches thumbs for our product(s) we want to add to.
     *
     * @param array $products
     * @param boolean $onlyCovers
     * @return array
     */
    public static function fetchIntoProducts(array $products, $onlyCovers = true)
    {
        $productIds = []; // List of ids we need to use for our cover images.

        foreach ($products as $product)
        {
            $productIds[] = $product['id'];
        }

        $thumbs = self::whereIn('product_id', $productIds);

        if($onlyCovers)
        {
            $thumbs->distinct();
        }

        $thumbs = $thumbs->get()->toArray();

        // Now iterate through all the found covers
        // and apply them to the products.
        foreach ($thumbs as $thumb)
        {
            foreach ($products as &$product) // Iterate through our products.
            {
                // If cover and product id match, append the cover to the images array.
                if($product['id'] == $thumb['product_id'])
                {
                    $product['images'][] = $thumb['url'];
                    break;
                }
            }
        }

        return $products;
    }
}
