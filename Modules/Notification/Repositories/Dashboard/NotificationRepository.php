<?php

namespace Modules\Notification\Repositories\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\User\Entities\FirebaseToken;
use Modules\Notification\Entities\GeneralNotification;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class NotificationRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(GeneralNotification::class);
    }
    public function getAllFcmTokens()
    {
        // return [];
        return FirebaseToken::pluck('firebase_token')->toArray();
    }

    public function prepareData(array $data, Request $request, $is_create = true): array
    {
        $data['user_id']=auth()->id();
        return $data;
    }
}
