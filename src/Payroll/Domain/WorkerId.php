<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

final class WorkerId
{
    private string $id;

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function random(): self
    {
        return new self('id');
    }
}
