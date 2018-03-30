<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class CouponsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
	public function initialize(array $config)
	{
		parent::initialize($config);
		$this->table('coupons');
		$this->displayField('title');
		$this->primaryKey('id');
		$this->addBehavior('Timestamp');
	}
    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
	public function validationDefault(Validator $validator)
	{
		$validator = new Validator();
		$validator->notEmpty("coupon_code", 'This field is required');	
		$validator->notEmpty("title", 'This field is required');	
		$validator->notEmpty("expire_date", 'This field is required');	
		$validator->notEmpty("discount_price", 'This field is required');	
		$validator->notEmpty("discount_type", 'This field is required');	
		return $validator;	
	}
	
	public function buildRules(RulesChecker $rules)
	{
		$rules->add($rules->isUnique(['coupon_code'],'Coupon code already in added. Please use different coupon code.'));
		return $rules;
	}
	
}
