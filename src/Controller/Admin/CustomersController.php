<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\Auth\DefaultPasswordHasher;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class CustomersController extends AppController
{
	public $paginate = [
		'maxLimit' => 20,
	];
	public function initialize()
	{
		parent::initialize();
		$this->Auth->config('checkAuthIn', 'Controller.initialize');
		$this->viewBuilder()->layout('admin');
	}
	public function add()
	{
		$entity = $this->Customers->newEntity($this->request->data);
		if ($this->request->is('post')) {
			$password			 = 	$this->request->data['password'];
			$confirm_password	 = 	$this->request->data['confirm_password'];
			$data = $this->Customers->patchEntity($entity, $this->request->data);
			if ($this->Customers->save($data)) {	
				$this->Flash->success(__('Customer has been saved successfully.'));
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
		$this->set('form', $entity);
	}
	public function edit($id) {
		$customer = $this->Customers->get($id);
		//echo "<pre>";print_r($product);exit;
		if ($this->request->is(['patch', 'post', 'put'])) {	
			if(empty($this->request->data['password'])){
				unset($this->request->data['password']);
				unset($this->request->data['confirm_password']);
			}
			$data 	= 	$this->Customers->patchEntity($customer, $this->request->data);
			if ($this->Customers->save($data)) {
				$this->Flash->success(__('Customer has been saved successfully.'));
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
		
		$this->set(compact('customer'));
		$this->set('_customer', ['customer']);
	}
        public function index()
	{
		$entity = $this->Customers->newEntity();
		$customers = $this->Customers->newEntity();
		$conditionsArr = [];
		$searchQuery = $this->Customers->find('all');
		//search filter goes here
		if ($this->request->is(['get','put'])) {
			$this->request->data = $this->request->query;
			if(isset($this->request->data['status']) && $this->request->data['status']!='A'){
				$conditionsArr[] = ['Customers.status' => $this->request->data['status']];
			}
			if(!empty($this->request->data['search_keyword'])){
				$search_keyword	=	$this->request->data['search_keyword'];
				$conditionsArr['OR'][] = ['Customers.first_name LIKE' => $search_keyword."%"];
				$conditionsArr['OR'][] = ['Customers.last_name LIKE' =>  $search_keyword."%"];
				$conditionsArr['OR'][] = ['Customers.email LIKE' =>  "%".$search_keyword."%"];
			}
			if(!empty($this->request->data['search_contact_number'])){
				$search_contact_number	=	$this->request->data['search_contact_number'];
				$conditionsArr['Customers.contact_number LIKE '] = $search_contact_number.'%';
			}
			if(!empty($this->request->data['search_postcode'])){
				$search_postcode	=	$this->request->data['search_postcode'];
				$conditionsArr['Customers.postcode LIKE '] = $search_postcode.'%';
			}
			//final search query
			$searchQuery = $searchQuery->where([
				$conditionsArr
			]);
		}
		$customers = $this->paginate($searchQuery);
		$this->set(compact('customers'));
		$this->set('form', $entity);
		
	}
	public function updatestatus() {
		$this->autoRender = false;	
		if($this->request->is('post')) {
			$query 	=	 $this->Customers->query();
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
			echo '<a href="javascript:changeStatus(\'customers\', '.$id.','.$stVal.');" class="'.$class.'"">'.$stType.'</a>';
			exit();
		}
	}
	    /**
	     * Delete method
	     *
	     * @param string|null $id Products id.
	     * @return \Cake\Network\Response|null Redirects to index.
	     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	     */
	public function delete($id = null)
	{
		$this->request->allowMethod(['get', 'delete']);
		$customer = $this->Customers->get($id);
		if ($this->Customers->delete($customer)) {
			$this->Flash->success(__('The customer has been deleted.'));
		} else {
			$this->Flash->error(__('The customer could not be deleted. Please, try again.'));
		}
		return $this->redirect(['action' => 'index']);
	}  

	private function validatePass($pass, $hash_pass) {
		$check = (new DefaultPasswordHasher)->check($pass, $hash_pass);
		return $check;
	}
      
	public function searchExistsingCustomer()
	{
		//$this->autoRender = false;
		$this->viewBuilder()->autoLayout('');
		if ($this->request->is(['ajax'])) {
			$entity = $this->Customers->newEntity();
			$customers = $this->Customers->newEntity();
			$conditionsArr = ['Customers.status'=>'1'];
			
			$searchQuery = $this->Customers->find('all');
			if(!empty($this->request->data['search_customer'])){
				$search_keyword	=	$this->request->data['search_customer'];
				$conditionsArr['OR'][] = ['Customers.first_name LIKE' => $search_keyword."%"];
				$conditionsArr['OR'][] = ['Customers.last_name LIKE' =>  $search_keyword."%"];
				$conditionsArr['OR'][] = ['Customers.email LIKE' =>  "%".$search_keyword."%"];
				$conditionsArr['OR'][] = ['Customers.postcode LIKE' =>  "%".$search_keyword."%"];
				$conditionsArr['OR'][] = ['Customers.contact_number LIKE' =>  "%".$search_keyword."%"];
			}
			$searchQuery = $searchQuery->where([
				$conditionsArr
			]);
			if(!empty($searchQuery))
			{
				$status 	= 'success';
				$customers 	= $searchQuery;
				$error 		= '';
				$this->set(compact('customers','status','error'));
			}
			else{
				$status 	= 'false';
				$error 		= 'No result found';
				$this->set(compact('customers','status'));
			}
			
		}
		else{
				$status 	= 'false';
				$error 		= 'Oops an error occur';
				$customers 	= '';
				$this->set(compact('customers','status','error'));
		}
	}

	public function checkemailexists()
	{
		$this->viewBuilder()->autoLayout('');
		if ($this->request->is(['ajax'])) {
			$email = $this->request->data['email'];
			$customer = $this->Customers->getByEmailId($email);
			if($customer > 0)
			{
				$response['status'] = true;
				$response['msg']	= "Email is already in use";
			}
			else
			{
				$response['status'] = false;
				$response['msg']	= "";
			}
			
		}
		else{
				$response['status'] = false;
				$response['msg']	= "";
		}
		echo json_encode($response);
		exit;
	}
}
