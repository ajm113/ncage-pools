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
        return self::fetchAllWith($options)->toArray();
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

        $query = self::fetchAllWith($options);

        return $query->first()->toArray();
    }

    /**
     * Creates a query based on parems we used in QueryOptionsBuilder.
     *
     * @param QueryOptionsBuilder $options
     * @return array
     */
    public static function fetchAllWith(QueryOptionsBuilder $options)
    {
        // Define our filter scheme
        $options->setFilterScheme([
            'name',
            'brand',
            'type',
            'id',
            'aboveGround',
            'category',
            'priceFrom',
            'priceTo'
        ]);

        $options->setSortByScheme([
            'name',
            'price'
        ]);

        $options->check();

        $query = new Products();

        if($options->getFilterItem('name'))
        {
            $query->where('name', 'like', $options->getFilterItem('name') . '%');
        }

        if($options->getFilterItem('brand'))
        {
            $query->where('brand', 'like', $options->getFilterItem('brand') . '%');
        }

        if($options->getFilterItem('category'))
        {
            $query->where('category', 'like', $options->getFilterItem('category') . '%');
        }

        if($options->getFilterItem('id'))
        {
            $query->where('id', intval($options->getFilterItem('id')));
        }

        if($options->getFilterItem('priceFrom'))
        {
            $query->where('price', '>', $options->getFilterItem('priceFrom'));
        }

        if($options->getFilterItem('priceTo'))
        {
            $query->where('price', '<', $options->getFilterItem('priceTo'));
        }

        if($options->getFilterItem('aboveGround'))
        {
            $query->where('aboveGround', $options->getFilterItem('aboveGround'));
        }

        if($options->getLimit())
            $query->limit($options->getLimit());

        if($options->getSortBy())
            $query->orderBy($options->getSortBy()[0], $options->getSortBy()[1]);

        return $query->get();
    }
}
