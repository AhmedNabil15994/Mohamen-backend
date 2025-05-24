<?php

namespace Modules\Authentication\Repositories\Api;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\PasswordReset;
use Modules\Core\Traits\Attachment\Attachment;
use Modules\User\Transformers\Api\UserResource;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Authentication\Foundation\Authentication;

class AuthenticationRepository extends ApiController
{
    use Authentication;

    private $user;
    private $password;

    public function __construct(User $user, PasswordReset $password)
    {
        $this->password  = $password;
        $this->user      = $user;
    }

    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = $this->user->create($request->all());

            $uid = $user->mobile.'_'.time();
            $user->update(['uid' => $uid]);

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://'.config('services.cometchat.app_id').'.api-in.cometchat.io/v3/users',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('uid' => $uid,'name' => $user->name??'user-'.$user->id,'email' => $user->email??'','contactNumber' => $user->mobile??'','avatar'=> $user->getFirstMediaUrl('images') == ''? 'https://app.mohamen.net/' : $user->getFirstMediaUrl('images')),
                CURLOPT_HTTPHEADER => array(
                   'apikey: '.config('services.cometchat.apikey')
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function completeRegister(User $model, $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();
            $image = Arr::pull($validated, 'image');
            $model->clearMediaCollection('images');
            $model->addMedia($image)->toMediaCollection('images');

            $model->save();
            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function login(Request $request)
    {
        try {
            $user = $this->findUserByEmailActive($request);

            if ($user && Hash::check($request->password, $user->password)) {
                return ['status' => 1, 'data' => $user];
            }

            $errors = ['status' => 0, 'data' => new MessageBag([
                'password' => __('authentication::api.login.validation.failed')
            ])];

            return $errors;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function UpdatePassword(Request $request)
    {
        try {
            $user = $request->user();

            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->password);
                $user->save();

                return true;
            }

            return false;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = $request->user();

            $user->update([
                'name' => $request->name ?? $user->name,
                'image' => $request->image ? Attachment::updateAttachment($request->image, $user->image, 'users') : $user->image,
                'mobile' => $request->mobile ?? $user->mobile,
            ]);

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://'.config('services.cometchat.app_id').'.api-in.cometchat.io/v3/users/'.$user->uid,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'PUT',
                CURLOPT_POSTFIELDS => array('uid' => $user->uid,'name' => $user->name??'user-'.$user->id,'email' => $user->email??'','contactNumber' => $user->mobile??'','avatar'=> $user->getFirstMediaUrl('images') == ''? 'https://app.mohamen.net/' : $user->getFirstMediaUrl('images')),
                CURLOPT_HTTPHEADER => array(
                   'apikey: '.config('services.cometchat.apikey')
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);

            return $user;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function findUserByMobile($request)
    {
        $user = $this->user->where('mobile', $request->mobile)->first();
        return $user;
    }


    public function getAuthUser($request = null)
    {
        return $request ? $request->user() : auth()->user();
    }

    public function findUserByMobileActive($request)
    {
        $user = $this->user->where('mobile', $request->mobile)->active()->first();
        return $user;
    }
    public function findUserByEmailActive($request)
    {
        $user = $this->user->where('email', $request->email)->active()->first();
        return $user;
    }

    public function profileInfo($request)
    {
        $user = $request->user();
        return [
            'user' => new UserResource($user),
        ];
    }

    public function tokenResponse(Request $request, $user = null)
    {
        $user = $user ? $user : $request->user();
        $user->refresh();
        $token = $this->generateToken($request, $user);

        return $this->response([
            'access_token' => $token->plainTextToken,
            'user' => new UserResource($user),
            'token_type' => 'Bearer',
        ]);
    }

    // public function createToken($request)
    // {
    //     $user = $this->findUserByMobile($request);

    //     if (!$user || $user->status == 0) {
    //         return false;
    //     }

    //     $this->deleteTokens($user);

    //     $newToken = strtolower(Str::random(64));

    //     $token =  $this->password->insert([
    //         'email'       => $user->mobile,
    //         'token'       => $newToken,
    //         'created_at'  => Carbon::now(),
    //     ]);

    //     $data = [
    //         'token' => $newToken,
    //         'user'  => $user
    //     ];

    //     return $data;
    // }

    public function findUserByEmail($request)
    {
        $user = $this->user->where('email', $request->email)->first();
        return $user;
    }

    public function createToken($request)
    {
        $user = $this->findUserByEmail($request);
        if (is_null($user)) {
            return false;
        }
        $this->deleteTokens($user);

        $newToken = strtolower(Str::random(64));

        $token = $this->password->insert([
            'email' => $user->email,
            'token' => $newToken,
            'created_at' => Carbon::now(),
        ]);

        $data = [
            'token' => $newToken,
            'user' => $user,
        ];

        return $data;
    }


    public function deleteTokens($user)
    {
        $this->password->where('email', $user->mobile)->delete();
    }
}
