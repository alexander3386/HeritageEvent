<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;
class Coupon extends Entity
{
	protected $_accessible = [
		'*' => true,
		'id' => false,
	];
}
