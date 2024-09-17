<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('blog')) {
            Schema::create('blog', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('title', 100);
                $table->text('message');
                $table->softDeletes();
                $table->timestamps();

                $table->foreign('user_id', 'FK_user_blog_user_id')->references('id')->on('users');
            });
        }

        if (!Schema::hasTable('c_category')) {
            Schema::create('c_category', function (Blueprint $table) {
                $table->id();
                $table->integer('order');
                $table->string('code', 50);
                $table->string('name', 50);
                $table->softDeletes();
                $table->timestamps();

                $table->unique('code', 'UNIQ_c_category_code');
            });
        }

        if (!Schema::hasTable('blog_category_relation')) {
            Schema::create('blog_category_relation', function (Blueprint $table) {
                $table->unsignedBigInteger('blog_id');
                $table->unsignedBigInteger('category_id');

                $table->foreign('blog_id', 'FK_blog_category_relation_blog_id')
                    ->references('id')->on('blog');
                $table->foreign('category_id', 'FK_blog_category_relation_category_id')
                    ->references('id')->on('c_category');
                $table->index('blog_id', 'IDX_blog_category_relation_blog_id');
                $table->index('category_id', 'IDX_blog_category_relation_category_id');
            });
        }

        if (!Schema::hasTable('comment')) {
            Schema::create('comment', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('blog_id');
                $table->unsignedBigInteger('user_id');
                $table->text('message');
                $table->softDeletes();
                $table->timestamps();

                $table->foreign('blog_id', 'FK_comment_blog_id')->references('id')->on('blog');
                $table->foreign('user_id', 'FK_comment_user_id')->references('id')->on('users');
                $table->index('blog_id', 'IDX_comment_blog_id');
                $table->index('user_id', 'IDX_comment_user_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog');
        Schema::dropIfExists('c_category');
        Schema::dropIfExists('blog_category_relation');
        Schema::dropIfExists('comment');
    }
};
