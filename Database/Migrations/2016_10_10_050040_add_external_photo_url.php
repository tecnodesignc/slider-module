<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExternalPhotoUrl extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slider__slides', function(Blueprint $table)
        {
            $table->text('external_image_url')->default('')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slider__slides', function(Blueprint $table)
        {
            $table->dropColumn('external_image_url');
        });
    }

}
