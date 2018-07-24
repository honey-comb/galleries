<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHcGalleryResourceTagConnectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hc_gallery_tag_connection', function (Blueprint $table) {
            $table->increments('count');
            $table->datetime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->uuid('gallery_id');
            $table->uuid('tag_id');

            $table->foreign('gallery_id')->references('id')->on('hc_gallery')->onDelete('CASCADE');
            $table->foreign('tag_id')->references('id')->on('hc_resource_tag')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hc_gallery_tag_connection');
    }
}
