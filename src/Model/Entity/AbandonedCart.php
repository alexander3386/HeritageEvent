<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;
class AbandonedCart extends Entity
{
	protected $_accessible = [
		'*' => true,
		'id' => false,
	];
}
