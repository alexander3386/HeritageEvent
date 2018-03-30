<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Network\Session;
class AbandonedCartsTable extends Table
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
		$this->table('abandoned_carts');
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
		  $validator
		    ->integer('id')
		    ->allowEmpty('id', 'create');
		return $validator;
	}
	
	/*
	 * save  AbandonedCartID to session
	 */
	public function saveAbandonedCartID($data) {
		$session = new Session();
		return $session->write('AbandonedCartID',$data);
	}
	/*
	 * read AbandonedCartID from session
	 */
	public function readAbandonedCartID() {
		$session = new Session();
		return $session->read('AbandonedCartID');
	}
	/*
	 * delete cAbandonedCartID from session
	 */
	public function removeAbandonedCartID() {
		$session = new Session();
		return $session->delete('AbandonedCartID');
	}
}
