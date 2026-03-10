<?php

namespace App\Traits;

use App\Models\AuditLog; // <-- CETTE LIGNE EST CRUCIALE

use Illuminate\Support\Facades\Auth;

trait Auditable {
    public static function bootAuditable() {
        static::created(function ($model) { $model->logEvent('created'); });
        static::updated(function ($model) { $model->logEvent('updated'); });
        static::deleted(function ($model) { $model->logEvent('deleted'); });
    }

    public function logEvent($event) {
        AuditLog::create([
            'user_id' => Auth::id(),
            'event' => $event,
            'auditable_type' => get_class($this),
            'auditable_id' => $this->id,
            'old_values' => $event === 'updated' ? json_encode($this->getOriginal()) : null,
            'new_values' => $event !== 'deleted' ? json_encode($this->getAttributes()) : null,
            'url' => request()->fullUrl(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
