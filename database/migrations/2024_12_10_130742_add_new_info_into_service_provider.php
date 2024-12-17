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
        Schema::table('service_providers', function (Blueprint $table) {
            $table->string('business_hours_monday')->nullable()->after('contact_info');
            $table->string('business_hours_tuesday')->nullable()->after('business_hours_monday');
            $table->string('business_hours_wednesday')->nullable()->after('business_hours_tuesday');
            $table->string('business_hours_thursday')->nullable()->after('business_hours_wednesday');
            $table->string('business_hours_friday')->nullable()->after('business_hours_thursday');
            $table->string('business_hours_saturday')->nullable()->after('business_hours_friday');
            $table->string('business_hours_sunday')->nullable()->after('business_hours_saturday');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_providers', function (Blueprint $table) {
            if (Schema::hasColumn('service_providers', 'business_hours_monday')) {
                $table->dropColumn('business_hours_monday');
            }
            if (Schema::hasColumn('service_providers', 'business_hours_tuesday')) {
                $table->dropColumn('business_hours_tuesday');
            }
            if (Schema::hasColumn('service_providers', 'business_hours_wednesday')) {
                $table->dropColumn('business_hours_wednesday');
            }
            if (Schema::hasColumn('service_providers', 'business_hours_thursday')) {
                $table->dropColumn('business_hours_thursday');
            }
            if (Schema::hasColumn('service_providers', 'business_hours_friday')) {
                $table->dropColumn('business_hours_friday');
            }
            if (Schema::hasColumn('service_providers', 'business_hours_saturday')) {
                $table->dropColumn('business_hours_saturday');
            }
            if (Schema::hasColumn('service_providers', 'business_hours_sunday')) {
                $table->dropColumn('business_hours_sunday');
            }
        });
    }
};
