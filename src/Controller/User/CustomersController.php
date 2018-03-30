<?php
namespace App\Controller\User;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\Auth\DefaultPasswordHasher;

class CustomersController extends AppController
{
	 public function initialize()
	{
		parent::initialize();
		$this->Auth->config('checkAuthIn', 'Controller.initialize');
		$this->Auth->allow(['logout','forgotPassword','resetPassword','login','signup','ajaxlogin']);
		$this->viewBuilder()->layout('front_default');
	}
	public function index(){
		$this->set('title', 'My Account');
	}
	public function signup(){
		$this->set('title', 'Sign up');
		$entity = $this->Customers->newEntity($this->request->data);
		if ($this->request->is('post')) {
			$password			 = 	$this->request->data['password'];
			$confirm_password	 = 	$this->request->data['confirm_password'];
			$this->request->data['status']	=	1;
			$data = $this->Customers->patchEntity($entity, $this->request->data);
			if ($this->Customers->save($data)) {	
				$user = $this->Auth->identify();
				if ($user) {
					$data	 =	 $this->Customers->get($user['id'])->toArray();
					$this->request->session()->write('name', $data['first_name'] .' '.$data['last_name']);
					$this->Customers->sendRegistrationEmail($data,$password);
					$this->Auth->setUser($user);
					return $this->redirect($this->Auth->redirectUrl());
				}
			}
			if($data->errors()){
				$error_msg = [];
				foreach( $data->errors() as $key=>$errors){
					$key	=	ucfirst(str_replace('_',' ',$key));
					if(is_array($errors)){
						foreach($errors as $error){
							$error_msg[]    =   $key.' - '.$error;
						}
					}else{
						$error_msg[]    =   $key.' - '.$error;
					}
				}
				if(!empty($error_msg)){
					$this->Flash->error( __("Please fix the following error(s):\n".implode("\n \r", $error_msg)));
				}
			}
		}
		$this->set('form', $entity);
	}
	public function login(){
		$this->set('title', 'Login');
		if ($this->request->is('post')) {
			$user = $this->Auth->identify();
			if ($user) {
				$data	 =	 $this->Customers->get($user['id'])->toArray();
				$this->request->session()->write('name', $data['first_name'] .' '.$data['last_name']);
				$this->Auth->setUser($user);
				return $this->redirect($this->Auth->redirectUrl());
			} else {
				$this->Flash->error('Your email or password is incorrect.');
			}
		}
		 //check if user is already logged in then redirect to its auth redirect url.
		if ($this->Auth->user()) {
			return $this->redirect($this->Auth->redirectUrl());
		}
	}
	public function ajaxlogin(){
		$this->viewBuilder()->autoLayout('');
		$this->autoRender = false;
		$response	=	array();
		$response['status']	=	true;
		$response['m']	=	"aaa";
		if ($this->request->is('post')) {
			$user = $this->Auth->identify();
			if ($user) {
				$data	 =	 $this->Customers->get($user['id'])->toArray();
				$this->request->session()->write('name', $data['first_name'] .' '.$data['last_name']);
				$this->Auth->setUser($user);
			} else {
				$response['status']	=	false;
				$response['message']	=	"Your email or password is incorrect.";
			}
		}
		echo json_encode($response);
		exit;
	}
	public function logout()
	{
		return $this->redirect($this->Auth->logout());
	}	
	private function validatePass($pass, $hash_pass) {
		$check = (new DefaultPasswordHasher)->check($pass, $hash_pass);
		return $check;
	}
	public function forgotPassword()
	{
		if ($this->request->is('post')) {
			$query = $this->Customers->findByEmail($this->request->data['email']);
			$customer = $query->first();
			if (is_null($customer)) {
				$this->Flash->error('Email address does not exist. Please try again');
			} else {
				$passkey = uniqid();
				$url = Router::Url(['controller' => 'customers', 'action' => 'resetPassword'], true) . '/' . $passkey;
				$timeout = time() + DAY;
				if ($this->Customers->updateAll(['passkey' => $passkey, 'timeout' => $timeout], ['id' => $customer->id])){
					$this->sendResetEmail($url, $customer);
					$this->redirect(['action' => 'login']);
				} else {
					$this->Flash->error('Error saving reset passkey/timeout');
				}
			}
		}
		$this->set('title', 'Forgot Password');
	}
	public function changepassword() {
		$this->set('title', 'Change Password');
		$id = $this->Auth->user('id');
		$entity = $this->Customers->get($id);
		$this->set('data', $entity);
		if($this->request->is('post')) {
			$old_pass	 = 	$this->request->data['old_pass'];
			$hash_pass	 =	 $entity->password;
			if( $this->validatePass($old_pass, $hash_pass) == 1)
			{
				if( $this->request->data['confirm_password'] != '') {
					$this->request->data['password'] = $this->request->data['confirm_password'];
				}
				unset($this->request->data['old_pass']);
				$data = $this->Customers->patchEntity($entity, $this->request->data);
				if( $this->Customers->save($data) ) {
					 $this->Flash->success(__('Password has been updated successfully.'));
					return $this->redirect(['action' => 'changepassword']);
				}
			}else {
				$this->Flash->error(__('Incorrect old password!'));
			}
		}
		$entity = $this->Customers->newEntity();
		$this->set('form', $entity);
		
	}
	public function editProfile() {
		$id = $this->Auth->user('id');
		$entity = $this->Customers->get($id);
		$this->set('data', $entity);
		if($this->request->is('post')) {
			$data = $this->Customers->patchEntity($entity, $this->request->data);
			if( $this->Customers->save($data) ) {
				$this->request->session()->write('name', $data['first_name'] .' '.$data['last_name']);
				 $this->Flash->success(__('Profile information has been updated successfully.'));
				return $this->redirect(['action' => 'edit_profile']);
			}
		}
		$entity = $this->Customers->newEntity();
		$this->set('form', $entity);
		$this->set('title', 'Edit Profile');
	}
	
