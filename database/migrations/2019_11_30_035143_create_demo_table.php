<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('name', 100);
            $table->boolean('boolean');
            $table->text('text');
            $table->integer('int');
            $table->unsignedInteger('uint');
            $table->dateTime('date_time');
            $table->timestamp('timestamp');
            $table->double('double');
            $table->timestamps();

            $table->string('name1', 100)->nullable()->unique();
            $table->string('name2', 100)->after('id');
            $table->string('name3', 100)->first();
            $table->string('name4', 100)->comment('comment');
            $table->string('name5', 100)->default('default');
            $table->timestamp('name6', 100)->useCurrent();
            $table->integer('name7', 100)->unsigned();

            $table->unique('name2', 'new_index_name');
            $table->primary('id');
            $table->index(['name1', 'name2']);

            $table->renameIndex('new_index_name', 'new_index_name2');
            $table->dropUnique('new_index_name2');
            $table->dropIndex(['name1', 'name2']);

            $table->foreign('user_id')->references('users')->on('id')->onDelete('cascade')->onDelete('cascade');
            $table->dropForeign(['user_id']);

//            Schema::enableForeignKeyConstraints();
//            Schema::disableForeignKeyConstraints();
        });

        // composer require doctrine/dbal

        Schema::table('demo', function (Blueprint $table) {
            $table->string('name1', 111)->nullable()->change();
            $table->renameColumn('name1', 'name1111');
            $table->dropColumn('name1111');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demo');
    }
}
