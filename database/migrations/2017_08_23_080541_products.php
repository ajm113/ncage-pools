<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Products extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->integer('id')->unique();    // This is prefilled from the API.
            $table->longText('description');    // Description of the product for display/search.
            $table->boolean('aboveground');     // If the item is above ground.
            $table->string('type');             // The item type.
            $table->string('name');             // Product name.
            $table->string('brand');            // Product brand.
            $table->timestamps();               // We can use this for our own purposes. Doesn't matter...
        });

        // Let's not assume product thumbnail amounts. So let's just throw everything into it's own table.
        // We could have simply added this migration into it's own file, but they both work together in this case.
        Schema::create('product_thumbs', function (Blueprint $table) {
            $table->increments('id');           // If we need to delete a particulare thumbnail for any reason.
            $table->integer('product_id');
            $table->string('url');              // Absolute path to the image.

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_thumbs');
    }
}
