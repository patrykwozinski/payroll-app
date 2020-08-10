<?php

declare(strict_types=1);

namespace App\Payroll\Application\Query;

use Assert\Assertion;

final class PayrollFilter
{
    private const ALLOWED_FILTER_FIELDS = [
        'first_name',
        'last_name',
        'department_name',
    ];

    private ?PayrollSorter $sorter;
    private ?string $field = null;
    private ?string $value = null;

    public static function create(): self
    {
        return new self();
    }

    public function withDefinition(string $field, string $value): self
    {
        $field = \strtolower($field);

        Assertion::inArray(
            $field,
            self::ALLOWED_FILTER_FIELDS,
            'Allowed filtering fields: ' . \implode(', ', self::ALLOWED_FILTER_FIELDS)
        );
        Assertion::notEmpty($value, 'Filtering value can not be empty');

        $this->field = $field;
        $this->value = $value;

        return $this;
    }

    public function withSorter(PayrollSorter $sorter): self
    {
        $this->sorter = $sorter;

        return $this;
    }

    public function hasSorter(): bool
    {
        return false === $this->sorter->isDefault();
    }

    public function sorter(): PayrollSorter
    {
        return $this->sorter;
    }

    public function isDefined(): bool
    {
        return null !== $this->field && null !== $this->value;
    }

    public function field(): string
    {
        return $this->field;
    }

    public function value(): string
    {
        return $this->value;
    }
}
