<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Service\Entities\Service;
use Modules\User\Entities\User;

class CreateReservationsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('reservations', function (Blueprint $table) {
      $table->id();
      $table->date('date');
      $table->decimal('price');
      $table->enum('paid', ['pending', 'paid', 'failed'])->default('pending');
      $table->string('payment_method');
      $table->string('name')->nullable();
      $table->string('mobile')->nullable();
      $table->timestamp('first_time')->nullable();
      $table->dateTime('finish_time')->nullable();
      $table
        ->foreignIdFor(User::class)
        ->nullable()
        ->constrained()
        ->nullOnDelete();
      $table
        ->foreignIdFor(User::class, 'lawyer_id')
        ->nullable()
        ->constrained('users')
        ->nullOnDelete();
      $table
        ->foreignIdFor(Service::class)
        ->nullable()
        ->constrained()
        ->cascadeOnDelete()
        ->nullOnDelete();
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('reservations');
  }
}
