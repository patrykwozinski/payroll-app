<?php

declare(strict_types=1);

namespace App\Payroll\Application\Query;

use App\Common\Calendar\Date;

final class PayrollView
{
    private string $id;
    private Date $generatedAt;
    /** @var PayrollRecordView[] */
    private array $records;

    public function __construct(string $id, Date $generatedAt, array $records)
    {
        $this->id = $id;
        $this->generatedAt = $generatedAt;
        $this->records = $records;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function generatedAt(): Date
    {
        return $this->generatedAt;
    }

    /** @return PayrollRecordView[] */
    public function records(): array
    {
        return $this->records;
    }
}
