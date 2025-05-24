<?php

namespace App\Console\Commands;

use App\Console\PushNotificationBaseCommand;
use Modules\User\Entities\User;

class PushNotificationFiveMinutes extends PushNotificationBaseCommand {
  /* The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'push:5';

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
  public function __construct() {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle() {
    $users = User::whereNull('uid')->latest()->get();
    foreach ($users as $user) {
      if (!$user->uid) {
        $uid = $user->mobile . '_' . time();
        $user->update(['uid' => $uid]);
        $user->refresh();
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL            => 'https://' . config('services.cometchat.app_id') . '.api-in.cometchat.io/v3/users',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING       => '',
          CURLOPT_MAXREDIRS      => 10,
          CURLOPT_TIMEOUT        => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST  => 'POST',
          CURLOPT_POSTFIELDS     => array('uid' => $uid, 'name' => $user->name ?? 'user-' . $user->id, 'email' => $user->email ?? '', 'contactNumber' => $user->mobile ?? '', 'avatar' => $user->getFirstMediaUrl('images') == '' ? 'https://app.mohamen.net/' : $user->getFirstMediaUrl('images')),
          CURLOPT_HTTPHEADER     => array(
            'apikey: ' . config('services.cometchat.apikey'),
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
      }
    }

    return $this->pushNotifications(5);
  }
}
