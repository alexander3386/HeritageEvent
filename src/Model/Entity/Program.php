<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;
class Program extends Entity
{
	protected $_accessible = [
		'*' => true,
		'id' => false,
	];
}
