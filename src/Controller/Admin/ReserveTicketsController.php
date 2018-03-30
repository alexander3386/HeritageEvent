<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use App\View\Helper\CustomHelper;
/**
 * Reservtickets Controller
 *
 * @property \App\Model\Table\ReserveTicketsTable $reserve_tickets
 */
class ReserveTicketsController extends AppController
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
		$id = $this->Auth->user('id');
		if ($id) {
			$entity 		= $this->ReserveTickets->newEntity();
			$reservetickets = $this->ReserveTickets->newEntity();
			$conditionsArr 	= [];
			$searchQuery 	= $this->ReserveTickets->find('all', ['contain' => ['Events','Tickets']]);
				
			if ($this->request->is(['get','put'])) {
				$this->request->data = $this->request->query;
				if($this->request->data('search_keyword')!='')
				{
					$conditionsArr = ["ReserveTickets.numberof_tickets"=>$this->request->data['search_keyword']];
				}
				if(!empty($this->request->data['event'])){
					$conditionsArr[] = ['ReserveTickets.event_id' => $this->request->data['event']];
				}
				if(isset($this->request->data['status']) && $this->request->data['status']!='A'){
				$conditionsArr[] = ['ReserveTickets.status' => $this->request->data['status']];
				}
				
				$searchQuery 	= $searchQuery->where([$conditionsArr]);
				if(isset($this->request->query['download_csv']))
				{
					$download_csv = $this->export($searchQuery);
				}
			}
			
			$reservetickets = $this->paginate($searchQuery);
			$event		 	= 	TableRegistry::get('Events');
			$event_arr 	 	= 	$event->getEventArray();
			
			$this->set(compact('reservetickets','event_arr'));
			$this->set('title', 'Manage Reserve Tickets');
			$this->set('form', $entity);
		}

	}
    
    public function add()
	{
	
        $entity = $this->ReserveTickets->newEntity($this->request->data);
        
        //pr($this->request);die;
        if ($this->request->is('post')) {
           	if(isset($this->request->data['from_date']) && !empty($this->request->data['from_date'])){
			$this->request->data['from_date']		=	$this->convertToDBFormat($this->request->data['from_date']);
			}
			if(isset($this->request->data['to_date']) && !empty($this->request->data['to_date'])){
				$this->request->data['to_date']		=	$this->convertToDBFormat($this->request->data['to_date']);
			}
           	$data = $this->ReserveTickets->patchEntity($entity, $this->request->data);
            if ($this->ReserveTickets->save($data)) {	
                    $this->Flash->success(__('Reserve tickets has been saved successfully.'));
                    return $this->redirect(['action' => 'index']);
            }
            if($data->errors()){
                    $error_msg = [];
                    foreach( $data->errors() as $errors){
                            if(is_array($errors)){
                                    foreach($errors as $error){
                                            $error_msg[]    =   $error;
                                    }
                            }else{
                                    $error_msg[]    =   $errors;
                            }
                    }
                    if(!empty($error_msg)){
                            $this->Flash->error( __("Please fix the following error(s):\n".implode("\n \r", $error_msg)));
                    }
            }
        }

	    $event		 	= 	TableRegistry::get('Events');
		$event_arr 	 	 = 	$event->getEventArray();
		$this->set(compact('event_arr'));
		$this->set('form', $entity);
	}
	public function edit($id = null) {
		$reserveTickets = $this->ReserveTickets->get($id);
		if ($this->request->is(['patch', 'post', 'put'])) {	
			
			if(isset($this->request->data['from_date']) && !empty($this->request->data['from_date'])){
			$this->request->data['from_date']		=	$this->convertToDBFormat($this->request->data['from_date']);
			}
			if(isset($this->request->data['to_date']) && !empty($this->request->data['to_date'])){
				$this->request->data['to_date']		=	$this->convertToDBFormat($this->request->data['to_date']);
			}
			
			$data 	= 	$this->ReserveTickets->patchEntity($reserveTickets, $this->request->data);
			if ($this->ReserveTickets->save($data)) {
				$this->Flash->success(__('Reserve tickets details saved successfully.'));
				return $this->redirect(['action' => 'index']);
			}
			if($data->errors()){
				$error_msg = [];
				foreach( $data->errors() as $errors){
					if(is_array($errors)){
						foreach($errors as $error){
							$error_msg[]    =   $error;
						}
					}else{
						$error_msg[]    =   $errors;
					}
				}
				if(!empty($error_msg)){
					$this->Flash->error( __("Please fix the following error(s):\n".implode("\n \r", $error_msg)));
				}
			}
		}
		
		$event		 	= 	TableRegistry::get('Events');
		$event_arr 	 	= 	$event->getEventArray();
		$ticket		 	= 	TableRegistry::get('Tickets');
		$ticket_arr 	= 	$ticket->getTicketArray();
		
		$this->set(compact('event_arr','ticket_arr','reserveTickets'));
		$this->set('_reserveTickets', ['reserveTickets']);
	}
    /**
     * Delete method
     *
     * @param string|null $id ReserveTickets id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
	public function delete($id = null)
	{
		$this->request->allowMethod(['get', 'delete']);
		$users = $this->ReserveTickets->get($id);
		if ($this->ReserveTickets->delete($users)) {
			$this->Flash->success(__('Reserved tickets deleted successfully.'));
		} else {
			$this->Flash->error(__('Reserved tickets could not be deleted. Please, try again.'));
		}
		return $this->redirect(['action' => 'index']);
	}    
	public function updatestatus() {
		$this->autoRender = false;	
		if($this->request->is('post')) {
			$query 	=	 $this->ReserveTickets->query();
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
	private function export($query)
	{
		$this->Custom			=	 new CustomHelper(new \Cake\View\View());
		$dataArr = $query->toArray();
		$data = [];
		$_serialize 	='data';
		$_header 		= ['Event Name','Ticket Name','Allow Ticket(s)','From Date / Time','To Date / Time','Status'];
		$this->Custom 	=	 new CustomHelper(new \Cake\View\View());
		
		array_push($data, $_header);	
		foreach($dataArr as $items)
		{
			$d_arr[0] 	= ($items['event']['title']!='')?$items['event']['title']:'-';
			$d_arr[1] 	= ($items['ticket']['title']!='')?$items['ticket']['title']:'-';
			$d_arr[2] 	= ($items['numberof_tickets']!='')?$items['numberof_tickets']:'-';
			$d_arr[3] 	= ($items['from_date']!='')?$this->Custom->displayDateFormat($items['from_date']):'-';
			$d_arr[4] 	= ($items['to_date']!='')?$this->Custom->displayDateFormat($items['to_date']):'-';
			$d_arr[5] 	= ($items['status']!=0)?'Active':'Inactive';

			array_push($data, $d_arr);
		}
		//pr($data);die;

		$filename = "HRE_Reserve_Tickets_".time().'.csv';
		$this->set(compact('data', '_serialize'));
		$this->response->download($filename);
		$this->viewBuilder()->className('CsvView.Csv');
	}
}
