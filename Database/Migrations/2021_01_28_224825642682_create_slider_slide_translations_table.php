<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSliderSlideTranslationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slider__slide_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('slide_id')->unsigned();
            $table->text('custom_html')->nullable();
            $table->string('title')->nullable();
            $table->string('caption')->nullable();
            $table->string('url')->nullable();
            $table->string('uri')->nullable();
            $table->boolean('active')->default(false);
            $table->string('locale')->index();
            $table->unique(['slide_id', 'locale']);
            $table->foreign('slide_id')->references('id')->on('slider__slides')->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('slider__slide_translations');
    }

}
