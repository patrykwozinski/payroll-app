<?php

declare(strict_types=1);

namespace App\Common\Domain;

use App\Common\Date;

interface Clock
{
    public function now(): Date;
}
