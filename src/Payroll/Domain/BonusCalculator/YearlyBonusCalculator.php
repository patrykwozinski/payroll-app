<?php

declare(strict_types=1);

namespace App\Payroll\Domain\BonusCalculator;

use App\Common\Date;
use App\Common\Domain\Clock;
use App\Payroll\Domain\BonusCalculator;
use App\Payroll\Domain\BonusType;
use App\Payroll\Domain\Money;

final class YearlyBonusCalculator implements BonusCalculator
{
    private Clock $clock;

    public function __construct(Clock $clock)
    {
        $this->clock = $clock;
    }

    public function calculate(Money $currentSalary, BonusType $bonusType, Date $hiredAt): Money
    {
        $yearsInCompany = $this->clock->now()->diffInYears($hiredAt);
        $yearlyBonus = $bonusType->value();

        return new Money($yearsInCompany * $yearlyBonus);
    }

    public function supports(BonusType $bonusType): bool
    {
        return $bonusType->isYearly();
    }
}
