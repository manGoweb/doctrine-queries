<?php declare(strict_types = 1);

namespace LibretteTests\Doctrine\Queries;

use Librette\Doctrine\Queries\DoctrineQuery;
use Librette\Doctrine\Queries\DoctrineQueryable;
use Librette\Doctrine\Queries\DoctrineQueryHandler;
use Librette\Doctrine\Queries\IDoctrineQuery;
use Librette\Queries\CountQuery;
use Librette\Queries\IQuery;
use Tester;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


/**
 * @testCase
 */
class QueryHandlerTestCase extends Tester\TestCase
{
	public function setUp()
	{
	}


	public function tearDown()
	{
		\Mockery::close();
	}


	public function testSupports()
	{
		$queryHandler = new DoctrineQueryHandler(\Mockery::mock(DoctrineQueryable::class));
		Assert::true($queryHandler->supports(\Mockery::mock(DoctrineQuery::class)));
		Assert::true($queryHandler->supports(\Mockery::mock(IDoctrineQuery::class)));
		Assert::false($queryHandler->supports(\Mockery::mock(IQuery::class)));
		Assert::false($queryHandler->supports(\Mockery::mock(CountQuery::class)));
	}


	public function testFetch()
	{
		$queryable = \Mockery::mock(DoctrineQueryable::class);

		$query = \Mockery::mock(IDoctrineQuery::class);
		$query->shouldReceive('fetch')->once()->with($queryable);

		Assert::noError(function () use ($queryable, $query) {
			$queryHandler = new DoctrineQueryHandler($queryable);
			$queryHandler->fetch($query);
		});
	}
}


(new QueryHandlerTestCase())->run();
