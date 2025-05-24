<?php

namespace Modules\Authentication\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Authentication\Http\Requests\Api\UpdateProfileRequest;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Authentication\Repositories\Api\AuthenticationRepository as Authentication;

class ProfileController extends ApiController
{
    private $auth;

    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $this->auth->updateProfile($request);

        if ($user) {
            return $this->response($this->auth->profileInfo($request));
        }

        return $this->error('', [], 400);
    }

    public function Profile(Request $request)
    {
        return $this->response($this->auth->profileInfo($request));
    }


}
