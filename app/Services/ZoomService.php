<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class ZoomService
{
    const ZOOM_OAUTH_ENDPOINT = "https://zoom.us/oauth/token";
    const ZOOM_SERVER_ENDPOINT = "https://api.zoom.us/v2/users/me/meetings";

    private $retry_attempts = 3;
    private $retry_max_time_out = 60;

    private $client_id, $account_id, $client_secret, $settings, $options, $recurrence;
    public $target_for = "meeting";

    public function __construct(
        public string $topic,
        public string $start_time,
        public string $duration,
        $agenda = null,
        public string $password = "123456",
    )
    {
        $this->agenda = $agenda;
        if( is_null($this->agenda) ){ $this->agenda = $this->topic. ' :: Meeting'; }
        
        $this->client_id = config('zoom-tocaan.client_id');
        $this->account_id = config('zoom-tocaan.account_id');
        $this->client_secret = config('zoom-tocaan.client_secret');
        $this->timezone = config('zoom-tocaan.timezone') ?? "KW";
    }

    protected function OnFlyToken($grant_type="account_credentials")
    {
        $query_string = 
        [
            'grant_type' => $grant_type,
            'account_id' => $this->account_id,
        ];

        $response = Http::retry($this->retry_attempts, $this->retry_max_time_out)
            ->withBasicAuth($this->client_id , $this->client_secret)
            ->post(self::ZOOM_OAUTH_ENDPOINT .'?'. http_build_query($query_string));
            
        if( $response->successful() )
        {
            $result = json_decode($response->body());

            if( isset($result->access_token) && !is_null($result->access_token) )
            {
                return $result->access_token;
            }
        }

        return null;
    }

    public function meeting(array $settings, $recurrence=null, $options=null)
    {
        $this->settings = $settings;
        $this->options = $options;
        $this->recurrence = $recurrence;
        $this->target_for = "meeting";

        return $this;
    }

    public function create()
    {
        $access_token = rescue( fn() =>  $this->OnFlyToken() );

        if( is_null($access_token) )
        {
            throw new \Exception('Failed to create Zoom access token!');
        }

        $basics = 
        [
            'start_time' => \Carbon\Carbon::parse($this->start_time)->toIso8601ZuluString(),
            'topic' => $this->topic,
            'agenda' => $this->agenda,
            'timezone' => $this->timezone,
            'password' => $this->password,
            'duration' => $this->duration
        ];

        if( is_array($this->options) )
        {
            $basics = array_merge($basics, $this->options);
        }

        $data = $basics;
        $data['recurrence'] = $this->recurrence;
        $data['settings'] = $this->settings;

        if( $this->target_for=="meeting" )
        {
            $response = Http::retry($this->retry_attempts, $this->retry_max_time_out)
            ->withToken($access_token)
            ->post(self::ZOOM_SERVER_ENDPOINT, $data);

            if( $response->successful() )
            {
                $result = json_decode($response->body());

                return $result;
            }
        }
        
        return null;
    }
}