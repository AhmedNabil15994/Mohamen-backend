<?php

namespace Modules\Authentication\Foundation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Carbon\Carbon;
use Exception;

trait Authentication
{
    public static function authentication($credentials)
    {
        // LOGIN BY : Mobile & Password
        if (is_numeric($credentials->email)):

          $auth = Auth::guard('frontend')->attempt(
              [
                'mobile'     => $credentials->email,
                'password'   => $credentials->password
            ],
              $credentials->has('remember')
          );

        // LOGIN BY : Email & Password
        elseif (filter_var($credentials->email, FILTER_VALIDATE_EMAIL)):

          $auth = Auth::attempt(
              [
              'email'     => $credentials->email,
              'password'  => $credentials->password
            ],
              $credentials->has('remember')
          );

        endif;

        return $auth;
    }

    public function login($credentials)
    {
        try {
            if (self::authentication($credentials)) {
                return false;
            }

            $errors = new MessageBag([
            'password' => __('authentication::dashboard.login.validations.failed')
          ]);

            return $errors;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function loginAfterRegister($credentials)
    {
        try {
            self::authentication($credentials);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function generateToken(Request $request, $user)
    {
        $tokenResult = $user->createToken($request, 'token');
        return $tokenResult;
    }

    public function tokenExpiresAt($token)
    {
        return Carbon::parse($token->token->expires_at)->toDateTimeString();
    }
}
