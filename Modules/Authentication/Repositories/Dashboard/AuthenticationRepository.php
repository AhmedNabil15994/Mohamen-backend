<?php

namespace Modules\Authentication\Repositories\Dashboard;

use DB;
use Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\User\Entities\User;
use Modules\User\Entities\PasswordReset;

class AuthenticationRepository
{
    public function __construct(User $user, PasswordReset $password)
    {
        $this->password  = $password;
        $this->user      = $user;
    }

    public function register($request)
    {
        DB::beginTransaction();

        try {
            $user = $this->user->create([
                'name'      => $request['name'],
                'email'     => $request['email'],
                'mobile'    => $request['mobile'],
                'password'  => Hash::make($request['password']),
            ]);

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function findUserByEmail($request)
    {
        $user = $this->user->where('email', $request->email)->first();
        return $user;
    }

    public function createToken($request)
    {
        $user = $this->findUserByEmail($request);

        $this->deleteTokens($user);

        $newToken = strtolower(Str::random(64));

        $token =  $this->password->insert([
          'email'       => $user->email,
          'token'       => $newToken,
          'created_at'  => Carbon::now(),
        ]);

        $data = [
          'token' => $newToken,
          'user'  => $user
        ];

        return $data;
    }

    public function resetPassword($request)
    {
        $user = $this->findUserByEmail($request);

        $user->update([
          'password' => Hash::make($request->password)
        ]);

        $this->deleteTokens($user);

        return true;
    }

    public function deleteTokens($user)
    {
        $this->password->where('email', $user->email)->delete();
    }
}
