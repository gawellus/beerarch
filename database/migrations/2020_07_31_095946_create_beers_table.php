<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')
                ->references('id')->on('countries')
                ->onDelete('cascade');                
            $table->integer('brewery_id')->unsigned();
            $table->foreign('brewery_id')
                ->references('id')->on('breweries')
                ->onDelete('cascade');            
            $table->integer('style_id')->unsigned();
            $table->foreign('style_id')
                ->references('id')->on('styles')
                ->onDelete('cascade');
            $table->float('alc');
            $table->float('ekst');
            $table->integer('ibu');
            $table->text('description');
            $table->string('notes');
            $table->float('rating');
            $table->string('photo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beers');
    }
}
