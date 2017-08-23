<?php

use Illuminate\Database\Seeder;

// Needed to generate the seeder for our application.
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class ProductsSeeder extends Seeder
{

    const API_END_POINT = 'http://www.poolsupplyworld.com/api.cfm';
    const API_END_POINT_KEY = 'OD3P65A4CVZEOYQ-andrew';
    const API_END_POINT_TIMEOUT = 30;           // I know this seems like overkill, but the API is reaally slow sometimes.

    private $client = null;                     // Our Guzzle client.
    protected $headers = [                      // Anything we may want to pass to the API.
        'authkey' => self::API_END_POINT_KEY
    ];

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => self::API_END_POINT,
            'timeout' => self::API_END_POINT_TIMEOUT
        ]);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $products = $this->fetchProducts(); // First fetch the products from the API

        foreach ($products as $productId)
        {
            $product = $this->fetchProduct($productId);

            if(!$product) // If the product object is empty, let's continue.
                continue;

            // For some reason we must assume this value is never set always.
            $isAboveGround = (!isset($product['aboveground'])) ? false : boolval($product['aboveground']);

            // Insert the product into the DB.
            DB::table('products')->insert([
                'id' => intval($product['id']),
                'aboveground' => $isAboveGround,
                'description' => strip_tags($product['description']),
                'type' => strip_tags($product['type']),
                'name' => strip_tags($product['name']),
                'brand' => strip_tags($product['brand']),
                'price' => rand ( 100, 500 )                // API doesn't offer price, so we generate a random one for now.
            ]);

            // Now insert the thumbnails into the 'product_thumbs'
            foreach ($product['images'] as $image)
            {
                DB::table('product_thumbs')->insert([
                    'product_id' => intval($product['id']),
                    'url' => strip_tags($image)
                ]);
            }
        }
    }

    /**
     * Fetches the products from the API enpoint and return as valid PHP array.
     *
     * @return array
     */
    protected function fetchProducts()
    {
        $response = $this->client->request('GET', '', ['headers' => $this->headers]);
        return $this->convertResponseToObject($response);
    }

    /**
     * Returns the requested product information.
     *
     * @return array
     */
    protected function fetchProduct($productId)
    {
        $productId = intval($productId); // We sanatize the input for security reasons!

        $response = $this->client->request('GET', '?productid=' . $productId, ['headers' => $this->headers] );
        return $this->convertResponseToObject($response);
    }

    /**
     * Converts our Guzzle response object into a PHP array/object.
     *
     * @return object|array|null
     */
    private function convertResponseToObject($response)
    {
        if($response->getStatusCode() != 200)
            return [];

        $body = (string)$response->getBody();
        return json_decode($body, true);
    }
}
