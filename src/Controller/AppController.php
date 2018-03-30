<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('RequestHandler');
		$this->loadComponent('Flash');
		$this->loadComponent('Paginator');
		if ($this->request->prefix == 'admin') {
			$this->loadComponent('Auth', [
				'authorize' => 'Controller', // Added this line
				'loginRedirect' => [
					'controller' => 'Users',
					'action' => 'dashboard',
					'prefix' => 'admin'
				],
				'logoutRedirect' => [
					'controller' => 'Users',
					'action' => 'login',
					'prefix' => 'admin'
				],
				'authenticate' => [
					'Form' => [
						'fields' => ['username' => 'email','password' => 'password']
					]
				],
				'storage' => [
					'className' => 'Session',
					'key' => 'Auth.Admin',              
				],
			]);
		}else if ($this->request->prefix == 'user') {
			$this->loadComponent('Auth', [
				'authorize' => 'Controller', // Added this line
				'loginRedirect' => [
					'controller' => 'Customers',
					'action' => 'index',
					'prefix' => 'user'
				],
				'logoutRedirect' => [
					'controller' => 'Customers',
					'action' => 'login',
					'prefix' => 'user'
				],
				'authenticate' => [
					'Form' => [
						'fields' => ['username' => 'email','password' => 'password'],
						'userModel' => 'Customers'
					]
				],
				'storage' => [
					'className' => 'Session',
					'key' => 'Auth.Customer',              
				],
			]);
		}

	}
	public function isAuthorized($user) {
    
		// Only admins can access admin functions
		if ($this->request->prefix == 'admin' && $user['role']!=='user') {
			return (bool)($user['role'] === 'admin');
		}elseif ($this->request->prefix == 'user') {
			return true;
		} else{
			$this->Flash->error('You are not authorised to access this location.');
			return $this->redirect($this->Auth->logout());
		}
		return false;
	}
	 public function convertToDBFormat($datetime=null){
		if($datetime==null || $datetime=='0000-00-00 00:00:00' || $datetime=='')
			return;
		
		$datetimeArr	=	explode(" ",$datetime);
		$dateArr		=	explode("/",$datetimeArr[0]);
		
		$datetime		=	$dateArr[2].'-'.$dateArr[1].'-'.$dateArr[0].' '.$datetimeArr[1];
		return $datetime;
       }
	 public function convertDateToDBFormat($date=null){
		if($date==null || $date=='0000-00-00' || $date=='')
			return;
		
		$dateArr		=	explode("/",$date);
		$date			=	$dateArr[2].'-'.$dateArr[1].'-'.$dateArr[0];
		return $date;
       }
}
