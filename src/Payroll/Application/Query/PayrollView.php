<?php

declare(strict_types=1);

namespace App\Payroll\Application\Query;

use App\Common\Calendar\Date;

final class PayrollView
{
    private string $id;
    private Date $generatedAt;

    public function __construct(string $id, Date $generatedAt)
    {
        $this->id = $id;
        $this->generatedAt = $generatedAt;
    }
}
