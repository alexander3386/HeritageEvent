<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class TicketGroupPricesTable extends Table
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
		$this->table('ticket_group_prices');
		$this->displayField('title');
		$this->primaryKey('id');
		//associations
		$this->belongsTo('Tickets');
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
		    // ->requirePresence('ticket_qty', 'create')
		    // ->notEmpty('ticket_qty');
		
		// $validator
		    // ->requirePresence('discount_price', 'create')
		    // ->notEmpty('discount_price');
		
		// $validator
		    // ->requirePresence('discount_type', 'create')
		    // ->notEmpty('discount_type');
		return $validator;
	}
	
}
