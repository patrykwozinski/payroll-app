<?php

declare(strict_types=1);

namespace App\Tests\Common\CQRS\Unit;

use App\Common\CQRS\Exception\QueryException;
use App\Common\CQRS\QueryBus;
use App\Tests\Common\CQRS\TestDouble\DummyQuery;
use PHPUnit\Framework\TestCase;

final class InMemoryQueryBusTest extends TestCase
{
    public function testQuerySuccessfullyFound(): void
    {
        // Given
        $queries = [new DummyQuery()];
        $queryBus = new QueryBus($queries);

        // When
        $query = $queryBus->getQuery(DummyQuery::class);

        // Then
        self::assertInstanceOf(DummyQuery::class, $query);
    }

    public function testQueryNotFoundWhenNoneRegistered(): void
    {
        // Given
        $queries = [];
        $queryBus = new QueryBus($queries);

        // Expect
        $this->expectException(QueryException::class);

        // When
        $queryBus->getQuery('my-query');
    }
}
