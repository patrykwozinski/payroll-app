<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\Doctrine\CustomType;

use App\Payroll\Domain\WorkerId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ramsey\Uuid\Doctrine\UuidBinaryType;

final class WorkerIdType extends UuidBinaryType
{
    public const NAME = 'worker_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): WorkerId
    {
        $value = parent::convertToPHPValue($value, $platform);

        return new WorkerId($value);
    }

    /** @param WorkerId $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return parent::convertToDatabaseValue($value->id(), $platform);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
