<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\Doctrine\CustomType;

use App\Payroll\Domain\PayrollRecordId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ramsey\Uuid\Doctrine\UuidType;

final class PayrollRecordIdType extends UuidType
{
    public const NAME = 'payroll_record_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): PayrollRecordId
    {
        $value = parent::convertToPHPValue($value, $platform);

        return new PayrollRecordId($value);
    }

    /** @param PayrollRecordId $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return parent::convertToDatabaseValue($value->id(), $platform);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