	 /**
	     * Reset password method
	     *
	     * @param string|null .
	     * @return \Cake\Network\Response|null Redirects to login and resets the user password.
	     */
	public function resetPassword($passkey = null) {
		if ($passkey) {
			$query = $this->Customers->find('all', ['conditions' => ['passkey' => $passkey, 'timeout >' => time()]]);
			$customer = $query->first();
			if ($customer) {
				if (!empty($this->request->data)) {
					// Clear passkey and timeout
					$this->request->data['passkey'] = null;
					$this->request->data['timeout'] = null;
					$customer = $this->Customers->patchEntity($customer, $this->request->data);
					if ($this->Customers->save($customer)) {
						$this->Flash->success(__('Your password has been updated.'));
						return $this->redirect(array('action' => 'login'));
					} else {
						$errorMessages = [];
						$errors = $customer->errors();
						array_walk_recursive($errors, function($a) use (&$errorMessages) { $errorMessages[] = $a; });
						$this->Flash->error(__('The password could not be updated. Please, try again.'),['params' => ['errors' => $errorMessages]]);
					}
				}
			} else {
				$this->Flash->error('Invalid or expired passkey. Please check your email or try again');
				$this->redirect(['action' => 'forgotPassword']);
			}
			unset($customer->password);
			$this->set(compact('customer'));
		} else {
			$this->redirect('/');
		}
		$this->set('title', 'Reset Password');
	}
	private function sendResetEmail($url, $customer) {
		$full_name	=	$customer->first_name.' '.$customer->last_name;
		$email = new Email();
		$email->template('resetpw');
		$email->emailFormat('both');
		$email->from(FROM_EMAIL);
		$email->to($customer->email, $full_name);
		$email->subject('Reset your password');
		$email->viewVars(['url' => $url, 'username' => $customer->email]);
		if ($email->send()) {
			$this->Flash->success(__('Check your email to get reset password link'));
		} else {
			$this->Flash->error(__('Error sending email: ') . $email->smtpError);
		}
	}
	
	public function importcustomer(){
		/*
		$this->loadModel('OldCustomers');
		$this->autoRender = false;
		set_time_limit(3000000);
		$OldCustomers 		= 	$this->OldCustomers->find('all')->where(['email is  not null','email !='=>'','id >=' =>72391654])
										->group('email')
										//->limit(2)
										->order(['id' => 'asc'])
										->all();
										
		if($OldCustomers){								
			foreach($OldCustomers as $OldCustomer){
				$customerData['email']				=	$OldCustomer->email;
				$passkey = uniqid();
				$customerData['password'] = $passkey;
				$customerData['confirm_password'] = $passkey;
				$customerData['title']				=	ucfirst(strtolower($OldCustomer->title));
				$customerData['first_name']			=	$OldCustomer->fname;
				$customerData['last_name']			=	$OldCustomer->sname;
				$customerData['address1']			=	$OldCustomer->address1;
				$customerData['address2']			=	$OldCustomer->address2;
				$customerData['town']				=	$OldCustomer->town;
				$customerData['county']				=	$OldCustomer->county;
				$customerData['country']				=	$OldCustomer->country;
				$customerData['postcode']			=	$OldCustomer->postcode;
				$telephone							=	@str_replace(" ","",$OldCustomer->telephone);			
				$telephone							=	(int)$telephone;
				if(!empty($telephone) && $telephone>0){
					$customerData['contact_number']		=	$telephone;
				}else{
					$mobile								=	@str_replace(" ","",$OldCustomer->mobile);	
					$customerData['contact_number']		=	$mobile;
				}
				
				$customerData['status']				=	1;
				$customerData['hseoptin']			=	$OldCustomer->hseoptin;
				$customerData['hostoptin']			=	$OldCustomer->hostoptin;
				$customerData['where_here']			=	$OldCustomer->whereheard;
				if($OldCustomer->created && $OldCustomer->created!='0000-00-00 00:00:00'){
					$customerData['created']				=	date('Y-m-d H:i:s', strtotime($OldCustomer->created));
				}
				$entity 			= 	$this->Customers->newEntity();
				$data 			= 	$this->Customers->patchEntity($entity, $customerData);
				if($customerResult	=	$this->Customers->save($data)){
					
				}else{
					if($data->errors()){
						$error_msg = [];
						foreach( $data->errors() as $key=>$errors){
							$key	=	ucfirst(str_replace('_',' ',$key));
							if(is_array($errors)){
								foreach($errors as $error){
									$error_msg[]    =   $key.' - '.$error;
								}
							}else{
								$error_msg[]    =   $key.' - '.$error;
							}
						}
						if(!empty($error_msg)){
							echo $message	=	 __("Please fix the following error(s):\n".implode("<br />", $error_msg));
							echo "<br />";
						}
					}
				}
				
			}
		}	
		*/
	}
}
