<?php

declare(strict_types=1);

namespace App\Common\Application\Command;

use App\Common\Application\Command;

interface Bus
{
    public function dispatch(Command $command): void;
}
