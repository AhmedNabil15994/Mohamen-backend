<?php

namespace Modules\DeviceToken\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\HasApiTokens as SanctumHasApiTokens;

trait HasApiTokens
{
    use SanctumHasApiTokens;

    /**
     * @param $request
     * @param string $name
     * @param array $abilities
     * @return NewAccessToken
     */
    public function createToken(Request $request, $name, array $abilities = ['*'])
    {
        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => $abilities,
            'os' => $request['os'] ,
        ]);

        return new NewAccessToken($token, $token->getKey() . '|' . $plainTextToken);
    }

    /**
     * @param $request
     * @param string $name
     * @param array $abilities
     * @return NewAccessToken
     */
    public function updateOrCreateToken($request, $name, array $abilities = ['*'])
    {
        $token = $this->tokens()->where('name', $name)->first();

        if ($token) {
            $token->update([
                'token' => hash('sha256', $plainTextToken = Str::random(40)),
                'abilities' => $abilities,
            ]);
        } else {
            $token = $this->tokens()->create([
                'name' => $name,
                'token' => hash('sha256', $plainTextToken = Str::random(40)),
                'abilities' => $abilities,
            ]);
        }

        return new NewAccessToken($token, $token->getKey() . '|' . $plainTextToken);
    }

    public function getLastLoginAttribute()
    {
        $response['label'] = '<i class="fa fa-circle text-red" style="color: red"></i>';
        $response['time'] = __('devicetoken::dashboard.devices.message.not_defined');
        $last_device = $this->tokens()->whereNotNull('last_used_at')->orderBy('last_used_at')->first();
        return $last_device ? $last_device->last_used : (object)$response;
    }
}
