<?php

namespace Modules\Course\Service;

class CourseDateService
{
    public function handelCourseDates($model, $dates)
    {
        $key = count($dates) ? array_keys($dates)[0] : null;
        $firstTime=data_get($dates[$key], 'start_time');
        $firstDuration=data_get($dates[$key], 'duration');

        foreach ($dates as $key => $date) {
            $date['start_time']=$date['start_time']??$firstTime;
            $date['duration']=($date['duration']??$firstDuration);
            $date['day']=$key;
            $model->dates()->updateOrCreate(['day'=>$date['day']], $date);
        }
    }


    public function handelUnselectedDays($model, $deletedDays)
    {
        $model->dates()->whereIn('day', $deletedDays)->delete();
    }

    public function handelCourseIsLive($model, $request)
    {
        $this->handelCourseDates($model, $request['availability']);
        $this->handelUnselectedDays($model, $request['unselectedDays']);
    }
}
