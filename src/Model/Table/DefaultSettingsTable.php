<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DefaultSettings Model
 *
 * @method \App\Model\Entity\DefaultSetting get($primaryKey, $options = [])
 * @method \App\Model\Entity\DefaultSetting newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DefaultSetting[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DefaultSetting|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DefaultSetting patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DefaultSetting[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DefaultSetting findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DefaultSettingsTable extends Table
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

		$this->table('settings');
		$this->displayField('title');
		$this->primaryKey('id');
        
		$this->addBehavior('Timestamp');
		$this->addBehavior('Proffer.Proffer', [
		    'image' => [    // The name of your upload field
			'root' => WWW_ROOT . 'uploads', // Customise the root upload folder here, or omit to use the default
			'dir' => 'upload_dir',   // The name of the field to store the folder
			'thumbnailSizes' => [ // Declare your thumbnails
			    'square' => [   // Define the prefix of your thumbnail
				'w' => 117, // Width
				'h' => 62, // Height
				'crop' => false
			    ],
			],
			'thumbnailMethod' => 'gd'   // Options are Imagick or Gd
		    ],
		    'logo' => [    // The name of your upload field
			'root' => WWW_ROOT . 'uploads', // Customise the root upload folder here, or omit to use the default
			'dir' => 'logo_upload_dir',   // The name of the field to store the folder
			'thumbnailSizes' => [ // Declare your thumbnails
			    'square' => [   // Define the prefix of your thumbnail
				'w' => 117, // Width
				'h' => 62, // Height
				'crop' => false
			    ],
			],
			'thumbnailMethod' => 'gd'   // Options are Imagick or Gd
		    ]
		]);
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
		->email('email')
		->requirePresence('info_email', 'create')
		->notEmpty('info_email');
		
		 $validator
		->email('email')
		->requirePresence('order_email', 'create')
		->notEmpty('order_email');

		$validator
		->allowEmpty('logo')
		->add('logo', [
			'validExtension' => [
				'rule' => ['extension',['gif', 'jpeg', 'png', 'jpg' ]], 
				'message' => __('Invalid File Extension')
			],
			'mimeType' => [
				'rule' => ['mimeType', ['image/gif', 'image/png', 'image/jpg', 'image/jpeg']],
				'message' => __('Invalid File Type')
			],
			'fileSize' => [
				'rule' => array('fileSize', '<=', '1MB'),
				'message' => __('File size must be less than 1MB.')
			],
		]);
		$validator
		->allowEmpty('image')
		->add('image', [
			'validExtension' => [
				'rule' => ['extension',['gif', 'jpeg', 'png', 'jpg' ]], 
				'message' => __('Invalid File Extension')
			],
			'mimeType' => [
				'rule' => ['mimeType', ['image/gif', 'image/png', 'image/jpg', 'image/jpeg']],
				'message' => __('Invalid File Type')
			],
			'fileSize' => [
				'rule' => array('fileSize', '<=', '1MB'),
				'message' => __('File size must be less than 1MB.')
			],
		]);
		return $validator;
	}
	public function getDefaultSettings()
	{
		$settings 	= $this->find('all')->first();
//data 		= $settings->toArray();
		return $settings;
	}
}
