<?php

namespace Modules\Reservation\Http\Requests\Dashboard;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Reservation\Rules\ReservationTimeExist;
use Modules\Reservation\Rules\ReservationTimeAfterNow;

class ReservationCalendarRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function validationData()
    {
        $data = parent::validationData();
        $times = collect([]);
        for ($date = Carbon::parse($data['start'])->copy(); $date->lt(Carbon::parse($data['end']));) {
            $newDate['from'] = $date->format('h:i A');
            $newDate['to'] = $date->addHour()->format('h:i A');
            $times->push($newDate);
        }

        $data['times'] = $times->toArray();

        return $data;
    }
    public function rules()
    {

        return [
            'user_id'            => 'required',
            'lawyer_id'       => 'required|exists:users,id',
            'date'            => 'required|date|after:yesterday',
            'times.*'         => ['required', new ReservationTimeExist()],
            'times.*.from'    => ['required', new ReservationTimeAfterNow()],
            'times.*.to'      => 'required',
            'service_id'      => 'required|exists:services,id',
            'payment_method'  => 'required|in:calendar',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }



    public function validated()
    {
        $data = $this->validator->validated();
        $time = Carbon::parse($data['times'][0]['from'])->format('h:i A');
        $data['first_time'] =  Carbon::parse(
            $data['date'] . ' ' . $time
        );

        return $data;
    }
}
