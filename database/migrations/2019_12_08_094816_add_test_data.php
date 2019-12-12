<?php

use App\Post;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTestData extends Migration
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
                'owner_id'   => 1,
                'slug'       => 'slug1',
                'title'      => 'title1',
                'abstract'   => 'abstract1',
                'body'       => 'body1',
                'is_active'  => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'owner_id'   => 2,
                'slug'       => 'slug2',
                'title'      => 'title2',
                'abstract'   => 'abstract2',
                'body'       => 'body2',
                'is_active'  => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('tags')->insert([
            [
                'name'       => 'name1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'       => 'name2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('post_tag')->insert([
            ['tag_id' => 1, 'post_id' => 1],
            ['tag_id' => 2, 'post_id' => 2],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('posts')->where('slug', 'slug1')->delete();
        DB::table('posts')->where('slug', 'slug2')->delete();

        DB::table('tags')->where('name', 'name1')->delete();
        DB::table('tags')->where('name', 'name2')->delete();
    }
}
