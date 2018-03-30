<?php 
namespace App\Controller\User;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\Auth\DefaultPasswordHasher;
class OrdersController extends AppController
{
	 public function initialize()
	{
		parent::initialize();
		$this->Auth->config('checkAuthIn', 'Controller.initialize');
		$this->Auth->allow([]);
		$this->viewBuilder()->layout('front_default');
		$this->loadModel("OrderItems");
		$this->loadModel("AbandonedCarts");
		$this->loadModel("Carts");
	}
	public function index(){
		$this->set('title', 'Orders');
		$customer_id 		= 	$this->Auth->user('id');
		$orders 			= 	$this->Orders->find('all',['order' => ['Orders.created' => 'DESC']])->where( ['Orders.customer_id' =>$customer_id,'Orders.order_status !=' =>'pending'])->contain(['Events'])->all();
		$this->set(compact('orders'));		
	}
	public function details($id=null){
		$this->set('title', 'Order Details');
		$customer_id 	= 	$this->Auth->user('id');
		$order 			= 	$this->Orders->find('all')->where( ['Orders.id' =>$id,'Orders.customer_id' =>$customer_id,'Orders.order_status !=' =>'pending'])->contain(['Events','Customers'])->first();
		if($order){
			$orderid	=	$order->id;
			$tickets 		= 	$this->OrderItems->getTicketsItem($orderid);
			$products 	= 	$this->OrderItems->getProductItem($orderid);
			$programs 	= 	$this->OrderItems->getProgramItem($orderid);
		}
		
		$this->set(compact('order','tickets','products','programs'));		
	}
	
}
?>