<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Bookmarks Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsToMany $Tags
 *
 * @method \App\Model\Entity\Bookmark get($primaryKey, $options = [])
 * @method \App\Model\Entity\Bookmark newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Bookmark[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Bookmark|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Bookmark patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Bookmark[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Bookmark findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UploadsTable extends Table
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
		$this->table('uploads');
		$this->displayField('title');
		$this->primaryKey('id');
                $this->addBehavior('Timestamp');
        
		// Add the behaviour and configure any options you want
		$this->addBehavior('Proffer.Proffer', [
		    'file' => [    // The name of your upload field
			'root' => WWW_ROOT . 'uploads', // Customise the root upload folder here, or omit to use the default
			'dir' => 'upload_dir',   // The name of the field to store the folder
			'thumbnailSizes' => [ // Declare your thumbnails
			    'square' => [   // Define the prefix of your thumbnail
				'w' => 50, // Width
				'h' => 50, // Height
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
		    ->allowEmpty('title');
		$validator
		    ->allowEmpty('file')
		    ->add('file', [
				'uploadError' => [
					'rule' => 'uploadError',         
					'message' => __d('Message', 'Invalid File Type Or Size is greater then 1 MB.'),
					'last' => true,
					'allowEmpty' => true
				],
				'validExtension' => [
					'rule' => ['extension',['gif', 'jpeg', 'png', 'jpg']], 
					'message' => __('Invalid File Extension'),
				],
				'mimeType' => [
					'rule' => ['mimeType', ['image/gif', 'image/png', 'image/jpg', 'image/jpeg']],
					'message' => __('Invalid File Type'),
				],
				'fileSize' => [
				    'rule' => array('fileSize', '<', '1MB'),
				    'message' => __('File size must be less than 1MB.'),
				],
			]);
		return $validator;
	}
}
