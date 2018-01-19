<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( !Schema::hasTable('cities') ){
            Schema::create('cities', function (Blueprint $table) {
                $table->increments('id');
                $table->string('city',50);
                $table->string('state_code',2);
                $table->integer('zip')->unsigned();
                $table->double('latitude');
                $table->double('longitude');
                $table->string('country',50);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if( Schema::hasTable('cities') ){
            Schema::dropIfExists('cities');
        }
    }
}
