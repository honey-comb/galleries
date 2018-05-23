<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHcGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hc_gallery', function (Blueprint $table) {
            $table->increments('count');
            $table->uuid('id')->unique();
            $table->datetime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->datetime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->datetime('deleted_at')->nullable();

            $table->datetime('published_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->string('label');
            $table->text('description');

            $table->uuid('created_by')->nullable();
            $table->uuid('cover_id')->nullable();

            $table->boolean('warning_flag')->default(0);
            $table->text('warning_content')->nullable();

            $table->boolean('show_titles')->default(1);
            $table->boolean('show_descriptions')->default(1);
            $table->boolean('hidden')->default(0);

            $table->integer('views')->default(0);
            $table->integer('imageViews')->default(0);

            $table->foreign('created_by')->references('id')->on('hc_user')->onDelete('SET NULL');
            $table->foreign('cover_id')->references('id')->on('hc_resource')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hc_gallery');
    }
}
