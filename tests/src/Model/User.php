<?php declare(strict_types = 1);

namespace LibretteTests\Doctrine\Queries\Model;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 */
class User
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 * @var int
	 */
	private $id;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private $name;


	public function __construct(string $name)
	{
		$this->name = $name;
	}


	public function getId(): int
	{
		return $this->id;
	}


	public function getName(): string
	{
		return $this->name;
	}
}
