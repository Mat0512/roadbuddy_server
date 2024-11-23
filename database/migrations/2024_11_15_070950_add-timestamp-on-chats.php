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
        if (Schema::hasTable('chats')) {
            Schema::table('chats', function (Blueprint $table) {
                // Add timestamps columns if they do not already exist
                if (!Schema::hasColumn('chats', 'created_at') && !Schema::hasColumn('chats', 'updated_at')) {
                    $table->timestamps();
                }
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
            Schema::table('chats', function (Blueprint $table) {
                // Drop timestamps columns if they exist
                if (Schema::hasColumn('chats', 'created_at') && Schema::hasColumn('chats', 'updated_at')) {
                    $table->dropColumn(['created_at', 'updated_at']);
                }
            });
        }
    }
};
