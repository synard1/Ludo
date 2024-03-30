<?php

// app/Traits/UserTrackingTrait.php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait UserTrackingTrait
{
    public static function bootUserTrackingTrait()
    {
        static::creating(function ($model) {
            $user = Auth::user();

            if ($user) {
                $model->user_cid = $user->cid;
                $model->user_id = $user->id;
                $model->created_by = $user->name;
                $model->created_by_level = $user->level_access;
            }
        });
    }
}
