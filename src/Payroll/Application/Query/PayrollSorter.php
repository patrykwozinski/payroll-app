<?php

declare(strict_types=1);

namespace App\Payroll\Application\Query;

use Assert\Assertion;

final class PayrollSorter
{
    private const ALLOWED_DIRECTIONS = ['ASC', 'DESC'];
    private const ALLOWED_FIELDS = [
        'id',
        'first_name',
        'last_name',
        'department_name',
        'department_bonus_type',
        'salary',
        'salary_bonus',
        'total_salary',
    ];

    private string $direction;
    private string $field;

    public function __construct(string $field, string $direction)
    {
        $field = strtolower($field);
        Assertion::inArray($field, self::ALLOWED_FIELDS, 'Sorting is possible using fields: ' . implode(', ', self::ALLOWED_FIELDS));

        $direction = strtoupper($direction);
        Assertion::inArray($direction, self::ALLOWED_DIRECTIONS, 'Sorting is possible using only DESC and ASC');

        $this->direction = $direction;
        $this->field = $field;
    }

    public static function default(): self
    {
        return new self('id', 'ASC');
    }

    public function isDefault(): bool
    {
        return $this->field === 'id';
    }

    public function direction(): string
    {
        return $this->direction;
    }

    public function field(): string
    {
        return $this->field;
    }
}
