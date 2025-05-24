<?php

namespace Modules\Service\Repositories\Frontend;

use Modules\Service\Entities\Service;

class ServiceRepository
{
    public function __construct(Service $service)
    {
        $this->service   = $service;
    }

    public function getAllServices($order = 'id', $sort = 'desc')
    {
        $services = $this->service->active()->orderBy($order, $sort)->paginate(24);

        return $services;
    }

    public function getLimitedServices($order = 'id', $sort = 'desc')
    {
        $services = $this->service->active()->where('is_news', 0)->latest()->take(10)->get();

        return $services;
    }

    public function getAllMediaCenter($order = 'id', $sort = 'desc')
    {
        $services = $this->service->active()->where('is_news', 1)->orderBy($order, $sort)->paginate(24);

        return $services;
    }

    public function findBySlug($slug)
    {
        return $this->service->active()
            ->anyTranslation('slug', $slug)->firstOrFail();
    }
}
