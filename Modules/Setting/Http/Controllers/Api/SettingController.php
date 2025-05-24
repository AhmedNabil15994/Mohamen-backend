<?php

namespace Modules\Setting\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\ZoomJWTService;
use Illuminate\Support\Facades\Cache;
use Modules\Apps\Http\Controllers\Api\ApiController;

class SettingController extends ApiController
{
    public function settings()
    {
        $settings =  config('api_setting');

        if( Cache::has('jwt_cached') )
        {
            $jwt = Cache::get('jwt_cached');
        }
        else {
            $jwt = ZoomJWTService::generate();
            Cache::remember('jwt_cached', (47 * 60 * 60) ,function () use($jwt) {
                return $jwt;
            });
        }

        //merge
        $settings = array_merge($settings, ['jwt' => $jwt]);
        
        return $this->response($settings);
    }

}
