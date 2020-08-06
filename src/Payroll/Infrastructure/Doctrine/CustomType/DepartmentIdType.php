<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\Doctrine\CustomType;

use App\Payroll\Domain\DepartmentId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ramsey\Uuid\Doctrine\UuidBinaryType;

final class DepartmentIdType extends UuidBinaryType
{
    public const NAME = 'department_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): DepartmentId
    {
        $value = parent::convertToPHPValue($value, $platform);

        return new DepartmentId($value);
    }

    /** @param DepartmentId $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return parent::convertToDatabaseValue($value->id(), $platform);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
