<?php

declare(strict_types=1);

namespace App\Payroll\Domain\BonusCalculator;

use App\Common\Calendar\Date;
use App\Payroll\Domain\BonusCalculator;
use App\Payroll\Domain\BonusType;
use App\Payroll\Domain\Money;

final class PercentageBonusCalculator implements BonusCalculator
{
    public function calculate(Money $currentSalary, BonusType $bonusType, Date $hiredAt): Money
    {
        return $currentSalary->percent($bonusType->value());
    }

    public function supports(BonusType $bonusType): bool
    {
        return $bonusType->isPercentage();
    }
}
