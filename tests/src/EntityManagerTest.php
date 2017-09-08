<?php declare(strict_types = 1);

namespace LibretteTests\Doctrine\Queries;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOSqlite\Driver;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;


trait EntityManagerTest
{
	protected function createMemoryManager(bool $createSchema = TRUE): EntityManager
	{
		$conf = [
			'driver' => 'pdo_sqlite',
			'memory' => TRUE,
		];

		$connection = new Connection($conf, new Driver());
		$config = new Configuration();
		$cache = new ArrayCache();
		$config->setMetadataCacheImpl($cache);
		$config->setQueryCacheImpl($cache);
		$config->setProxyDir(TEMP_DIR);
		$config->setProxyNamespace('TestProxy');
		$config->setMetadataDriverImpl($config->newDefaultAnnotationDriver([__DIR__], FALSE));
		$em = EntityManager::create($connection, $config);

		if ($createSchema) {
			$schemaTool = new SchemaTool($em);
			$meta = $em->getMetadataFactory()->getAllMetadata();
			$schemaTool->createSchema($meta);
		}

		return $em;
	}
}
