<?php declare(strict_types = 1);

namespace Librette\Doctrine\Queries;

use Librette\Queries\IQueryable;


/**
 * @method NULL|object fetch(IQueryable $queryable)
 */
class DoctrineEntityQuery extends DoctrineQuery
{
	/** @var string */
	private $entityName;

	/** @var int */
	private $id;


	public function __construct(string $entityName, int $id)
	{
		$this->entityName = $entityName;
		$this->id = $id;
	}


	protected function doFetch(DoctrineQueryable $queryable)
	{
		return $queryable->getEntityManager()->find($this->entityName, $this->id);
	}
}
