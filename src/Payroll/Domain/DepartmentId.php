<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class DepartmentId
{
    private UuidInterface $id;

    private function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    public static function fromString(string $id): self
    {
        return new self(Uuid::fromString($id));
    }

    public function __toString(): string
    {
        return $this->id->toString();
    }
}