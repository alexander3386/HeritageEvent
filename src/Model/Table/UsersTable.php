<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Error\FatalErrorException;
use Cake\Event\Event;
use User\Model\Entity\User;

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
class UsersTable extends Table
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

        $this->table('users');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        //$this->belongsTo('Privilege')->setForeignKey('user_privileges')->setProperty('user_privileges');
        //$this->belongsTo('Roles')->setForeignKey('role_id')->setDependent(true)->setProperty('role_id');
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
            ->notEmpty('email')
            ;

        $validator
            ->requirePresence('password', 'create')
            ->allowEmpty('password', 'update')
            ->add('password', [
                'compare' => [
                    'rule' => function ($value, $context) {
                        $value2 = isset($context['data']['confirm_password']) ? $context['data']['confirm_password'] : false;
                        return (new DefaultPasswordHasher)->check($value2, $value) || $value == $value2;
                    },
                    'message' => __d('user', 'password and confirm password did not match'),
                ]
            ]);
        
       $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status')
            ;            
        return $validator;
    }

    public function getUserArray(){
        $query = $this->find('list',['keyField' => 'id','valueField' => 'first_name']);
        if(!empty($query)){
            $data = $query->toArray();
            return $data;
        }
    }
    
}