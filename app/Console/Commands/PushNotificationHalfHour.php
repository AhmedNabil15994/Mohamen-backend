<?php

namespace App\Console\Commands;

use App\Console\PushNotificationBaseCommand;

class PushNotificationHalfHour extends PushNotificationBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:30';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder to the client before meeting staring';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return $this->pushNotifications(30);
    }
}
