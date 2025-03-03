<?php

namespace App\Repositories\Plans;

trait PresentationTrait
{
    public static function listPlanName()
    {
        return [
            self::MONTHLY_PLAN => self::MONTHLY_PLAN,
            self::YEARLY_PLAN => self::YEARLY_PLAN,
        ];
    }

    public static function generateIntervalName()
    {
        return [
            self::INTERVAL_ANNUALLY => self::YEARLY_PLAN,
            self::INTERVAL_MONTHLY => self::MONTHLY_PLAN,
        ];
    }
}
