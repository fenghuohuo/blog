<?php
/*
 * this file is part of Flarum.
 *
 * (c) Toby Zerner <toby.zerner@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {

        Schema::create('auth_tokens', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->string('payload', 150);
            $table->timestamp('created_at');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 100)->unique();
            $table->string('email', 150)->unique();
            $table->boolean('is_activated')->default(0);
            $table->string('password', 100);
            $table->text('bio')->nullable();
            $table->string('avatar_path', 100)->nullable();
            $table->binary('preferences')->nullable();
            $table->dateTime('join_time')->nullable();
            $table->dateTime('last_seen_time')->nullable();
            $table->dateTime('read_time')->nullable();
            $table->dateTime('notification_read_time')->nullable();
            $table->integer('discussions_count')->unsigned()->default(0);
            $table->integer('comments_count')->unsigned()->default(0);
        });

        Schema::create('users_groups', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->primary(['user_id', 'group_id']);
        });

        Schema::create('users_discussions', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('discussion_id')->unsigned();
            $table->dateTime('read_time')->nullable();
            $table->integer('read_number')->unsigned()->nullable();
            $table->primary(['user_id', 'discussion_id']);
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('discussion_id')->unsigned();
            $table->integer('number')->unsigned()->nullable();

            $table->dateTime('time');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('type', 100)->nullable();
            $table->text('content')->nullable();

            $table->dateTime('edit_time')->nullable();
            $table->integer('edit_user_id')->unsigned()->nullable();
            $table->dateTime('hide_time')->nullable();
            $table->integer('hide_user_id')->unsigned()->nullable();

            $table->unique(['discussion_id', 'number']);

            $table->engine = 'MyISAM';
        });

        Schema::create('password_tokens', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->integer('user_id')->unsigned();
            $table->timestamp('created_at');
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('sender_id')->unsigned()->nullable();
            $table->string('type', 100);
            $table->string('subject_type', 200)->nullable();
            $table->integer('subject_id')->unsigned()->nullable();
            $table->binary('data')->nullable();
            $table->dateTime('time');
            $table->boolean('is_read')->default(0);
            $table->boolean('is_deleted')->default(0);
        });

        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_singular', 100);
            $table->string('name_plural', 100);
            $table->string('color', 20)->nullable();
            $table->string('icon', 100)->nullable();
        });

        Schema::create('email_tokens', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->string('email', 150);
            $table->integer('user_id')->unsigned();
            $table->timestamp('created_at');
        });

        Schema::create('discussions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 200);
            $table->integer('comments_count')->unsigned()->default(0);
            $table->integer('participants_count')->unsigned()->default(0);
            $table->integer('number_index')->unsigned()->default(0);

            $table->dateTime('start_time');
            $table->integer('start_user_id')->unsigned()->nullable();
            $table->integer('start_post_id')->unsigned()->nullable();

            $table->dateTime('last_time')->nullable();
            $table->integer('last_user_id')->unsigned()->nullable();
            $table->integer('last_post_id')->unsigned()->nullable();
            $table->integer('last_post_number')->unsigned()->nullable();
        });

        Schema::create('config', function (Blueprint $table) {
            $table->string('key', 100)->primary();
            $table->binary('value')->nullable();
        });

        Schema::create('api_keys', function (Blueprint $table) {
            $table->string('id', 100)->primary();
        });
        Schema::create('access_tokens', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->integer('user_id')->unsigned();
            $table->timestamp('created_at');
            $table->timestamp('expires_at');
        });


    }
}


