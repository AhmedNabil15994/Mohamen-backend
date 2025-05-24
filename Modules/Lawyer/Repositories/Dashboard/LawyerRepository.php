<?php

namespace Modules\Lawyer\Repositories\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Lawyer\Entities\Lawyer;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class LawyerRepository extends CrudRepository
{

    public function __construct()
    {
        parent::__construct(Lawyer::class);
    }

    public function modelCreateOrUpdate($model, $request, $is_created = true): void
    {

        if ($request['roles'] != null) {
            $this->saveRoles($model, $request);
        }
        $model->categories()->sync($request->categories);
        // $model->services()->sync($request->services);

        $model->services()->detach( collect($request->services)->pluck('service_id') );

        foreach($request->services as $service)
        {
            $model->services()->attach($service['service_id'],
            [
                'price' => $service['price'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->createOrUpdateProfile($model, $request);
        $this->createOrUpdateVacation($model, $request);

        $this->updateAvailability($model, $request->availability);

        if(!$model->uid){
            $uid = $model->mobile.'_'.time();
            $model->update(['uid' => $uid]);
            $model->refresh();
        }
        //get user from commet chat
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://'.config('services.cometchat.app_id').'.api-in.cometchat.io/v3/users/'.$model->uid,
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
                CURLOPT_POSTFIELDS => array('uid' => $model->uid,'name' => $model->name??'user-'.$model->id,'email' => $model->email??'','contactNumber' => $model->mobile??'','avatar'=> $model->getFirstMediaUrl('images') == ''? 'https://app.mohamen.net/' : $model->getFirstMediaUrl('images')),
                CURLOPT_HTTPHEADER => array(
                   'apikey: '.config('services.cometchat.apikey')
                ),
            ));
            $response = curl_exec($curl);
        }

    }


    public function updateAvailability($model, $availability)
    {
        $model->availabilities()?->delete();
        collect($availability)->each(function ($el, $key) use ($model) {
            $model->availabilities()->create([
                'day_code' => $key,
                'status' => 1,
                'is_full_day' => $el['is_full_day'],
                'custom_times' => $el['is_full_day'] ? [] : [...$el['times'] ?? []]
            ]);
        });
    }

    public function saveRoles($model, $request)
    {
        $model->syncRoles($request['roles']);
        return true;
    }

    public function createOrUpdateProfile($model, $request)
    {
        $profile = $model->profile()->updateOrCreate(
            [
                'lawyer_id' => $model['id'],
            ],
            [
                'status' => true,
                'job_title' => $request['job_title'],
                'about' => $request['about'],
                'country' => $request['country'],
                'city_id' => $request['city_id'],
            ]
        );

        $profile->save();

        return $profile;
    }
    public function createOrUpdateVacation($model, $request)
    {
        $arrayOfRanges = collect([...data_get($request, 'vacation.date_range', [])])->filter()->values()->toArray();
        $transformed = $this->transform($arrayOfRanges);;
        $data = [
            "weekly_vacations" => array_diff(array_keys(
                __('availability::dashboard.availabilities.form.days')
            ), $request['days_status']??[]),
            "date_ranges" => $transformed,
        ];
        $model->vacation ? $model->vacation()->update($data) : $model->vacation()->create($data);
    }

    public function transform($arrayOfRanges)
    {
        $ranges = collect([]);
        foreach ($arrayOfRanges as $key => $value) {
            $dates = explode(' - ', trim($value));
            $ranges->push([
                'date_from' => $dates[0] ?? null,
                'date_to' => $dates[1] ?? null,
            ]);
        }
        return     $ranges;
    }
}
