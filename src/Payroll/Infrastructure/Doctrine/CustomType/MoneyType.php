<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\Doctrine\CustomType;

use App\Payroll\Domain\Money;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\FloatType;

final class MoneyType extends FloatType
{
    private const NAME = 'money';

    public function convertToPHPValue($value, AbstractPlatform $platform): Money
    {
        $value = parent::convertToPHPValue($value, $platform);

        return new Money($value);
    }

    /** @param Money $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): float
    {
        return $value->value();
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
