<?php

namespace Modules\Core\Traits;

trait ScopesTrait
{
    public function scopeVisible($query)
    {
        return $query->where('hidden', false);
    }

    public function scopeHidden($query)
    {
        return $query->where('hidden', true);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeUnActive($query)
    {
        return $query->where('status', false);
    }

    public function scopeIsTrusted($query)
    {
        return $query->where('is_trusted', true);
    }

    public function scopeOnlyDeleted($query)
    {
        return $query->onlyTrashed();
    }

    public function scopeWithDeleted($query)
    {
        return $query->withTrashed();
    }

    public function scopeUnexpired($query)
    {
        return $query->where('end_at', '>', date('Y-m-d'));
    }

    public function scopeExpired($query)
    {
        return $query->where('end_at', '<', date('Y-m-d'));
    }

    public function scopeStarted($query)
    {
        return $query->where('start_at', '<=', date('Y-m-d'));
    }

    public function scopeSuccessPayment($query)
    {
        return $query->where('success_status', 1);
    }

    public function scopeFailedOrderStatus($query)
    {
        return $query->where('failed_status', 1);
    }

    public function scopeDatatableDataRange($query)
    {
        $request = request()->all();
        return  $query
            ->when(data_get($request, 'req.from'), fn ($q, $val) => $q->whereDate('created_at', '>=', $val))
            ->when(data_get($request, 'req.to'), fn ($q, $val) => $q->whereDate('created_at', '<=', $val));
    }
}
