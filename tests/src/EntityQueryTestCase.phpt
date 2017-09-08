<?php declare(strict_types = 1);

namespace LibretteTests\Doctrine\Queries;

use Doctrine\DBAL\Logging\DebugStack;
use Librette\Doctrine\Queries\DoctrineEntityQuery;
use Librette\Doctrine\Queries\DoctrineQueryable;
use Librette\Doctrine\Queries\DoctrineQueryHandler;
use Librette\Queries\IQueryHandlerAccessor;
use LibretteTests\Doctrine\Queries\Model\User;
use Tester;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


/**
 * @testCase
 */
class EntityQueryTestCase extends Tester\TestCase
{
	use EntityManagerTest;


	public function testAfterInsert()
	{
		$em = $this->createMemoryManager();
		$queryHandler = new DoctrineQueryHandler(new DoctrineQueryable($em, \Mockery::mock(IQueryHandlerAccessor::class)));
		$em->persist($user = new User('John'));
		$em->flush();
		$em->getConnection()->getConfiguration()->setSQLLogger($logger = new DebugStack());
		Assert::same(0, $logger->currentQuery);
		$query = new DoctrineEntityQuery(User::class, $user->getId());
		Assert::same($user, $queryHandler->fetch($query));
		Assert::same(0, $logger->currentQuery);
	}


	public function testRepeatedSelect()
	{
		$em = $this->createMemoryManager();
		$queryHandler = new DoctrineQueryHandler(new DoctrineQueryable($em, \Mockery::mock(IQueryHandlerAccessor::class)));
		$em->persist($user = new User('John'));
		$em->flush();
		$em->clear();

		$em->getConnection()->getConfiguration()->setSQLLogger($logger = new DebugStack());
		Assert::same(0, $logger->currentQuery);
		$query = new DoctrineEntityQuery(User::class, $user->getId());
		Assert::same($user->getId(), $user2 = $queryHandler->fetch($query)->getId());
		Assert::same(1, $logger->currentQuery);

		$query = new DoctrineEntityQuery(User::class, $user->getId());
		Assert::same($user2, $queryHandler->fetch($query)->getId());
		Assert::same(1, $logger->currentQuery);
	}
}


(new EntityQueryTestCase())->run();
