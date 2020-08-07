<?php

declare(strict_types=1);

namespace App\Common\Calendar\Date;

use App\Common\Calendar\Date;
use DateTimeImmutable;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateType as DBALDateType;

final class DateType extends DBALDateType
{
    private const NAME = 'custom_date';

    public function convertToPHPValue($value, AbstractPlatform $platform): Date
    {
        $value = parent::convertToPHPValue($value, $platform);

        return new Date(DateTimeImmutable::createFromMutable($value));
    }

    /** @param Date $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return (string) $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
