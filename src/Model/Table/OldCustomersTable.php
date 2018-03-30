<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class OldCustomersTable extends Table
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
		$this->table('cart_head');
		$this->displayField('title');
		$this->primaryKey('id');
	}
    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
	public function validationDefault(Validator $validator)
	{
		  $validator
		    ->integer('id')
		    ->allowEmpty('id', 'create');

		// $validator
		    // ->requirePresence('date_from', 'create')
		    // ->notEmpty('date_from');
		
		// $validator
		    // ->requirePresence('date_to', 'create')
		    // ->notEmpty('date_to');
		
		// $validator
		    // ->requirePresence('extra_price', 'create')
		    // ->notEmpty('extra_price');
		
		// $validator
		    // ->requirePresence('extra_price_type', 'create')
		    // ->allowEmpty('extra_price_type');
		    

		return $validator;
	}
	
}
