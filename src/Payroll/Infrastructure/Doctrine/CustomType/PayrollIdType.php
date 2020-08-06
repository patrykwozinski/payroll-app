<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\Doctrine\CustomType;

use App\Payroll\Domain\PayrollId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ramsey\Uuid\Doctrine\UuidType;

final class PayrollIdType extends UuidType
{
    public const NAME = 'payroll_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): PayrollId
    {
        $value = parent::convertToPHPValue($value, $platform);

        return new PayrollId($value);
    }

    /** @param PayrollId $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return parent::convertToDatabaseValue($value->id(), $platform);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
