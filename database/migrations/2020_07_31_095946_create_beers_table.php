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
            $table->timestamp('consumed_on')->useCurrent();
            $table->string('name');               
            $table->integer('brewery_id')->unsigned();
            $table->foreign('brewery_id')
                ->references('id')->on('breweries');
            $table->integer('style_id')->unsigned();
            $table->foreign('style_id')
                ->references('id')->on('styles');
            $table->decimal('alc', 10, 1)->nullable();
            $table->decimal('ekst', 10, 1)->nullable();
            $table->integer('ibu')->nullable();
            $table->text('description')->nullable();
            $table->string('notes')->nullable();
            $table->decimal('rating', 10, 1)->nullable();
            $table->string('photo')->nullable();
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
