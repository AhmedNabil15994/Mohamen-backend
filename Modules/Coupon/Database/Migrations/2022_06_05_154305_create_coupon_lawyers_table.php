<?php

use Modules\Coupon\Entities\Coupon;
use Modules\Course\Entities\Course;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Lawyer\Entities\Lawyer;

class CreateCouponLawyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_lawyers', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Coupon::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Lawyer::class)->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_lawyers');
    }
}
