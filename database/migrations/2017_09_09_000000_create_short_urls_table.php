<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShortUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('short_urls', function (Blueprint $table) {
            $table->bigIncrements('link_id');
            $table->string('short_url')->unique();
            $table->string('long_url');
            $table->string('url_name')->nullable();
            $table->boolean('registed');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->timestampsTz();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('short_urls', function (Blueprint $table) {
            $table->dropForeign('short_urls_user_id_foreign');
        });
        Schema::dropIfExists('short_urls');
    }
}
