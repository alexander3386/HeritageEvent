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
 * Role Model
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
class RolesTable extends Table
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

        $this->table('roles');
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
            ->requirePresence('role_label', 'create')
            ->notEmpty('role_lable');
                        
        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status');                        

       $validator
            ->requirePresence('created_at', 'create')
            ->notEmpty('created_at');
        
                    
        return $validator;
    }

    public function getAllRole(){
        $query = $this->find('list',['keyField' => 'id','valueField' => 'role_label']);
        if(!empty($query)){
            $data = $query->toArray();
            return $data;
        }
    }
    
}
