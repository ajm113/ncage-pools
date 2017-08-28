<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\QueryOptionsBuilder;

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
        $options = new QueryOptionsBuilder();
        $options->setLimit(null);
        return self::fetchWith($options)->get()->toArray();
    }

    /**
     * Fetch all products from database for displaying results to page or other applications. This method does not support filtering.
     *
     * @param int $productId
     * @return array
     */
    public static function fetchProduct($productId)
    {

        $options = new QueryOptionsBuilder();

        $options->setFilter([
            'id' => intval($productId)
        ]);

        $options->setLimit(1);

        return self::fetchWith($options)->get()->first()->toArray();
    }

    public static function fetchSuggestedProducts(array $product)
    {
        $options = new QueryOptionsBuilder();
        $options->setFilter([
            'type' => $product['type'],
            'aboveground' => $product['aboveground'],
            'excludeId' => $product['id']
        ]);

        $options->setLimit(9);

       return self::fetchWith($options)->get()->toArray();
    }

    /**
     * Creates a query based on parems we used in QueryOptionsBuilder.
     *
     * @param QueryOptionsBuilder $options
     * @return array
     */
    public function scopeFetchWith($query, QueryOptionsBuilder $options)
    {
        // Define our filter scheme
        $options->setFilterScheme([
            'name',
            'brand',
            'type',
            'id',
            'aboveground',
            'type',
            'priceFrom',
            'priceTo',
            'excludeId'
        ]);

        $options->setSortByScheme([
            'name',
            'price'
        ]);

        $options->check();

        if($options->getFilterItem('name'))
        {
            $query->where('name', 'like', $options->getFilterItem('name') . '%');
        }

        if($options->getFilterItem('brand'))
        {
            $query->where('brand', 'like', $options->getFilterItem('brand') . '%');
        }

        if($options->getFilterItem('type'))
        {
            $query->where('type', 'like', $options->getFilterItem('type') . '%');
        }

        if($options->getFilterItem('id'))
        {
            $query->where('id', intval($options->getFilterItem('id')));
        }

        if($options->getFilterItem('excludeId'))
        {
            $query->where('id', '!=', intval($options->getFilterItem('excludeId')));
        }

        if($options->getFilterItem('priceFrom'))
        {
            $query->where('price', '>', $options->getFilterItem('priceFrom'));
        }

        if($options->getFilterItem('priceTo'))
        {
            $query->where('price', '<', $options->getFilterItem('priceTo'));
        }

        if($options->getFilterItem('aboveground'))
        {
            $query->where('aboveground', $options->getFilterItem('aboveground'));
        }

        if($options->getLimit())
            $query->limit($options->getLimit());

        if($options->getSortBy())
            $query->orderBy($options->getSortBy()[0], $options->getSortBy()[1]);

        return $query;
    }
}
