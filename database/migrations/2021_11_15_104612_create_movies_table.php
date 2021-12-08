<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("subtitle")->nullable();
            $table->string('pubDate')->nullable();
            $table->string("director")->nullable();
            $table->string("actor")->nullable();
            $table->integer("userRating")->nullable();
            $table->integer("totalRating")->nullable();
            $table->integer("ratingCount")->nullable();
            $table->string("image_path")->nullable();
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
        Schema::dropIfExists('movies');
    }
}
