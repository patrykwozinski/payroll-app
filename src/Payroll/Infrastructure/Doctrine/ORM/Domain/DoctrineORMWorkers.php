<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\Doctrine\ORM\Domain;

use App\Common\Calendar\Date;
use App\Payroll\Domain\Worker;
use App\Payroll\Domain\Workers;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineORMWorkers implements Workers
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

    public function workingUntil(Date $date): array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('w')
            ->from(Worker::class, 'w')
            ->join('w.department', 'd')
            ->getQuery()
            ->getResult();
    }
}
