<?php

declare(strict_types=1);

namespace App\Common\Calendar;

interface Clock
{
    public function now(): Date;
}
