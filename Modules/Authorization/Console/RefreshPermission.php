<?php

namespace Modules\Authorization\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RefreshPermission extends Command {
  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'refresh:permission';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'refresh permissions by updating or create new one and assign it to super admin role ';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct() {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle() {
    Artisan::call('db:seed --class=\\\Modules\\\Authorization\\\Database\\\Seeders\\\RoleSeederTableSeeder');
    dd('done');
  }
}
