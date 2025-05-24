<?php

namespace Modules\Course\Repositories\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Core\Traits\RepositorySetterAndGetter;
use Modules\Course\Entities\ObtainCredential;
use Hash;
use DB;
use Modules\Course\Traits\VdocipherIntegration;

class CourseVideoApiRepository
{
    use RepositorySetterAndGetter;
    use VdocipherIntegration;

    private $credential;

    public function __construct()
    {
        $this->credential = new ObtainCredential();
    }

    public function createObtainCredentials()
    {
        try {
            $credential = $this->credential->where('status', 'created')->first();

            if (!$credential || $credential->video) :

                $response = $this->ObtainCredentials(Str::random(20) . '.mp4');
              
                if ($response->getData()->status) :
                    $credential = $this->credential->create([
                        'client_payload' => json_encode(
                            optional($response?->getData()?->data)->clientPayload
                        ),
                        'api_video_id' => $response->getData()->data->videoId,
                    ]);
                endif;
            endif;
            return $credential;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function uploadVideo($credential, $file)
    {
        try {
            return $this->upload($credential, $file);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function buildVideo($id)
    {
        $response = $this->getOtp($id)->getData()->data;

        if (!empty($response->otp)) {
            $otp = $response->otp;
            $playbackInfo = $response->playbackInfo;
        } else {
            $otp = '';
            $playbackInfo = '';
        }

        return view('course::layouts.render-video', compact('otp', 'playbackInfo'))->render();
    }





    public static function checkVideoStatus($id)
    {
        $response = self::getVideoStatus($id)->getData()->data;
        return isset($response->status) ? $response->status : null;
    }


    public function deleteVideo($id)
    {
        $this->delete($id)->getData()->data;
    }
}
