<?php

use Modules\User\Entities\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Order\Entities\OrderStatus;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->boolean('unread')->default(false);
            $table->boolean('is_holding')->default(false);

            $table->decimal('subtotal', 9, 3)->default(0.000);
            $table->decimal('discount', 9, 3)->default(0.000);
            $table->decimal('total', 9, 3)->default(0.000);
            $table->text('note')->nullable();

            $table->foreignIdFor(User::class)->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(OrderStatus::class)->constrained()
                ->cascadeOnDelete();

            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
