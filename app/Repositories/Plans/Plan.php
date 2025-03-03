<?php

namespace App\Repositories\Plans;

use App\Repositories\PricingFeatures\PricingFeature;
use App\Repositories\Settings\Setting;
use Illuminate\Database\Eloquent\Relations\HasMany;
use QuangND\Shopify\Repositories\Plans\Plan as Model;

class Plan extends Model
{
    use PresentationTrait;
    const MONTHLY_PLAN = 'Monthly';
    const YEARLY_PLAN = 'Yearly';
    const DEFAULT_PLAN = 'Starter';
    const BASIC_PLAN = 'basic';
    const FREE_PLAN = 'free';
    const BASIC_MONTHLY_PLAN_IDS = [11, 12, 13];
    const BASIC_YEARLY_PLAN_IDS = [8, 9, 10, 52];
    const PRODUCT_LIMITED_MAX = 'unlimited';
    const PRODUCT_LIMITED_MIN = '0';
    const CHARGE_TYPE_UPGRADE = 'upgradePlan';
    const CHARGE_TYPE_MORE_CAPI = 'upgradeMoreCapi';
    const CHARGE_TYPE_DOWN_CAPI = 'downgradeCapi';
    const CHARGE_TYPE_DOWN_ADVANCED = 'downgradeAdvanced';
    const TYPE_STANDARD = 'Standard';
    const TYPE_ENTERPRISE = 'Enterprise';

    const TYPE_FREE = 'FREE';

    const FREE_PLAN_ORDER_LIMIT = 5;

    const VERSION_LIMIT_PRODUCT = 1;
    const VERSION_ONETIME = 3;
    const VERSION_FREE = 4;
    const VERSION_SHOPIFY_PLAN = 2;
    const VERSION_SHOPIFY_PLAN_V2 = 5;

    const VERSION_ADVANCED_PLAN = 6;
    const INTERVAL_FREE ="FREE";

}
