<?php declare(strict_types = 1);

namespace LibretteTests\Doctrine\Queries;

use Librette\Doctrine\Queries\DoctrineQueryable;
use Librette\Doctrine\Queries\DoctrineQueryHandler;
use Librette\Queries\Internal\InternalQueryable;
use Librette\Queries\IQueryHandler;
use Librette\Queries\IQueryHandlerAccessor;
use Librette\Queries\MainQueryHandler;
use LibretteTests\Doctrine\Queries\Model\User;
use LibretteTests\Doctrine\Queries\Queries\UserCountQuery;
use Tester;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


/**
 * @testCase
 */
class BaseQueryObjectTestCase extends Tester\TestCase
{
	use EntityManagerTest;


	public function tearDown()
	{
		\Mockery::close();
	}


	public function testBasic()
	{
		$em = $this->createMemoryManager();
		$queryHandler = new MainQueryHandler();
		$accessor = \Mockery::mock(IQueryHandlerAccessor::class)->shouldReceive('get')->andReturn($queryHandler)->getMock();
		$queryHandler->addHandler(new DoctrineQueryHandler(new DoctrineQueryable($em, $accessor)));
		$em->persist(new User('John'));
		$em->persist(new User('Jack'));
		$em->flush();
		Assert::same(2, $queryHandler->fetch(new UserCountQuery()));
	}


	public function testInvalidQueryable()
	{
		Assert::throws(
			function () {
				(new UserCountQuery())->fetch(new InternalQueryable(\Mockery::mock(IQueryHandler::class)));
			},
			\LogicException::class
		);
	}
}


(new BaseQueryObjectTestCase())->run();
