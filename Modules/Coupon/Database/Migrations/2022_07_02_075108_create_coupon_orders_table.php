<?php

use Modules\Order\Entities\Order;
use Modules\Coupon\Entities\Coupon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_orders', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('discount_type');
            $table->double('discount_percentage')->nullable();
            $table->double('discount_value')->nullable();
            $table
                ->foreignIdFor(Order::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table
                ->foreignIdFor(Coupon::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->cascadeOnUpdate();
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
        Schema::dropIfExists('coupon_orders');
    }
}
