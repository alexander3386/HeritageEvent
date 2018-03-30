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
class CouponsController extends AppController
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
		$entity = $this->Coupons->newEntity();
		$coupons = $this->Coupons->newEntity();
		$conditionsArr = [];
		$searchQuery = $this->Coupons->find('all');
		//search filter goes here
		if ($this->request->is(['get','put'])) {
			$this->request->data = $this->request->query;
			if(isset($this->request->data['status']) && $this->request->data['status']!='A'){
				$conditionsArr[] = ['Coupons.status' => $this->request->data['status']];
			}
			if(!empty($this->request->data['search_keyword'])){
				$search_keyword	=	$this->request->data['search_keyword'];
				$conditionsArr['Coupons.coupon_code LIKE '] = $search_keyword.'%';
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
		$coupons = $this->paginate($searchQuery);
		
		$this->set(compact('coupons'));
		$this->set('form', $entity);
		
	}
	public function add()
	{
		$entity = $this->Coupons->newEntity($this->request->data);
		if ($this->request->is('post')) {
			if(isset($this->request->data['expire_date']) && !empty($this->request->data['expire_date'])){
				$form_expire_date					=	$this->request->data['expire_date'];
				$this->request->data['expire_date']	=	$this->convertDateToDBFormat($this->request->data['expire_date']);
			}
			if($this->request->data['type'] == 4 && !empty($this->request->data['ticket_ids'])){
				$this->request->data['ticket_ids']	=	serialize($this->request->data['ticket_ids']);
				$this->request->data['product_ids']	=	'';
				$this->request->data['program_ids']	=	'';
			}elseif($this->request->data['type'] == 5 && !empty($this->request->data['product_ids'])){
				$this->request->data['product_ids']	=	serialize($this->request->data['product_ids']);
				$this->request->data['ticket_ids']	=	'';
				$this->request->data['program_ids']	=	'';
			}elseif($this->request->data['type'] == 6 && !empty($this->request->data['program_ids'])){
				$this->request->data['program_ids']	=	serialize($this->request->data['program_ids']);
				$this->request->data['ticket_ids']		=	'';
				$this->request->data['product_ids']	= 	'';
			}else{
				$this->request->data['product_ids']	=	'';
				$this->request->data['ticket_ids']	=	'';
				$this->request->data['program_ids']	=	'';
			}
			$data = $this->Coupons->patchEntity($entity, $this->request->data);
			if ($this->Coupons->save($data)) {	
				$this->Flash->success(__('Coupon has been saved successfully.'));
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
					$this->request->data['expire_date']		=	$form_expire_date;
				}
			}
			//$this->Flash->error(__('Unable to save data. Please fill all the required fields.'));
		}
		$ticket_arr 	 	= 	$this->getTicketWithEventArray();
		$product_arr 	 = 	$this->getProductWithEventArray();
		$program_arr 	 = 	$this->getProgramWithEventArray();
		$this->set(compact('event_arr','ticket_arr','product_arr','program_arr'));
		$this->set('form', $entity);
	}
	public function edit($id) {
		$coupon = $this->Coupons->get($id);
		//echo "<pre>";print_r($coupon);exit;
		if ($this->request->is(['patch', 'post', 'put'])) {	
			if(isset($this->request->data['expire_date']) && !empty($this->request->data['expire_date'])){
				$form_expire_date					=	$this->request->data['expire_date'];
				$this->request->data['expire_date']	=	$this->convertDateToDBFormat($this->request->data['expire_date']);
			}
			if($this->request->data['type'] == 4 && !empty($this->request->data['ticket_ids'])){
				$this->request->data['ticket_ids']	=	serialize($this->request->data['ticket_ids']);
				$this->request->data['product_ids']	=	'';
				$this->request->data['program_ids']	=	'';
			}elseif($this->request->data['type'] == 5 && !empty($this->request->data['product_ids'])){
				$this->request->data['product_ids']	=	serialize($this->request->data['product_ids']);
				$this->request->data['ticket_ids']	=	'';
				$this->request->data['program_ids']	=	'';
			}elseif($this->request->data['type'] == 6 && !empty($this->request->data['program_ids'])){
				$this->request->data['program_ids']	=	serialize($this->request->data['program_ids']);
				$this->request->data['ticket_ids']		=	'';
				$this->request->data['product_ids']	= 	'';
			}else{
				$this->request->data['product_ids']	=	'';
				$this->request->data['ticket_ids']	=	'';
			}
			$data 	= 	$this->Coupons->patchEntity($coupon, $this->request->data);
			if ($this->Coupons->save($data)) {
				$this->Flash->success(__('Coupon has been saved successfully.'));
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
					$this->request->data['expire_date']		=	$form_expire_date;
				}
			}
			//$this->Flash->error(__('Unable to save data. Please fill all the required fields.'));
		}
		$ticket_arr 	 	= 	$this->getTicketWithEventArray();
		$product_arr 	 = 	$this->getProductWithEventArray();
		$program_arr 	 = 	$this->getProgramWithEventArray();
		$this->set(compact('ticket_arr','product_arr','program_arr'));
		$this->set(compact('coupon'));
		$this->set('_coupon', ['coupon']);
	}
	
	
	public function updatestatus() {
		$this->autoRender = false;	
		if($this->request->is('post')) {
			$query 	=	 $this->Coupons->query();
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
			echo '<a href="javascript:changeStatus(\'coupons\', '.$id.','.$stVal.');" class="'.$class.'"">'.$stType.'</a>';
			exit();
		}
	}
	    /**
	     * Delete method
	     *
	     * @param string|null $id Coupons id.
	     * @return \Cake\Network\Response|null Redirects to index.
	     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	     */
	public function delete($id = null)
	{
		$this->request->allowMethod(['get', 'delete']);
		$coupon = $this->Coupons->get($id);
		if ($this->Coupons->delete($coupon)) {
			$this->Flash->success(__('Coupon has been deleted.'));
		} else {
			$this->Flash->error(__('Coupon could not be deleted. Please, try again.'));
		}
		return $this->redirect(['action' => 'index']);
	}    
	public function getTicketWithEventArray(){
		$this->loadModel('Tickets');
		$tickets 			= 	$this->Tickets->find('all', ['contain' => ['Events']]);
		$ticketsArray	=	array();
		if($tickets){
			foreach($tickets as $ticket){
				$ticketsArray[$ticket['id']]		=	$ticket['title'].' ('.$ticket['event']['title'].')';
			}
		}
		return $ticketsArray;
	}  
	public function getProductWithEventArray(){
		$this->loadModel('Products');
		$products 			= 	$this->Products->find('all', ['contain' => ['Events']]);
		$productsArray	=	array();
		if($products){
			foreach($products as $product){
				$productsArray[$product['id']]		=	$product['title'].' ('.$product['event']['title'].')';
			}
		}
		return $productsArray;
	}  
	public function getProgramWithEventArray(){
		$this->loadModel('Programs');
		$programs 			= 	$this->Programs->find('all', ['contain' => ['Events']]);
		$programsArray	=	array();
		if($programs){
			foreach($programs as $program){
				$programsArray[$program['id']]		=	$program['title'].' ('.$program['event']['title'].')';
			}
		}
		return $programsArray;
	}  

	private function export($query)
	{
		$this->Custom			=	 new CustomHelper(new \Cake\View\View());
		$dataArr = $query->toArray();
		$data = [];
		$_serialize 	='data';
		$_header 		= ['Coupon Code','Description','Applicable to','Discount Price',
		'Discount Price In','Expiry Date','Status'];
		$this->Custom 	=	 new CustomHelper(new \Cake\View\View());
		
		array_push($data, $_header);	
		foreach($dataArr as $items)
		{
			$d_arr[0] 	= ($items['coupon_code']!='')?$items['coupon_code']:'-';
			$d_arr[1] 	= ($items['title']!='')?$items['title']:'-';
			$d_arr[2] 	= ($items['type']!='')?$this->Custom->displayCouponType($items['type']):'-';
			$d_arr[3] 	= ($items['discount_price']!=0)?$items['discount_price']:'-';
			$d_arr[4] 	= ($items['discount_type']!=0)?'In percent(%)':'Fixed Cost';
			
			$d_arr[5] 	= ($items['expire_date']!='')?$this->Custom->displayDateFormat($items['expire_date']):'-';
			$d_arr[6] 	= ($items['status']!=0)?'Active':'Inactive';

			array_push($data, $d_arr);
		}
		//pr($data);die;

		$filename = "HRE_Coupons_".time().'.csv';
		$this->set(compact('data', '_serialize'));
		$this->response->download($filename);
		$this->viewBuilder()->className('CsvView.Csv');
	}
}
