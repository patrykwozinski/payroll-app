<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\Doctrine\Persistence;

use App\Payroll\Domain\Worker;
use App\Payroll\Domain\Workers;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineWorkers implements Workers
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(Worker $worker): void
    {
        $this->entityManager->persist($worker);
        $this->entityManager->flush();
    }

    public function all(): array
    {
        return [];
    }
}
