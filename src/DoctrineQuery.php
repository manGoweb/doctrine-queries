<?php declare(strict_types = 1);

namespace Librette\Doctrine\Queries;

use Librette\Queries\IQueryable;


abstract class DoctrineQuery implements IDoctrineQuery
{
	public function fetch(IQueryable $queryable)
	{
		if (!$queryable instanceof DoctrineQueryable) {
			throw new \LogicException(sprintf('$queryable must be an instance of %s', DoctrineQueryable::class));
		}

		return $this->doFetch($queryable);
	}


	abstract protected function doFetch(DoctrineQueryable $queryable);
}
