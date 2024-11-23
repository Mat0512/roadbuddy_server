<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('chats')) {
            Schema::create('chats', function (Blueprint $table) {
                $table->id();
                $table->integer('sender_id')->index();
                $table->integer('receiver_id')->index();
                $table->longtext('message');
                $table->foreign('sender_id')->references('user_id')->on('users')->onDelete('cascade');
                $table->foreign('receiver_id')->references('user_id')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('chats')) {
            // Get the foreign key constraint names from the information schema
            $foreignKeys = DB::select(DB::raw('SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME = "chats" AND TABLE_SCHEMA = "' . env('DB_DATABASE') . '" AND (COLUMN_NAME = "sender_id" OR COLUMN_NAME = "receiver_id")'));

            // Drop the foreign key constraints if they exist
            foreach ($foreignKeys as $key) {
                if ($key->CONSTRAINT_NAME) {
                    Schema::table('chats', function (Blueprint $table) use ($key) {
                        $table->dropForeign($key->CONSTRAINT_NAME);
                    });
                }
            }

            // Drop the chats table
            Schema::dropIfExists('chats');
        }
    }
};
