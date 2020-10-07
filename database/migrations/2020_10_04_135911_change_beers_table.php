<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeBeersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beers', function ($table) {            
            $table->float('alc')->nullable()->change();
            $table->float('ekst')->nullable()->change();
            $table->integer('ibu')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->string('notes')->nullable()->change();
            $table->float('rating')->nullable()->change();
            $table->string('photo')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
