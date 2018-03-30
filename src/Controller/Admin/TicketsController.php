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
class TicketsController extends AppController
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
		$entity = $this->Tickets->newEntity();
		$tickets = $this->Tickets->newEntity();
		$conditionsArr = [];
		$searchQuery = $this->Tickets->find('all', ['contain' => ['Events']]);
		//search filter goes here
		if ($this->request->is(['get','put'])) {
			$this->request->data = $this->request->query;
			if(isset($this->request->data['status']) && $this->request->data['status']!='A'){
				$conditionsArr[] = ['Tickets.status' => $this->request->data['status']];
			}
			if(!empty($this->request->data['event'])){
				$conditionsArr[] = ['event_id' => $this->request->data['event']];
			}
			if(!empty($this->request->data['search_keyword'])){
				$search_keyword	=	$this->request->data['search_keyword'];
				$conditionsArr['Tickets.title LIKE '] = '%'.$search_keyword.'%';
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
		$tickets = $this->paginate($searchQuery);
		$event		 	= 	TableRegistry::get('Events');
		$event_arr 	 	 = 	$event->getEventArray();
		$this->set(compact('tickets','event_arr'));
		$this->set('form', $entity);
		
	}
	public function add()
	{
		$entity = $this->Tickets->newEntity($this->request->data, ['associated' => ['TicketPrices','TicketGroupPrices']]);
		if ($this->request->is('post')) {
			//pr($this->request->data);
			if(isset($this->request->data['ticket_prices'])){
				$ticketprices	=	array();
				$counter	=	0;
				foreach($this->request->data['ticket_prices'] as $ticketprice){
					if(!empty($ticketprice['date_from']) && !empty($ticketprice['date_to'])){
						$ticketprices[$counter]['date_from']		=	$this->convertDateToDBFormat($ticketprice['date_from']);
						$ticketprices[$counter]['date_to']			=	$this->convertDateToDBFormat($ticketprice['date_to']);
						$ticketprices[$counter]['extra_price']		=	$ticketprice['extra_price'];
						$ticketprices[$counter]['extra_price_type']	=	$ticketprice['extra_price_type'];
						$counter++;
					}
				}
				unset($this->request->data['ticket_prices']);
				$this->request->data['ticket_prices']	=	$ticketprices;
			}
			
			if(isset($this->request->data['ticket_group_prices'])){
				$ticket_group_prices	=	array();
				$counter	=	0;
				foreach($this->request->data['ticket_group_prices'] as $ticket_group_price){
					if(!empty($ticket_group_price['ticket_qty']) && $ticket_group_price['ticket_qty'] > 1 ){
						$ticket_group_prices[$counter]	=	$ticket_group_price;
						$counter++;
					}
				}
				unset($this->request->data['ticket_group_prices']);
				$this->request->data['ticket_group_prices']	=	$ticket_group_prices;
			}
			//pr($this->request->data);exit;
			$data = $this->Tickets->patchEntity($entity, $this->request->data, ['associated' => ['TicketPrices','TicketGroupPrices']]);
			if ($this->Tickets->save($data, ['associated' => ['TicketPrices','TicketGroupPrices']])) {	
				$this->Flash->success(__('Ticket has been saved successfully.'));
				return $this->redirect(['action' => 'index']);
			}else{
				$this->Flash->error(__('Unable to save data. Please fill all the required fields.'));
			}
		}
		
		$event		 	= 	TableRegistry::get('Events');
		$event_arr 	 	 = 	$event->getEventArray();
		$this->set(compact('event_arr'));
		$this->set('form', $entity);
	}
	public function edit($id) {
		$ticket = $this->Tickets->get($id,['contain' => ['TicketPrices','TicketGroupPrices']]);
		//echo "<pre>";print_r($ticket);exit;
		if ($this->request->is(['patch', 'post', 'put'])) {	
		
			if(isset($this->request->data['ticket_prices'])){
				$ticketprices	=	array();
				$counter		=	0;
				//$this->loadModel('TicketPrices');
				//$this->TicketPrices->deleteAll(['TicketPrices.ticket_id'=>$id]);
				foreach($this->request->data['ticket_prices'] as $ticketprice){
					if(!empty($ticketprice['date_from']) && !empty($ticketprice['date_to'])){
						$ticketprices[$counter]['date_from']		=	$this->convertDateToDBFormat($ticketprice['date_from']);
						$ticketprices[$counter]['date_to']			=	$this->convertDateToDBFormat($ticketprice['date_to']);
						$ticketprices[$counter]['extra_price']		=	$ticketprice['extra_price'];
						$ticketprices[$counter]['extra_price_type']	=	$ticketprice['extra_price_type'];
						if(isset($ticketprice['id'])){
							$ticketprices[$counter]['id']		=	$ticketprice['id'];
						}
						$counter++;
					}
				}
				unset($this->request->data['ticket_prices']);
				$this->request->data['ticket_prices']	=	$ticketprices;
			}
			
			if(isset($this->request->data['ticket_group_prices'])){
				$ticket_group_prices	=	array();
				$counter	=	0;
				//$this->loadModel('TicketGroupPrices');
				//$this->TicketGroupPrices->deleteAll(['TicketGroupPrices.ticket_id'=>$id]);
				foreach($this->request->data['ticket_group_prices'] as $ticket_group_price){
					if(!empty($ticket_group_price['ticket_qty']) && $ticket_group_price['ticket_qty'] > 1 ){
						$ticket_group_prices[$counter]	=	$ticket_group_price;
						if(isset($ticket_group_price['id'])){
							$ticket_group_prices[$counter]['id']		=	$ticket_group_price['id'];
						}
						$counter++;
					}
				}
				unset($this->request->data['ticket_group_prices']);
				$this->request->data['ticket_group_prices']	=	$ticket_group_prices;
			}
			$data 	= 	$this->Tickets->patchEntity($ticket, $this->request->data, ['associated' => ['TicketPrices','TicketGroupPrices']]);
			if ($this->Tickets->save($data, ['associated' => ['TicketPrices','TicketGroupPrices']])) {
				$this->Flash->success(__('Ticket has been saved successfully.'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('Unable to save data. Please fill all the required fields.'));
		}
		$event		 	= 	TableRegistry::get('Events');
		$event_arr 	 	 = 	$event->getEventArray();
		$this->set(compact('ticket','event_arr'));
		$this->set('_ticket', ['ticket']);
	}
	
	public function addMorePriceField($row_count)
	{
		$this->viewBuilder()->autoLayout('');
		$this->set(compact('row_count'));
	}
	public function addGroupPriceField($row_count)
	{
		$this->viewBuilder()->autoLayout('');
		$this->set(compact('row_count'));
	}
	public function updatestatus() {
		$this->autoRender = false;	
		if($this->request->is('post')) {
			$query 	=	 $this->Tickets->query();
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
			echo '<a href="javascript:changeStatus(\'tickets\', '.$id.','.$stVal.');" class="'.$class.'"">'.$stType.'</a>';
			exit();
		}
	}
	    /**
	     * Delete method
	     *
	     * @param string|null $id Tickets id.
	     * @return \Cake\Network\Response|null Redirects to index.
	     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	     */
	public function delete($id = null)
	{
		$this->request->allowMethod(['get', 'delete']);
		$ticket = $this->Tickets->get($id);
		if ($this->Tickets->delete($ticket)) {
			$this->Flash->success(__('The ticket has been deleted.'));
		} else {
			$this->Flash->error(__('The ticket could not be deleted. Please, try again.'));
		}
		return $this->redirect(['action' => 'index']);
	}    
	public function removeticketprice($id = null){
		$this->autoRender = false;	
		if(!$id){
			$id 		= 	$this->request->data['id'];
		}
		$this->loadModel('TicketPrices');
		$TicketPrice = $this->TicketPrices->get($id);
		if ($this->TicketPrices->delete($TicketPrice)) {} 
		return true;
	}
	public function removegroupticketprice($id = null){
		$this->autoRender = false;	
		if(!$id){
			$id 		= 	$this->request->data['id'];
		}
		$this->loadModel('TicketGroupPrices');
		$TicketGroupPrice = $this->TicketGroupPrices->get($id);
		if ($this->TicketGroupPrices->delete($TicketGroupPrice)) {} 
		return true;
	}
	public function getticketsbyeventid()
	{
		$this->autoRender = false;	
		$this->viewBuilder()->autoLayout('');
		if ($this->request->is(['ajax'])) {
			
			$event_id = $this->request->data['event_id'];
			
			$query = $this->Tickets->find('all')->where(['event_id'=>$event_id]);
			
			$tickets = $query->toArray();
			
			//pr($tickets);die;
			$htmlSelect = '<select name="ticket_id" id="ticket_id" class="form-control">';
		        
			if(!empty($tickets) )
			{
				foreach($tickets as $ticket) {
	            	$htmlSelect.= '<option value="'.$ticket['id'].'">'.$ticket['title'].'</option>';
	            }
		        
			}
			else
			{
				$htmlSelect.= '<option value=" ">No result found</option>';
		    }
			
		}
		else{
				$htmlSelect.= '<option value=" ">No result found</option>';
		}
		$htmlSelect.= '</select>';
		echo $htmlSelect;
		exit;
	}
	private function export($query)
	{
		$this->Custom			=	 new CustomHelper(new \Cake\View\View());
		$dataArr = $query->toArray();
		$data = [];
		$_serialize 	='data';
		$_header 		= ['Ticket Name','Event Name','Description','Item Code','Price','Total Allocation','Web Allocation','Offline Allocation','Status'];
		$this->Custom 	=	 new CustomHelper(new \Cake\View\View());
		
		array_push($data, $_header);	
		foreach($dataArr as $items)
		{
			$d_arr[0] 	= ($items['title']!='')?$items['title']:'-';
			$d_arr[1] 	= ($items['event']['title']!='')?$items['event']['title']:'-';
			$d_arr[2] 	= ($items['description']!='')?$items['description']:'-';
			$d_arr[3] 	= ($items['item_code']!='')?$items['item_code']:'-';
			$d_arr[4] 	= ($items['price']!='')?$items['price']:'-';
			$d_arr[5] 	= ($items['total_allocation']!='')?$items['total_allocation']:'-';
			$d_arr[6] 	= ($items['web_allocation']!='')?$items['web_allocation']:'-';
			$d_arr[7] 	= ($items['offline_allocation']!='')?$items['offline_allocation']:'-';
			$d_arr[8] 	= ($items['status']!=0)?'Active':'Inactive';

			array_push($data, $d_arr);
		}
		//pr($data);die;

		$filename = "HRE_Tickets_".time().'.csv';
		$this->set(compact('data', '_serialize'));
		$this->response->download($filename);
		$this->viewBuilder()->className('CsvView.Csv');
	}
}
