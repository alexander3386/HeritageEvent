<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class ProductsTable extends Table
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
		$this->table('products');
		$this->displayField('title');
		$this->primaryKey('id');
		$this->addBehavior('Timestamp');
		$this->belongsTo('Events')->setForeignKey('event_id')->setDependent(true);
		
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
			'icon_image' => [    // The name of your upload field
				'root' => WWW_ROOT . 'uploads', // Customise the root upload folder here, or omit to use the default
				'dir' => 'icon_upload_dir',   // The name of the field to store the folder
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
		$validator = new Validator();
		$validator->notEmpty("title", 'This field is required');	
		$validator->notEmpty("description", 'This field is required');
		$validator->notEmpty("image", 'This field is required');	
		$validator->notEmpty("item_code", 'This field is required');	
		$validator->notEmpty("price", 'This field is required');	
		$validator->notEmpty("event_id", 'This field is required');	
		
		
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
				'message' => __('Image size must be less than 1MB.')
			],
			'uploadError' => [
				'rule' => 'uploadError',         
				'message' => __d('Message', 'Invalid File Type Or Size is greater then 1 MB.'),
				'last' => true,
				'allowEmpty' => true
			],
		]);
		$validator
		->allowEmpty('icon_image')
		->add('icon_image', [
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
				'message' => __('Image size must be less than 1MB.')
			],
			'uploadError' => [
				'rule' => 'uploadError',         
				'message' => __d('Message', 'Invalid File Type Or Size is greater then 1 MB.'),
				'last' => true,
				'allowEmpty' => true
			],
		]);
		return $validator;	
	}
	public function getProductArray(){
		$query = $this->find('list',['keyField' => 'id','valueField' => 'title']);
		if(!empty($query)){
			$data = $query->toArray();
			return $data;
		}
	}    
	
}
