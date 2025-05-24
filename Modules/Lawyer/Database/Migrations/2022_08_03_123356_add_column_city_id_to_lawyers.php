<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Area\Entities\City;

class AddColumnCityIdToLawyers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lawyer_profile', function (Blueprint $table) {
            $table->foreignIdFor(City::class)->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lawyer_profile', function (Blueprint $table) {
            $table->dropConstrainedForeignId('city_id');
        });
    }
}
