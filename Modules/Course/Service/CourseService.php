<?php

namespace Modules\Course\Service;

use Carbon\Carbon;
use Modules\Course\Entities\Course;
use Modules\Course\Traits\MeetingZoomTrait;

class CourseService
{
    use MeetingZoomTrait;

    public function handelCourseMeeting(Course $course)
    {
        $newMeeting = $this->handelDataForMeeting($course);
        $meeting = $this->createMeeting($newMeeting);

        $course->meeting()->create(['zoom_response' => $meeting->getAttributes()]);
    }
    public function updateCourseMeeting(Course $course)
    {
        $newMeeting = $this->handelDataForMeeting($course);
        $meeting = $this->updateMeeting($newMeeting, data_get($course, 'meeting->zoom_response->id', null));
        $course->meeting()->updateOrCreate(
            ['meetingable_id' => $course->id,
                'meetingable_type' => 'Modules\Course\Entities\Course'],
            [
                'zoom_response' => $meeting->getAttributes(),
            ]
        );
    }

    public function handelDataForMeeting($course)
    {
        $data = [];
        $data['meeting'] = [
            'topic' => $course->title,
            'start_time' => $this->zoomFormat($course->extra_attributes->get('start_date')),
            'duration' => $course->extra_attributes->get('duration'),
            'password' => "12345678",
        ];
        $data['recurrence'] = [
            'type' => 2,
            'end_date_time' => $this->zoomFormat($course->extra_attributes->get('end_date')),
            'weekly_days' => $course->extra_attributes->get('days'),
        ];
        $data['setting'] = [
            'join_before_host' => false,
            'host_video' => false,
            'participant_video' => false,
            'mute_upon_entry' => true,
            'waiting_room' => true,
            'approval_type' => config('zoom.approval_type'),
            'audio' => config('zoom.audio'),
            'auto_recording' => config('zoom.auto_recording'),
        ];

        return $data;
    }

    public function zoomFormat($time)
    {
        return Carbon::parse($time)->format('Y-m-d h:i:s A');
    }
}
