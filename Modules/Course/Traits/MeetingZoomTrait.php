<?php

namespace Modules\Course\Traits;

use MacsiDigital\Zoom\Facades\Zoom;

trait MeetingZoomTrait
{
    public function createMeeting($data)
    {
        $user = Zoom::user()->first();

        $meeting = Zoom::meeting()->make($data['meeting']);

        $meeting->recurrence()->make($data['recurrence']);

        $meeting->settings()->make($data['setting']);

        return  $user->meetings()->save($meeting);
    }
    public function updateMeeting($data, $id=null)
    {
        if (!$id) {
            return   $this->createMeeting($data);
        }

        $meeting=Zoom::meeting()->find($id);
        $meeting->update($data['meeting']);
        $meeting->recurrence()->update($data['recurrence']);
        $meeting->settings()->update($data['setting']);

        return  $meeting->save();
    }
}
