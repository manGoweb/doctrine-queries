<?php declare(strict_types = 1);

namespace Librette\Doctrine\Queries;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Librette\Queries\IQueryable;
use Librette\Queries\IQueryHandler;
use Librette\Queries\IQueryHandlerAccessor;


class DoctrineQueryable implements IQueryable
{
	/** @var EntityManager */
	protected $entityManager;

	/** @var NULL|IQueryHandlerAccessor */
	private $queryHandlerAccessor;


	public function __construct(EntityManager $entityManager, ?IQueryHandlerAccessor $queryHandlerAccessor = NULL)
	{
		$this->entityManager = $entityManager;
		$this->queryHandlerAccessor = $queryHandlerAccessor;
	}


	public function createQueryBuilder(?string $entityClass = NULL, ?string $alias = NULL, ?string $indexBy = NULL): QueryBuilder
	{
		$qb = new QueryBuilder($this->entityManager);

		if ($entityClass !== NULL) {
			$qb->from($entityClass, $alias, $indexBy);
			$qb->select($alias);
		}

		return $qb;
	}


	public function createQuery(string $dql): Query
	{
		return $this->entityManager->createQuery($dql);
	}


	public function getHandler(): IQueryHandler
	{
		return $this->queryHandlerAccessor->get();
	}


	public function getEntityManager(): EntityManager
	{
		return $this->entityManager;
	}
}
