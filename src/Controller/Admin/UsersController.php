<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public $paginate = [
		'maxLimit' => 10,
	];
	
	public function initialize()
	{
		parent::initialize();
		$this->Auth->config('checkAuthIn', 'Controller.initialize');
		$this->Auth->allow(['logout','forgotPassword','resetPassword']);
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
			$entity 		= $this->Users->newEntity();
			$users 			= $this->Users->newEntity();
			$conditionsArr 	= ["Users.id !=" => $id];
			$searchQuery 	= $this->Users->find('all');
				
			if ($this->request->is(['get','put'])) {
				$this->request->data = $this->request->query;
				if($this->request->data('search_email')!='')
				{
					$search_keyword	=	$this->request->data['search_email'];
					$conditionsArr['Users.email LIKE '] = '%'.$search_keyword.'%';
				}
				if($this->request->data('search_name')!='')
				{
					$search_keyword	=	$this->request->data['search_name'];
					$conditionsArr['OR'][] = ['Users.first_name LIKE' => $search_keyword."%"];
					$conditionsArr['OR'][] = ['Users.last_name LIKE' =>  $search_keyword."%"];
					$conditionsArr['OR'][] = ['Users.email LIKE' =>  "%".$search_keyword."%"];
				}
				
				if(isset($this->request->data['status']) && $this->request->data['status']!='A'){
				$conditionsArr[] = ['Users.status' => $this->request->data['status']];
				}
				if(isset($this->request->data['role']) && $this->request->data['role']!='A'){
				$conditionsArr[] = ['Users.role' => $this->request->data['role']];
				}
				$searchQuery 	= $searchQuery->where([$conditionsArr]);
			}
			
			$users 			= $this->paginate($searchQuery);
			
			$this->set(compact('users'));
			$this->set('title', 'Manage Users');
			$this->set('form', $entity);
		}
		else
		{

		}
	}
    /**
     * Login method
     *
     * @return \Cake\Network\Response|null
     */
	public function login()
	{   
		$this->viewBuilder()->layout('admin_login');
		if ($this->request->is('post')) {
			$user = $this->Auth->identify();
			if ($user) {
				$data	 =	 $this->Users->get($user['id'])->toArray();
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
		$this->set('title', 'login');
	}
	public function logout()
	{
		return $this->redirect($this->Auth->logout());
	}
	
	public function dashboard() {
		$this->set('title', 'Dashboard');
	}
	 
	public function add()
	{
		
            $entity = $this->Users->newEntity($this->request->data);
            if ($this->request->is('post')) {
                   $data = $this->Users->patchEntity($entity, $this->request->data);
                    if ($this->Users->save($data)) {	
                            $this->Flash->success(__('Usedr has been saved successfully.'));
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

            $user		=   TableRegistry::get('Users');
            $user_arr 	 	=   $user->getUserArray();
            $this->set(compact('user_arr'));
            $this->set('form', $entity);
	}

	public function editProfile() {
		$id = $this->Auth->user('id');
		$entity = $this->Users->get($id);
		$this->set('data', $entity);
		if($this->request->is('post')) {
			$data = $this->Users->patchEntity($entity, $this->request->data);
			if( $this->Users->save($data) ) {
				$this->request->session()->write('name', $data['first_name'] .' '.$data['last_name']);
				 $this->Flash->success(__('Profile information has been updated successfully.'));
				return $this->redirect(['action' => 'edit_profile']);
			}
		}
		$entity = $this->Users->newEntity();
		$this->set('form', $entity);
	}
	public function edit($id = null) {
		$user = $this->Users->get($id);
		if ($this->request->is(['patch', 'post', 'put'])) {	
			
			
			$data 	= 	$this->Users->patchEntity($user, $this->request->data);
			if ($this->Users->save($data)) {
				$this->Flash->success(__('User has been saved successfully.'));
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
		
		
                $this->set(compact('user'));
		$this->set('_user', ['user']);
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
		$users = $this->Users->get($id);
		if ($this->Users->delete($users)) {
			$this->Flash->success(__('User deleted successfully.'));
		} else {
			$this->Flash->error(__('User could not be deleted. Please, try again.'));
		}
		return $this->redirect(['action' => 'index']);
	}    
	public function changepassword() {
		$id = $this->Auth->user('id');
		$entity = $this->Users->get($id);
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
				$data = $this->Users->patchEntity($entity, $this->request->data);
				if( $this->Users->save($data) ) {
					 $this->Flash->success(__('Password has been updated successfully.'));
					return $this->redirect(['action' => 'changepassword']);
				}
			}
			else {
				$this->Flash->error(__('Incorrect old password!'));
			}
		}
			$entity = $this->Users->newEntity();
			$this->set('form', $entity);
	}

	private function validatePass($pass, $hash_pass) {
		$check = (new DefaultPasswordHasher)->check($pass, $hash_pass);
		return $check;
	}
   
	/**
	     * Forgot password method
	     *
	     * @param string|null .
	     * @return \Cake\Network\Response|null Redirects to login and send reset password email to the user.
	*/
	public function forgotPassword()
	{
		$this->viewBuilder()->layout('admin_login');
		if ($this->request->is('post')) {
			$query = $this->Users->findByEmail($this->request->data['email']);
			$user = $query->first();
			if (is_null($user)) {
				$this->Flash->error('Email address does not exist. Please try again');
			} else {
				$passkey = uniqid();
				$url = Router::Url(['controller' => 'users', 'action' => 'resetPassword'], true) . '/' . $passkey;
				$timeout = time() + DAY;
				if ($this->Users->updateAll(['passkey' => $passkey, 'timeout' => $timeout], ['id' => $user->id])){
					$this->sendResetEmail($url, $user);
					$this->redirect(['action' => 'login']);
				} else {
					$this->Flash->error('Error saving reset passkey/timeout');
				}
			}
		}
		$this->set('title', 'Forgot Password');
	}
        /**
     * send restet password link method
     * @access Private
     * @param string|null .
     * @return \Cake\Network\Response|null send reset password email to the user.
     */    
	private function sendResetEmail($url, $user) {
		$email = new Email();
		$email->template('resetpw');
		$email->emailFormat('both');
		$email->from(FROM_EMAIL);
		$email->to($user->email, $user->full_name);
		$email->subject('Reset your password');
		$email->viewVars(['url' => $url, 'username' => $name]);
		if ($email->send()) {
			$this->Flash->success(__('Check your email to get reset password link'));
		} else {
			$this->Flash->error(__('Error sending email: ') . $email->smtpError);
		}
	}
    
	    /**
	     * Reset password method
	     *
	     * @param string|null .
	     * @return \Cake\Network\Response|null Redirects to login and resets the user password.
	     */
	public function resetPassword($passkey = null) {
		$this->viewBuilder()->layout('admin_login');
		if ($passkey) {
			$query = $this->Users->find('all', ['conditions' => ['passkey' => $passkey, 'timeout >' => time()]]);
			$user = $query->first();
			if ($user) {
				if (!empty($this->request->data)) {
					// Clear passkey and timeout
					$this->request->data['passkey'] = null;
					$this->request->data['timeout'] = null;
					$user = $this->Users->patchEntity($user, $this->request->data);
					if ($this->Users->save($user)) {
						$this->Flash->success(__('Your password has been updated.'));
						return $this->redirect(array('action' => 'login'));
					} else {
						$errorMessages = [];
						$errors = $user->errors();
						array_walk_recursive($errors, function($a) use (&$errorMessages) { $errorMessages[] = $a; });
						$this->Flash->error(__('The password could not be updated. Please, try again.'),['params' => ['errors' => $errorMessages]]);
					}
				}
			} else {
				$this->Flash->error('Invalid or expired passkey. Please check your email or try again');
				$this->redirect(['action' => 'forgotPassword']);
			}
				unset($user->password);
				$this->set(compact('user'));
		} else {
			$this->redirect('/');
		}
			$this->set('title', 'Reset Password');
	}
	public function updatestatus() {
		$this->autoRender = false;	
		if($this->request->is('post')) {
			$query 	=	 $this->Users->query();
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
}
