<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->char('id', 26)->primary();
            $table->string('title');
            $table->string('alt_title')->nullable();
            $table->string('type')->default('main'); // main, remix, live, concert
            $table->string('availability')->default('unreleased');
            $table->datetime('released_at')->nullable();
            $table->datetime('first_time_played_at')->nullable();
            $table->longText('details')->nullable();
            $table->string('variant_agg')->nullable();
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
        Schema::dropIfExists('songs');
    }
}
