<?php declare(strict_types = 1);

namespace LibretteTests\Doctrine\Queries\Queries;

use Librette\Doctrine\Queries\DoctrineQuery;
use Librette\Doctrine\Queries\DoctrineQueryable;
use Librette\Queries\IQueryable;
use LibretteTests\Doctrine\Queries\Model\User;


/**
 * @method int fetch(IQueryable $queryable)
 */
class UserCountQuery extends DoctrineQuery
{
	protected function doFetch(DoctrineQueryable $queryable)
	{
		$qb = $queryable->createQueryBuilder(User::class, 'user');
		$qb->select('COUNT(user.id) AS countX');

		return (int) $qb->getQuery()->getSingleScalarResult();
	}
}
