<?php declare(strict_types = 1);

namespace Librette\Doctrine\Queries;

use Librette\Queries\IQuery;
use Librette\Queries\IQueryHandler;


class DoctrineQueryHandler implements IQueryHandler
{
	/** @var DoctrineQueryable */
	protected $queryable;


	public function __construct(DoctrineQueryable $queryable)
	{
		$this->queryable = $queryable;
	}


	public function supports(IQuery $query): bool
	{
		return $query instanceof IDoctrineQuery;
	}


	public function fetch(IQuery $query)
	{
		return $query->fetch($this->queryable);
	}
}
