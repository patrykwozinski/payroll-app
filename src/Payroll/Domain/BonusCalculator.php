<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use App\Common\Date;

interface BonusCalculator
{
    public function calculate(Money $currentSalary, BonusType $bonusType, Date $hiredAt): Money;

    public function supports(BonusType $bonusType): bool;
}
