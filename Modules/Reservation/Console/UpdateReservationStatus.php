<?php

namespace Modules\Reservation\Console;

use Illuminate\Console\Command;
use Modules\Reservation\Entities\Reservation;
use Modules\Reservation\Repositories\Api\ReservationRepository;

class UpdateReservationStatus extends Command {
  /**
   * The console command name.
   *
   * @var string
   */
  protected $signature = 'reservation:check-status {status?}';

  public $reservationRepository;
  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'this command for check if status pending to turn it into failed';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct(ReservationRepository $reservationRepository) {
    parent::__construct();
    $this->reservationRepository = $reservationRepository;
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle() {

    Reservation::where('paid', 'pending')->chunk(100, function ($reservations) {
      foreach ($reservations as $key => $reservation) {
        $status['paid'] = $this->argument('status') ? 'paid' : 'failed';
        if ('paid' == $status['paid']) {
          $this->reservationRepository
            ->createReservationPlayer(
              $reservation->id,
              $reservation->organizer_id
            );
        }
        $reservation->update($status);
      }
    });
  }
}
