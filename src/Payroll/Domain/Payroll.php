<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use App\Common\Calendar\Date;

final class Payroll
{
    private PayrollId $id;
    private Date $generatedAt;
    /** @var PayrollRecord[] */
    private iterable $records = [];

    public function __construct(PayrollId $id, Date $generatedAt)
    {
        $this->id = $id;
        $this->generatedAt = $generatedAt;
    }

    public static function generate(PayrollId $id, Date $generatedAt): self
    {
        return new self($id, $generatedAt);
    }

    public function add(PayrollRecord $payrollRecord): void
    {
        $this->records[] = $payrollRecord;
    }

    public function isEmpty(): bool
    {
        return empty($this->records);
    }
}
