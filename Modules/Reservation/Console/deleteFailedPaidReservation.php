<?php

namespace Modules\Reservation\Console;

use Illuminate\Console\Command;
use Modules\Reservation\Entities\Reservation;

class deleteFailedPaidReservation extends Command {
  /**
   * The console command name.
   *
   * @var string
   */
  protected $signature = 'delete-failed-paid-reservation';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'this command for delete Failed Paid Reservation ';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct() {
    //
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle() {
    Reservation::where('paid', 'failed')->chunk(100, function ($reservations) {
      foreach ($reservations as $key => $reservation) {
        $reservation->delete();
      }
    });
  }
}
