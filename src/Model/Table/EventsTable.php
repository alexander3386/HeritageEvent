<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class EventsTable extends Table
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
		$this->table('events');
		$this->displayField('title');
		$this->primaryKey('id');
		//associated with tickets upload model
		$this->hasMany('Tickets', [
			'foreignKey' => 'event_id',
			'dependent' => false,
		]);
		//associated with products model
		$this->hasMany('Products', [
			'foreignKey' => 'event_id',
			'dependent' => false,
		]);
		//associated with programs model
		$this->hasMany('Programs', [
			'foreignKey' => 'event_id',
			'dependent' => false,
		]);
		//associated with tickets upload model
		$this->hasMany('Uploads', [
			'foreignKey' => 'module_id',
			'dependent' => true,
			'Uploads.module_name' => 'events'
		]);
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
		$validator->notEmpty("venue", 'This field is required');	
		$validator->notEmpty("image", 'This field is required');	
		$validator->notEmpty("date_time", 'This field is required');	
		//$validator->notEmpty("date_time", 'This field is required');	
		
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
		return $validator;	
	}
	public function getEventArray(){
		$query = $this->find('list',['keyField' => 'id','valueField' => 'title']);
		if(!empty($query)){
			$data = $query->toArray();
			return $data;
		}
	}    
	public function getUpcomingEventID(){
		$data	=	$this->find('all', array('limit'=>1,'order'=>array('Events.date_time asc')))->where( ['Events.date_time >=' => date("c"),'Events.status'=>1] )->first();
		if($data){
			return $event_id	=	$data['id'];
		}
		return 0;
	}
	public function getUpcomingEvent()
	{
		$id		=	$this->getUpcomingEventID();
		$event = $this->find('all')->where( ['Events.id' =>$id] )->first();
		return $event;
	}
	
}
