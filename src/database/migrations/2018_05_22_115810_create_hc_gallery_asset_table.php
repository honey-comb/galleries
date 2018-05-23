<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHCGalleryAssetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hc_gallery_asset', function (Blueprint $table) {
            $table->increments('count');
            $table->datetime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->uuid('gallery_id');
            $table->uuid('resource_id');
            $table->uuid('added_by')->nullable();

            $table->integer('sequence');

            $table->unique(['gallery_id', 'resource_id']);

            $table->string('label')->nullable();
            $table->text('description')->nullable();

            $table->foreign('gallery_id')->references('id')->on('hc_gallery')->onDelete('CASCADE');
            $table->foreign('resource_id')->references('id')->on('hc_resource')->onDelete('CASCADE');
            $table->foreign('added_by')->references('id')->on('hc_user')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hc_gallery_asset');
    }
}
