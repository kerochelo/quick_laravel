<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title')->unique();
            $table->string('slug')->nullable()->unique();
            $table->string('eyecatch')->nullable()->default(null);
            $table->integer('eyecatch_align')->default(0);
            $table->integer('eyecatch_width')->default(100);
            $table->string('description')->nullable();
            $table->text('body')->nullable();
            $table->integer('state')->default(0);
            $table->integer('category_id')->nullable()->defalut(null);
            $table->integer('author_id')->nullable()->defalut(null);
            $table->datetime('published_at')->nullable();
            $table->datetime('deleted_at')->nullable();
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
        Schema::dropIfExists('articles');
    }
};
