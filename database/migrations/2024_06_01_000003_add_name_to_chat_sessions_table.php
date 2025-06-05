<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameToChatSessionsTable extends Migration
{
    public function up()
    {
        Schema::table('chat_sessions', function (Blueprint $table) {
            $table->string('name')->default('New chat created')->after('user_id');
        });
    }

    public function down()
    {
        Schema::table('chat_sessions', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
}
