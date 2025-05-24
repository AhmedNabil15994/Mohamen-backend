<?php

namespace Modules\User\Http\Controllers\Dashboard;

use Illuminate\Routing\Controller;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Illuminate\Http\Request;
use Modules\User\Entities\User;

class UserController extends Controller
{
    use CrudDashboardController;

    public function store(Request $request)
    {
        try {
            $user = (new User)->create($request->all());

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

            if ($user) {
                return Response()->json([true, __('apps::dashboard.messages.created')]);
            }
            return Response()->json([false, __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $user =  User::findOrFail($id);
            $uid = ($user->uid)??$user->mobile.'_'.time();
            $user->update($request->all()+(['uid' => $uid]));
            $user->refresh();

            //get user from commet chat
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://'.config('services.cometchat.app_id').'.api-in.cometchat.io/v3/users/'.$user->uid,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'apikey: '.config('services.cometchat.apikey')
                    ),
                ));
                $response = json_decode(curl_exec($curl));
                curl_close($curl);
                if(isset($response->error)){
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
                        CURLOPT_POSTFIELDS => array('uid' => $user->uid,'name' => $user->name??'user-'.$user->id,'email' => $user->email??'','contactNumber' => $user->mobile??'','avatar'=> $user->getFirstMediaUrl('images') == ''? 'https://app.mohamen.net/' : $user->getFirstMediaUrl('images')),
                        CURLOPT_HTTPHEADER => array(
                        'apikey: '.config('services.cometchat.apikey')
                        ),
                    ));
                    $response = curl_exec($curl);
                }else{
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
                }

            if ($user) {
                return Response()->json([true, __('apps::dashboard.messages.updated')]);
            }

            return Response()->json([false, __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

}
