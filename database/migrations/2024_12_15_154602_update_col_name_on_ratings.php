<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('service_provider_ratings', function (Blueprint $table) {
            if (Schema::hasColumn('service_provider_ratings', 'service_provider_id')) {
                DB::statement('ALTER TABLE service_provider_ratings CHANGE service_provider_id provider_id INT');
            }
        });
    }
                                                                   
    public function down()
    {   
        Schema::table('service_provider_ratings', function (Blueprint $table) {
            if (Schema::hasColumn('service_provider_ratings', 'service_provider_id')) {
                DB::statement('ALTER TABLE service_provider_ratings CHANGE provider_id service_provider_id INT');
            }
        });
    }
};