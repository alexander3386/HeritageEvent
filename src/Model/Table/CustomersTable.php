<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Error\FatalErrorException;
use Cake\Event\Event;
use Customer\Model\Entity\Customer;
use Cake\Routing\Router;
use Cake\Mailer\Email;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Bookmarks
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CustomersTable extends Table
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

		$this->table('customers');
		$this->displayField('id');
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
        
		$validator
		->requirePresence('first_name', 'create')
		->notEmpty('first_name');
                        
		$validator
		->requirePresence('last_name', 'create')
		->notEmpty('last_name');                        

		$validator
		->email('email')
		->requirePresence('email', 'create')
		->notEmpty('email') ;

		$validator
		->requirePresence('password', 'create')
		->allowEmpty('password', 'update')
		->add('password', [
			'compare' => [
				'rule' => function ($value, $context) {
					$value2 = isset($context['data']['confirm_password']) ? $context['data']['confirm_password'] : false;
					return (new DefaultPasswordHasher)->check($value2, $value) || $value == $value2;
				},
			    'message' => __d('customer', 'password and confirm password did not match'),
			]
		]);
		return $validator;
	}
	    /**
	     * Returns a rules checker object that will be used for validating
	     * application integrity.
	     *
	     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
	     * @return \Cake\ORM\RulesChecker
	     */
	    public function buildRules(RulesChecker $rules)
	    {
			$rules->add($rules->isUnique(['email']),'Customer email already in used. Please use different email address.');
			return $rules;
	    }
    
	     /**
	     * If password is not sent means user is not changing it.
	     *
	     * @param \Cake\Event\Event $event The event that was triggered
	     * @param \User\Model\Entity\User $user User entity being saved
	     * @return void
	     */
	public function getByEmailId($customer)
	{
		$data	=	$this->find('all')->where(['Customers.email'=>$customer])->first();
		if($data){
			return $customer_id	=	$data['id'];
		}
		return 0;
	}
	
	public function sendRegistrationEmail($customer,$password) {
		$url 		= 	Router::Url(['controller' => 'customers', 'action' => 'login','prefix'=>'user'], true);
		$full_name	=	$customer['first_name'];
		$email = new Email();
		$email->template('registration');
		$email->emailFormat('both');
		$email->from(FROM_EMAIL);
		$email->to($customer['email'], $full_name);
		$email->subject('Thank your for your Registration!');
		$email->viewVars(['url' => $url,'full_name'=>$full_name, 'username' => $customer['email'],'password'=>$password]);
		$email->send();
	}
	
	
 }
