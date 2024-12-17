<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('service_providers', function (Blueprint $table) {
            $table->string('address')->nullable()->after('location_lng');
            $table->string('business_permit_no')->nullable()->after('contact_info');
            $table->string('logo')->nullable()->after('business_permit_no');


        });
    }

    public function down()
    {
        Schema::table('service_providers', function (Blueprint $table) {
            if (Schema::hasColumn('service_providers', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('service_providers', 'business_permit_no')) {
                $table->dropColumn('business_permit_no');
            }
            if (Schema::hasColumn('service_providers', 'logo')) {
                $table->dropColumn('logo');
            }
        });
    }
};
