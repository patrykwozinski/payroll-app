<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use App\Common\Date;
use App\Common\Domain\AggregateRoot;

final class Payroll extends AggregateRoot
{
    private PayrollId $id;
    private Date $generatedAt;
    /** @var PayrollRecord[] */
    private array $records = [];

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
}
