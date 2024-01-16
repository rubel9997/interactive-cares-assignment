<?php

namespace App\Constants;

class Status
{
    public const NOT_VACCINATED = 'not_vaccinated';

    public const SCHEDULED = 'scheduled';

    public const VACCINATED = 'vaccinated';

    public static function vaccineStatusList()
    {
        return [
            self::NOT_VACCINATED => 'not_vaccinated',
            self::SCHEDULED => 'scheduled',
            self::VACCINATED => 'vaccinated',
        ];
    }
}
