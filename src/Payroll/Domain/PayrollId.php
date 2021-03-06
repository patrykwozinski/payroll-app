<?php

declare(strict_types=1);

namespace App\Payroll\Domain;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class PayrollId
{
    private UuidInterface $id;

    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    public static function random(): self
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $id): self
    {
        return new self(Uuid::fromString($id));
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id->toString();
    }
}
