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
class ProgramsController extends AppController
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
		$entity = $this->Programs->newEntity();
		$programs = $this->Programs->newEntity();
		$conditionsArr = [];
		$searchQuery = $this->Programs->find('all', ['contain' => ['Events']]);
		//search filter goes here
		if ($this->request->is(['get','put'])) {
			$this->request->data = $this->request->query;
			if(isset($this->request->data['status']) && $this->request->data['status']!='A'){
				$conditionsArr[] = ['Programs.status' => $this->request->data['status']];
			}
			if(!empty($this->request->data['event'])){
				$conditionsArr[] = ['event_id' => $this->request->data['event']];
			}
			if(!empty($this->request->data['search_keyword'])){
				$search_keyword	=	$this->request->data['search_keyword'];
				$conditionsArr['Programs.title LIKE '] = '%'.$search_keyword.'%';
			}
			//final search query
			$searchQuery = $searchQuery->where([
				$conditionsArr
			]);
			if(isset($this->request->query['download_csv']))
			{
				$download_csv = $this->export($searchQuery);
			}
		}
		$programs = $this->paginate($searchQuery);
		$event		 	= 	TableRegistry::get('Events');
		$event_arr 	 	 = 	$event->getEventArray();
		$this->set(compact('programs','event_arr'));
		$this->set('form', $entity);
		
	}
	public function add()
	{
		$entity = $this->Programs->newEntity($this->request->data);
		if ($this->request->is('post')) {
			$data = $this->Programs->patchEntity($entity, $this->request->data);
			if ($this->Programs->save($data)) {	
				$this->Flash->success(__('Program has been saved successfully.'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('Unable to save data. Please fill all the required fields.'));
		}
		
		$event		 	= 	TableRegistry::get('Events');
		$event_arr 	 	 = 	$event->getEventArray();
		$this->set(compact('event_arr'));
		$this->set('form', $entity);
	}
	public function edit($id) {
		$program = $this->Programs->get($id);
		//echo "<pre>";print_r($program);exit;
		if ($this->request->is(['patch', 'post', 'put'])) {	
			$data 	= 	$this->Programs->patchEntity($program, $this->request->data);
			if ($this->Programs->save($data)) {
				$this->Flash->success(__('Program has been saved successfully.'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('Unable to save data. Please fill all the required fields.'));
		}
		$event		 	= 	TableRegistry::get('Events');
		$event_arr 	 	 = 	$event->getEventArray();
		$this->set(compact('program','event_arr'));
		$this->set('_program', ['program']);
	}
	

	public function updatestatus() {
		$this->autoRender = false;	
		if($this->request->is('post')) {
			$query 	=	 $this->Programs->query();
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
			echo '<a href="javascript:changeStatus(\'programs\', '.$id.','.$stVal.');" class="'.$class.'"">'.$stType.'</a>';
			exit();
		}
	}
	    /**
	     * Delete method
	     *
	     * @param string|null $id Programs id.
	     * @return \Cake\Network\Response|null Redirects to index.
	     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	     */
	public function delete($id = null)
	{
		$this->request->allowMethod(['get', 'delete']);
		$program = $this->Programs->get($id);
		if ($this->Programs->delete($program)) {
			$this->Flash->success(__('The program has been deleted.'));
		} else {
			$this->Flash->error(__('The program could not be deleted. Please, try again.'));
		}
		return $this->redirect(['action' => 'index']);
	}    
	private function export($query)
	{
		$this->Custom			=	 new CustomHelper(new \Cake\View\View());
		$dataArr = $query->toArray();
		$data = [];
		$_serialize 	='data';
		$_header 		= ['Program Name','Event Name','Description','Price','Item Code','Status'];
		$this->Custom 	=	 new CustomHelper(new \Cake\View\View());
		
		array_push($data, $_header);	
		foreach($dataArr as $items)
		{
			$d_arr[0] 	= ($items['title']!='')?$items['title']:'-';
			$d_arr[1] 	= ($items['event']['title']!='')?$items['event']['title']:'-';
			$d_arr[2] 	= ($items['description']!='')?$items['description']:'-';
			$d_arr[3] 	= ($items['price']!='')?$items['price']:'-';
			$d_arr[4] 	= ($items['item_code']!='')?$items['item_code']:'-';
			$d_arr[5] 	= ($items['status']!=0)?'Active':'Inactive';

			array_push($data, $d_arr);
		}
		//pr($data);die;

		$filename = "HRE_Programs_".time().'.csv';
		$this->set(compact('data', '_serialize'));
		$this->response->download($filename);
		$this->viewBuilder()->className('CsvView.Csv');
	}
}
