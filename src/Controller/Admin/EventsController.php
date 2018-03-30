<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use App\View\Helper\CustomHelper;
/**
 * Tickets Controller
 *
 * @property \App\Model\Table\TicketsTable $tickets
 */
class EventsController extends AppController
{
	public $paginate = [
		'maxLimit' => 10,
	];
	
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize()
    {
		parent::initialize();
		$this->viewBuilder()->layout('admin');
		
    }
	/**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
	public function index()
	{
		$entity = $this->Events->newEntity();	
		$events = $this->Events->newEntity();
		$conditionsArr = [];
		$searchQuery = $this->Events->find();
		//search filter goes here
		if ($this->request->is(['get','put'])) {
			$this->request->data = $this->request->query;
			
			if(isset($this->request->data['status']) && $this->request->data['status']!='A'){
				$conditionsArr[] = ['Events.status' => $this->request->data['status']];
			}
			if(!empty($this->request->data['search_keyword'])){
				$search_keyword	=	$this->request->data['search_keyword'];
				$conditionsArr['Events.title LIKE '] = '%'.$search_keyword.'%';
			}
			
			$searchQuery = $searchQuery->where([
				$conditionsArr
			]);
			if(isset($this->request->query['download_csv']))
			{
				$download_csv = $this->export($searchQuery);
			}
			//final search query
			
		}
		$events = $this->paginate($searchQuery);
		$this->set(compact('events'));
		$this->set('form', $entity);
	}

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
	public function add()
	{
		$entity = $this->Events->newEntity($this->request->data, ['associated' => ['Uploads']]);
		if ($this->request->is('post')) {
			
			if(isset($this->request->data['date_time']) && !empty($this->request->data['date_time'])){
				$this->request->data['date_time']		=	$this->convertToDBFormat($this->request->data['date_time']);
			}
			if(isset($this->request->data['change_date_time']) && !empty($this->request->data['change_date_time'])){
				$this->request->data['change_date_time']		=	$this->convertToDBFormat($this->request->data['change_date_time']);
			}
			if(isset($this->request->data['uploads'])){
				$uploads	=	array();
				$counter	=	0;
				foreach($this->request->data['uploads'] as $upload){
					if(!empty($upload['file']['tmp_name'])){
						$uploads[$counter]['file']				=	$upload['file'];
						$uploads[$counter]['module_name']	=	'events';
						$counter++;
					}
				}
				unset($this->request->data['uploads']);
				$this->request->data['uploads']	=	$uploads;
			}
			
			$data = $this->Events->patchEntity($entity, $this->request->data, ['associated' => ['Uploads']]);
			if ($this->Events->save($data, ['associated' => ['Uploads']])) {	
				$this->Flash->success(__('Event has been saved successfully.'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('Unable to save data. Please fill all the required fields.'));
		}
		$this->set('form', $entity);
	}
	public function edit($id) {
		$event = $this->Events->get($id,['contain' => ['Uploads']]);
		//echo "<pre>";print_r($event);exit;
		if ($this->request->is(['patch', 'post', 'put'])) {	
			if(isset($this->request->data['date_time']) && !empty($this->request->data['date_time'])){
				$this->request->data['date_time']		=	$this->convertToDBFormat($this->request->data['date_time']);
			}
			if(isset($this->request->data['change_date_time']) && !empty($this->request->data['change_date_time'])){
				$this->request->data['change_date_time']		=	$this->convertToDBFormat($this->request->data['change_date_time']);
			}
			if(isset($this->request->data['uploads'])){
				$uploads	=	array();
				$counter	=	0;
				foreach($this->request->data['uploads'] as $upload){
					if(!empty($upload['file']['tmp_name'])){
						$uploads[$counter]['file']				=	$upload['file'];
						$uploads[$counter]['module_name']	=	'events';
						$counter++;
					}
				}
				unset($this->request->data['uploads']);
				$this->request->data['uploads']	=	$uploads;
			}
			//echo "<pre>";print_r($this->request->data);echo "</pre>";
			$data 	= 	$this->Events->patchEntity($event, $this->request->data, ['associated' => ['Uploads']]);
			if ($this->Events->save($data)) {
				$this->Flash->success(__('Event has been saved successfully.'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('Unable to save data. Please fill all the required fields.'));
		}
		$this->set(compact('event'));
		$this->set('_event', ['event']);
	}
	public function addNewField($row_count)
	{
		$this->viewBuilder()->autoLayout('');
		$this->set(compact('row_count'));
	}

	public function updatestatus() {
		$this->autoRender = false;	
		if($this->request->is('post')) {
			$query 	=	 $this->Events->query();
			$status 	= 	$this->request->data['val'];
			$id 		= 	$this->request->data['id'];
			$query->update()  
					->set(['status' => $status])
					->where(['id' => $id])
					->execute();
			$class="btn btn-danger btn-xs";
			$stType="Inactive";
			$stVal=1;
			if($status == 1)
			{
				$class="btn btn-success btn-xs";
				$stType="Active";
				$stVal=0;
			}
			echo '<a href="javascript:changeStatus(\'events\', '.$id.','.$stVal.');" class="'.$class.'"">'.$stType.'</a>';
			exit();
		}
	}
	    /**
	     * Delete method
	     *
	     * @param string|null $id Events id.
	     * @return \Cake\Network\Response|null Redirects to index.
	     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	     */
	public function delete($id = null)
	{
		$this->request->allowMethod(['get', 'delete']);
		$event = $this->Events->get($id,['contain' => ['Uploads']]);
		if ($this->Events->delete($event,['contain' => ['Uploads']])) {
			$this->Flash->success(__('The Event has been deleted.'));
		} else {
			$this->Flash->error(__('The Event could not be deleted. Please, try again.'));
		}
		return $this->redirect(['action' => 'index']);
	}    
	public function removeImage($id = null){
		$this->autoRender = false;	
		if(!$id){
			$id 		= 	$this->request->data['id'];
		}
		$this->loadModel('Uploads');
		$upload = $this->Uploads->get($id);
		if ($this->Uploads->delete($upload)) {} 
		return true;
	}

	private function export($query)
	{
		$this->Custom			=	 new CustomHelper(new \Cake\View\View());
		$dataArr = $query->toArray();
		$data = [];
		$_serialize 	='data';
		$_header 		= ['Event Name','Description','Venue','Bracode Prefix','Date Time','Change Date Time','Status'];
		$this->Custom 	=	 new CustomHelper(new \Cake\View\View());
		
		array_push($data, $_header);	
		foreach($dataArr as $items)
		{
			$d_arr[0] 	= ($items['title']!='')?$items['title']:'-';
			$d_arr[1] 	= ($items['description']!='')?$items['description']:'-';
			$d_arr[2] 	= ($items['venue']!='')?$items['venue']:'-';
			$d_arr[3] 	= ($items['barcode_prefix']!='')?$items['barcode_prefix']:'-';
			
			$d_arr[4] 	= ($items['date_time']!='')?$this->Custom->displayDateFormat($items['date_time']):'-';
			$d_arr[5] 	= ($items['change_date_time']!='')?$this->Custom->displayDateFormat($items['change_date_time']):'-';
			$d_arr[6] 	= ($items['status']!=0)?'Active':'Inactive';
			array_push($data, $d_arr);
		}
		//pr($data);die;

		$filename = "HRE_Events_".time().'.csv';
		$this->set(compact('data', '_serialize'));
		$this->response->download($filename);
		$this->viewBuilder()->className('CsvView.Csv');
	}
}
