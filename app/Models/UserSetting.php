<?php

namespace App\Models;

use App\Repositories\Plans\Plan;
// use App\Repositories\Settings\Setting;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use QuangND\Shopify\Repositories\UserSettings\UserSetting as Model;

class UserSetting extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;

    const STATUS_ACTIVE = "active";
    const STATUS_TRIAL = "trial";

    // public function setting()
    // {
    //     return $this->hasOne(Setting::class, 'shop', 'store_name');
    // }

    public function currentPlan() {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }
}
