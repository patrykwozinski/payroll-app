<?php

declare(strict_types=1);

namespace App\Payroll\Application\Query;

final class PayrollFilter
{
    private ?PayrollSorter $sorter;

    public static function create(): self
    {
        return new self;
    }

    public function withSorter(PayrollSorter $sorter): self
    {
        $this->sorter = $sorter;

        return $this;
    }

    public function hasSorter(): bool
    {
        return false === $this->sorter->isDefault();
    }

    public function sorter(): PayrollSorter
    {
        return $this->sorter;
    }
}
