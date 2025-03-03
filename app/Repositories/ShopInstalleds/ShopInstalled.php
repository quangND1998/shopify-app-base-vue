<?php

namespace App\Repositories\ShopInstalleds;

use QuangND\Shopify\Repositories\ShopInstalleds\ShopInstalled as Model;

class ShopInstalled extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shop',
        'date_installed',
        'app_id',
        'name_shop',
        'email_shop',
        'phone',
        'country',
        'date_uninstalled',
        'note',
        'timezone',
        'city',
        'zipcode',
        'sent_trigger_EMQ',
        'store_created_at',
        'last_installed_date',
        'is_review',
        'domain',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_installed' => 'datetime:Y-m-d H:i:s',
        'date_uninstalled' => 'datetime:Y-m-d H:i:s',
        'last_installed_date' => 'datetime:Y-m-d H:i:s',
    ];
}
