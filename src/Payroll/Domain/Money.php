<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use Webmozart\Assert\Assert;

final class Money
{
    private float $money;

    // I don't want to work on `FLOAT` for money but at this time it's ok. In the future I'd like to replace it with money-lib
    public function __construct(float $money)
    {
        Assert::greaterThanEq($money, 'Salary can not be less than zero');

        $this->money = $money;
    }

    public static function zero(): self
    {
        return new self(0);
    }

    public function add(Money $calculated): self
    {
        return new self($this->money + $calculated->money);
    }

    public function equals(Money $money): bool
    {
        return $this->money === $money->money;
    }

    public function percent(int $amount): self
    {
        $percent = $amount * 0.01;

        return new self($percent * $this->money);
    }
}
