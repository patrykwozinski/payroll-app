<?php

declare(strict_types=1);

namespace App\Common\CQRS;

use App\Common\CQRS\Exception\QueryException;
use Assert\Assertion;

final class QueryBus
{
    /** @var Query[] */
    private iterable $queries;

    public function __construct(iterable $queries)
    {
        Assertion::allIsInstanceOf((array) $queries, Query::class);

        $this->queries = $queries;
    }

    /** @throws QueryException */
    public function getQuery(string $query): Query
    {
        foreach ($this->queries as $availableQuery) {
            if ($availableQuery instanceof $query) {
                return $availableQuery;
            }
        }

        throw QueryException::whenNotFound($query);
    }
}
