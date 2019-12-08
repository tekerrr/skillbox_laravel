<?php

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
        // 0. Тестовое заполение таблиц
        DB::table('posts')->insert([
            [
                'owner_id'  => 1,
                'slug'      => 'slug1',
                'title'     => 'title1',
                'abstract'  => 'abstract1',
                'body'      => 'body1',
                'is_active' => true,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'owner_id'  => 2,
                'slug'      => 'slug2',
                'title'     => 'title2',
                'abstract'  => 'abstract2',
                'body'      => 'body2',
                'is_active' => true,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
        ]);

        DB::table('tags')->insert([
            [
                'name' => 'name1',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'name2',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
        ]);

        DB::table('post_tag')->insert([
            ['tag_id' => 1, 'post_id' => 1],
            ['tag_id' => 2, 'post_id' => 2],
        ]);

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
                'taggable_type' => \App\Post::class,
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
        Schema::dropIfExists('post_tag');
    }
}
