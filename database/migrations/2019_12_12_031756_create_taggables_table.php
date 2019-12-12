<?php

use App\Post;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaggablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Создание таблицы
        Schema::create('taggables', function (Blueprint $table) {
            $table->unsignedBigInteger('tag_id');
            $table->morphs('taggable');

            $table->primary(['tag_id', 'taggable_id', 'taggable_type']);
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });

        // 2. Копирование старых данных в новую таблицы
        $data = DB::table('post_tag')->get()->map(function ($row) {
            return [
                'tag_id'        => $row->tag_id,
                'taggable_id'   => $row->post_id,
                'taggable_type' => Post::class,
            ];
        })->toArray();
        DB::table('taggables')->insert($data);

        // 3. Удаление старой таблицы
        Schema::drop('post_tag');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('post_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('tag_id');
            $table->unsignedBigInteger('post_id');
            $table->primary(['tag_id', 'post_id']);
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });

        $data = DB::table('taggables')->where('taggable_type', Post::class)->get()->map(function ($row) {
            return [
                'tag_id'  => $row->tag_id,
                'post_id' => $row->taggable_id,
            ];
        })->toArray();
        DB::table('post_tag')->insert($data);

        Schema::dropIfExists('taggables');
    }
}
