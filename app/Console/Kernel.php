<?php

namespace App\Console;

use App\Console\Commands\CreatePermission;
use App\Console\Commands\PushNotificationFiveMinutes;
use App\Console\Commands\PushNotificationHalfHour;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\Apps\Console\AppSetupCommand;
use Modules\Authorization\Console\RefreshPermission;
use Modules\Reservation\Console\SendReservationAlert;
use Modules\Reservation\Console\UpdateReservationStatus;

class Kernel extends ConsoleKernel {
  /**
   * The Artisan commands provided by your application.
   *
   * @var array
   */
  protected $commands = [
    AppSetupCommand::class,
    CreatePermission::class,
    RefreshPermission::class,
    UpdateReservationStatus::class,
    SendReservationAlert::class,
    // deleteFailedPaidReservation::class,
    PushNotificationFiveMinutes::class,
    PushNotificationHalfHour::class,
  ];

  /**
   * Define the application's command schedule.
   *
   * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
   * @return void
   */
  protected function schedule(Schedule $schedule) {
    $schedule->command('reservation:check-status')->everyFifteenMinutes();
    $schedule->command('send-reservation-alert')->Hourly();
    // $schedule->command('delete-failed-paid-reservation')->Hourly();
    $schedule->command('push:5')->everyMinute();
    $schedule->command('push:30')->everyMinute();
  }

  /**
   * Register the commands for the application.
   *
   * @return void
   */
  protected function commands() {
    $this->load(__DIR__ . '/Commands');

    require base_path('routes/console.php');
  }

  protected function bootstrappers() {
    return array_merge(
      [\Bugsnag\BugsnagLaravel\OomBootstrapper::class],
      parent::bootstrappers(),
    );
  }
}
