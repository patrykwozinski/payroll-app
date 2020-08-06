<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use Webmozart\Assert\Assert;

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
        Assert::greaterThan($value, 0, 'Percentage must be greater than 0%');
        Assert::lessThan($value, 100, 'Percentage must be less than 100%');

        return new self(self::TYPE_PERCENTAGE, $value);
    }

    public function value(): int
    {
        return $this->value;
    }

    public function isYearly(): bool
    {
        return $this->type === self::TYPE_YEARLY;
    }

    public function isPercentage(): bool
    {
        return $this->type === self::TYPE_PERCENTAGE;
    }
}
