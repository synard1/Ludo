<?php

// app/Traits/UserTrackingTrait.php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait UserTracking
{
    public static function bootUserTracking()
    {
        static::creating(function ($model) {
            $user = Auth::user();

            if ($user) {
                $model->user_cid = $user->cid;
                $model->created_by = $user->id;
            }
        });
    }
}
