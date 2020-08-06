<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

final class BonusType
{
    private const TYPE_YEARLY = 'yearly';
    private const TYPE_PERCENTAGE = 'percentage';
    private string $type;
    private int $value;

    private function __construct(string $type, int $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    public static function yearly(int $value): self
    {
        return new self(self::TYPE_YEARLY, $value);
    }

    public static function percentage(int $value): self
    {
        return new self(self::TYPE_PERCENTAGE, $value);
    }
}
