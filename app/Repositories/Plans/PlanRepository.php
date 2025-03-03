<?php

namespace App\Repositories\Plans;

use Carbon\Carbon;
use QuangND\Shopify\Helpers\Helper;
use QuangND\Shopify\Repositories\Plans\PlanRepository as Repository;

class PlanRepository extends Repository
{
    public function __construct(Plan $plan)
    {
        parent::__construct($plan);
    }

}
