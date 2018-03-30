<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\Auth\DefaultPasswordHasher;
use App\View\Helper\CustomHelper;
use Cake\Network\Session;


class CartsController extends AppController {
	public function initialize()
	{
		parent::initialize();
		$this->loadModel('Customers');
		$this->loadModel('Events');
		$this->loadModel('Customers');
		$this->loadModel('DefaultSettings');
		$this->loadModel('Coupons');
		$this->loadModel('Tickets');
		$this->loadModel('Products');
		$this->loadModel('Programs');
		$this->loadModel('Orders');
		$this->loadModel('OrderItems');
		$this->loadModel('AbandonedCarts');
		$this->loadModel('ReserveTickets');
		
		$this->loadComponent('Worldpay');
		$this->loadComponent('Mailchimp');
		$this->viewBuilder()->layout('front_default');
		
		
	}
	public function cart() {
		
		$id		=	$this->Events->getUpcomingEventID();
		if(!$id){
			$this->redirect(['controller'=>'pages', 'action' => 'index']);
		}
		$event 	= 	$this->Events->find('all')->where( ['Events.id' =>$id] )
										->contain(['Uploads', 'Tickets', 'Products', 'Programs'])
										->first();
		
		$this->ReserveTickets->checkAvailableTickets($id,12);
		$carts = $this->Carts->readCartItem();
		//pr($carts);exit;
		$tickets 		= 	array();
		$programs 	= 	array();
		if (null!=$carts) {
			if(isset($carts['tickets']) && count($carts['tickets']) > 0){
				$tickets 		=	$carts['tickets'];
			}
			if(isset($carts['programs']) && count($carts['programs']) > 0){
				$programs 		=	$carts['programs'];
			}
		}
		$this->set(compact('event'));
		$this->set('title', 'Heritage Events');
		$this->set(compact('tickets','carts','programs'));
	}
	public function cartitems(){
		$this->viewBuilder()->autoLayout('');
		$carts = $this->Carts->readCartItem();
		$tickets 		= 	array();
		$products 	= 	array();
		$programs 	= 	array();
		if (null!=$carts) {
			if(isset($carts['tickets'])){
				foreach ($carts['tickets'] as $id => $array) {
					$ticket 				= 	$this->Tickets->get($id);
					$ticket['qty'] 		= 	$array['qty'];
					$tickets[]			=	$ticket;
				}
			}
			if(isset($carts['products'])){
				foreach ($carts['products'] as $id => $array) {
					$product 			= 	$this->Products->get($id);
					$product['qty'] 		= 	$array['qty'];
					$products[]			=	$product;
				}
			}
			if(isset($carts['programs'])){
				foreach ($carts['programs'] as $id => $array) {
					$program 			= 	$this->Programs->get($id);
					$program['qty'] 		= 	$array['qty'];
					$programs[]			=	$program;
				}
			}
		}
		$this->set(compact('products','tickets','programs','carts'));
	}
	public function checkout() {
		$settings 	= 	$this->DefaultSettings->get(1);
		$id			=	$this->Events->getUpcomingEventID();
		if(!$id){
			$this->redirect(['controller'=>'pages', 'action' => 'index']);
		}
		$event 	= 	$this->Events->find('all')->where( ['Events.id' =>$id] )
										->contain(['Uploads', 'Tickets', 'Products', 'Programs'])
										->first();
		
		
		$carts = $this->Carts->readCartItem();
		
		$session = new Session();
		if($session->read('Auth.Customer.id')){
			$entity = $this->Customers->get($session->read('Auth.Customer.id'));
		}else{
			$entity = $this->Customers->newEntity($this->request->data);
		}
		$this->set('form', $entity);
		
		$this->set(compact('event'));
		$this->set('title', 'Heritage Events');
		$this->set(compact('carts','settings'));
	}
	public function thankyou($slug=null) {
		if($slug){
			$slugArr			=	explode('-',base64_decode($slug));
			$order_id		=	$slugArr[0];	
			$customer_id	=	$slugArr[1];	
		}	
		$event		=	$tickets		=	$products	=	'';
		$order 		= 	$this->Orders->find('all')->where( ['Orders.id' =>$order_id,'Orders.customer_id' =>$customer_id] )
										->first();
		if($order){								
			$event 		= 	$this->Events->find('all')->where( ['Events.id' =>$order->event_id] )
											->contain(['Uploads'])
											->first();	
			$tickets 		= 	$this->OrderItems->find('all')->where( ['OrderItems.order_id' =>$order_id,'OrderItems.item_type'=>'ticket'] )->contain(['Tickets'])->all();	
			$products 	= 	$this->OrderItems->find('all')->where( ['OrderItems.order_id' =>$order_id,'OrderItems.item_type'=>'product'] )->contain(['Products'])->all();								
			$programs 	= 	$this->OrderItems->find('all')->where( ['OrderItems.order_id' =>$order_id,'OrderItems.item_type'=>'program'] )->contain(['Programs'])->all();								
		}			
		$this->set(compact('order','event','tickets','products'));
		$this->set('title', 'Heritage Events - Thank you');
	}
	public function processpayment($slug=null) {
		$this->viewBuilder()->autoLayout('');
		if($slug){
			$slugArr			=	explode('-',base64_decode($slug));
			$order_id		=	$slugArr[0];	
			$customer_id	=	$slugArr[1];	
			$totalAmount	=	$this->Carts->getCartTotalAmount();
			$order 			= 	$this->Orders->find('all')->where( ['Orders.id' =>$order_id,'Orders.customer_id' =>$customer_id])->contain(['Customers'])->first();
			
			$data				=	array();
			$data['accId1']		=	'11111';
			$data['cartId']		=	base64_encode('front'.'-'.$customer_id.'-'.$order_id);
			$data['amount']		=	$totalAmount;
			if($order){
				//$data['name']		=	$order['customer']['first_name'].' '.$order['customer']['last_name'];
				$data['address1']	=	$order['address1'];
				$data['address2']	=	$order['address2'];
				$data['town']		=	$order['town'];
				$data['region']		=	$order['county'];
				$data['postcode']	=	$order['postcode'];
				$data['country']		=	$order['country'];
				$data['tel']			=	$order['customer']['contact_number'];
				$data['email']		=	$order['customer']['email'];
			}
			$this->set(compact('data'));
		}else{
			$this->autoRender 	= 	false;
		}	
	}
	public function orderresponse($slug=null) {
		$this->viewBuilder()->autoLayout('');
		if ($this->request->is('post')) {
			if ($this->request->data['transStatus'] == 'Y') {
				
				$order_status 	= 	'processing';
				$tnx_id 			= 	$this->request->data['transStatus'];
				$cartId_Arr		=	explode('-',base64_decode($this->request->data['cartId']));
				$location		=	$cartId_Arr[0];	
				$customer_id	=	$cartId_Arr[1];	
				$order_id		=	$cartId_Arr[2];	
				
				$query 			=	 $this->Orders->query();
				$query->update()  
					->set(['order_status' => $order_status,'tnx_id'=>$tnx_id])
					->where(['id' => $order_id])
					->execute();
					
				if($this->AbandonedCarts->readAbandonedCartID()){	
					$AbandonedCart 	= $this->AbandonedCarts->get($this->AbandonedCarts->readAbandonedCartID());
					if ($this->AbandonedCarts->delete($AbandonedCart)) {
						$this->AbandonedCarts->removeAbandonedCartID();
					}
				}
				$this->Carts->emptyCartData();
				$this->Carts->removeShippingData();
				$this->Carts->removeCouponData();
				$this->Orders->sendOrderEmail($order_id);
		               
				$this->set(compact('order_id','customer_id','location'));
				return $this->render('worldpay-success', false);
				
			}elseif ($this->request->data['transStatus'] == 'C') {
				return $this->render('worldpay-cancel', false);
			}
		}
		$this->autoRender 	= 	false;
	}
	public function ajaxprocesscheckout(){
		$this->viewBuilder()->autoLayout('');
		$this->autoRender 	= 	false;
		
		$response	=	$this->processcheckout(true);	
		echo json_encode($response);
		exit;	
	}
	public function processcheckout($is_ajax=false){
		$this->viewBuilder()->autoLayout('');
		$this->autoRender 	= 	false;
		$response			=	array();
		$this->loadComponent('Auth', ['authorize' => 'Controller','authenticate' => [
			'Form' => [
				'fields' => ['username' => 'email','password' => 'password'],
				'userModel' => 'Customers'
			]
		],
		'storage' => [
			'className' => 'Session',
			'key' => 'Auth.Customer',              
		]]);
		$response['status']		=	true;
			
		if ($this->request->is(['patch', 'post', 'put']) && $response['status']==true) {
			$email	=	$this->request->data['email'];
			if(!$this->Auth->user()){	
				if($this->Customers->getByEmailId($email)){
					$message	=	__("it's seems your email address already registered. Please <a href=\"javascript:void(0)\" class=\"showlogin\">click here</a> to login.");
					$response['message']	=	$message;
					$response['status']		=	false;
					$response['action']		=	'login';
				}else{
					$entity = $this->Customers->newEntity($this->request->data);
					$passkey = uniqid();
					$this->request->data['password'] 			= 	$passkey;
					$this->request->data['confirm_password'] 	= 	$passkey;
					$data = $this->Customers->patchEntity($entity, $this->request->data);
					if ($this->Customers->save($data)) {
						$user = $this->Auth->identify();
						if ($user) {
							$user_data	 =	 $this->Customers->get($user['id'])->toArray();
							$this->request->session()->write('name', $user_data['first_name'] .' '.$user_data['last_name']);
							$this->Customers->sendRegistrationEmail($user_data,$passkey);
							$this->Auth->setUser($user_data);
						}
						$customer_id	=	$user['id'];
						$response['customer_id']		=	$customer_id;
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
								$message	=	 __("Please fix the following error(s):\n".implode("<br />", $error_msg));
								$response['message']	=	$message;
								$response['status']		=	false;
							}
						}
					}
				}
			}else{
				$customer_id						=	$this->Auth->user('id');
				$customerData['title']				=	$this->request->data['title'];
				$customerData['first_name']			=	$this->request->data['first_name'];
				$customerData['last_name']			=	$this->request->data['last_name'];
				$customerData['address1']			=	$this->request->data['address1'];
				$customerData['address2']			=	$this->request->data['address2'];
				$customerData['town']				=	$this->request->data['town'];
				$customerData['county']				=	$this->request->data['county'];
				$customerData['country']				=	$this->request->data['country'];
				$customerData['postcode']			=	$this->request->data['postcode'];
				$customerData['contact_number']		=	$this->request->data['contact_number'];
				$Customer							= 	$this->Customers->get($customer_id);
				$customerData 						= 	$this->Customers->patchEntity($Customer, $customerData);
				$this->Customers->save($customerData);
				$response['customer_id']				=	$customer_id;
			}
			
			
			$carts = $this->Carts->readCartItem();
			if (null!=$carts && !isset($carts['tickets']) &&  count($carts['tickets']) < 1) {
				$this->Carts->emptyCartData();
				$messag	=	__("Your cart is empty. Please add at-least one ticket in your cart.");
				$response['message']	=	$message;
				$response['status']		=	false;
			}

			if($response['status']==true){
				/*if($this->request->data['hseoptin']=='y'){
					$email			=	$this->request->data['email'];
					$merge_vars	=	array(
											'fname' => $this->request->data['first_name'],
											'lname' => $this->request->data['last_name']
										);
					$this->Mailchimp->listSubscribe($email, $merge_vars);
				}*/
						
				$upcoming_event_id			=	$this->Events->getUpcomingEventID();
				$couponData				=	$this->Carts->readCouponData();
				$shippingData				=	$this->Carts->readShippingData();
				$abandonedCartID			=	$this->AbandonedCarts->readAbandonedCartID();
				if(!$abandonedCartID){
					$abandonedCartData['customer_id']		=	$customer_id;
					$abandonedCartData['event_id']			=	$upcoming_event_id;
					$abandonedCartData['cart_data']			=	serialize($carts) ;
					$abandonedCartData['coupon_data']		=	serialize($couponData);
					$abandonedCartData['shipping_data']		=	serialize($shippingData);
					$entity 			= 	$this->AbandonedCarts->newEntity();
					$data 			= 	$this->AbandonedCarts->patchEntity($entity, $abandonedCartData);
					if($abandonedResult	=	$this->AbandonedCarts->save($data)){
						$this->AbandonedCarts->saveAbandonedCartID($abandonedResult->id);
					}
				}else{
					$abandonedCartData['cart_data']			=	serialize($carts) ;
					$abandonedCartData['coupon_data']		=	serialize($couponData);
					$abandonedCartData['shipping_data']		=	serialize($shippingData);
					$AbandonedCart = $this->AbandonedCarts->get($abandonedCartID);
					$abandonedCartData 	= 	$this->AbandonedCarts->patchEntity($AbandonedCart, $abandonedCartData);
					$this->AbandonedCarts->save($abandonedCartData);
				}
				
				$ordersData->data['event_id']		=	$upcoming_event_id;
				$ordersData->data['customer_id']		=	$customer_id;
				$ordersData->data['address1']		=	$this->request->data['address1'];
				$ordersData->data['address2']		=	$this->request->data['address2'];
				$ordersData->data['town']			=	$this->request->data['town'];
				$ordersData->data['county']			=	$this->request->data['county'];
				$ordersData->data['country']			=	$this->request->data['country'];
				$ordersData->data['postcode']		=	$this->request->data['postcode'];
				$ordersData->data['payment_type']	=	'default';
				$ordersData->data['order_status'] 	= 	'pending';
				$ordersData->data['order_type'] 		= 	'online';
				$ordersData->data['admin_id'] 		= 	$customer_id;
				$ordersData->data['admin_role'] 		= 	'user';
				$ordersData->data['tnx_id'] 			= 	'HRE_'.time();		
				
				$subTotal			=	$this->Carts->getCartSubTotal();
				
				if(isset($couponData) && $couponData['couponStatus']==true && !empty($couponData['couponCode']) && $subTotal > 0){
					$coupon_code							=	$couponData['couponCode'];
					$ordersData->data['coupon_code']		=	$coupon_code;
					$totalDiscount							=	$this->Carts->getCouponDiscount($coupon_code);
					$ordersData->data['discount_amount']	=	$totalDiscount;
				}
				$shippingAmount		=	$this->Carts->getCartShippingAmount();
				$totalAmount			=	$this->Carts->getCartTotalAmount();
				$ordersData->data['subtotal_amount']		=	$subTotal;
				$ordersData->data['shipping_amount']	=	$shippingAmount;
				$ordersData->data['total_amount']		=	$totalAmount;
				if($shippingAmount > 0){
					$ordersData->data['is_shipping']		=	'y';
				}
				//pr($ordersData->data);exit;
				$entity 			= 	$this->Orders->newEntity();
				$data 			= 	$this->Orders->patchEntity($entity, $ordersData->data);
				if($orderResult	=	$this->Orders->save($data)){
					$response['order_id']	=	$orderResult->id;
					$this->OrderItems->saveOrderItems($orderResult->id);
					//$response['urlslug']	=	'thankyou/'.base64_encode($orderResult->id.'-'.$customer_id);
					$response['message']	=	__("Please wait..redirecting to payment gateway.");
					$response['urlslug']	=	'processpayment/'.base64_encode($orderResult->id.'-'.$customer_id);
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
								$error_msg[]    =   $key.' - '.$errors;
							}
						}
						if(!empty($error_msg)){
							$message	=	 __("Please fix the following error(s):\n".implode("<br />", $error_msg));
							$response['message']	=	$message;
							$response['status']		=	false;
						}
					}
				}
			}	
		}
		if($is_ajax==true){
			$response['id']	=	$this->Auth->user('id');
			return $response;
		}else{
			if($response['status']==false){
				$this->Flash->error($response['message']);
			}
		}
	}
	public function totals(){
		$this->viewBuilder()->autoLayout('');
		$this->Custom		 =	 new CustomHelper(new \Cake\View\View());
		$totalDiscount		=	$totalAfterDiscount	=	$shippingAmount	=	0;
		
		$subTotal			=	$this->Carts->getCartSubTotal();
		$couponData		=	$this->Carts->readCouponData();
		if(isset($couponData) && $couponData['couponStatus']==true && !empty($couponData['couponCode']) && $subTotal > 0){
			$coupon_code		=	$couponData['couponCode'];
			$totalDiscount		=	$this->Carts->getCouponDiscount($coupon_code);
		}
		$shippingAmount		=	$this->Carts->getCartShippingAmount();
		$totalAmount			=	$this->Carts->getCartTotalAmount();
		
		$this->set(compact('subTotal','totalDiscount','shippingAmount','totalAmount'));
	}
	public function addticket() {
		$this->autoRender = false;
		if ($this->request->is('post')) {
			$event_id				=	$this->Events->getUpcomingEventID();
			$ticket_id				=	base64_decode($this->request->data['ticket_id']);
			$totalRemainingQty		=	$this->ReserveTickets->getTotalTicketRemaining($event_id,$ticket_id);
			$allItems 				= 	$this->Carts->readCartItem();
			$requestQuantity		=	$this->request->data['quantity'];
			if(isset($allItems['tickets'])){
				if(isset($allItems['tickets'][$ticket_id]['qty'])){
					$requestQuantity	+=	$allItems['tickets'][$ticket_id]['qty'];
				}
			}	
			if($totalRemainingQty >= $requestQuantity){
				$this->Carts->addTicketToCart($ticket_id,$this->request->data['quantity'],$this->request->data);
				$this->Flash->success(__("Ticket(s) has been added in your cart."),['element' => 'success']);
			}else{
				$this->Flash->error(__("Sorry! only $totalRemainingQty ticket(s) left."),['element' => 'error']);
			}
		}
		$this->redirect(['controller'=>'pages', 'action' => 'index']);
	}
	public function addproduct() {
		$this->autoRender = false;
		if ($this->request->is('post')) {	
			$this->Carts->addProductToCart(base64_decode($this->request->data['product_id']),$this->request->data['quantity']);
			$this->Flash->success(__("Food(s) has been added in your cart."),['element' => 'success']);
		}
		$this->redirect(['controller'=>'pages', 'action' => 'index']);
	}
	public function addprogram() {
		$this->autoRender = false;
		if ($this->request->is('post')) {	
			$this->Carts->addProgramToCart(base64_decode($this->request->data['program_id']),$this->request->data['quantity']);
			$this->Flash->success(__("Programme(s) has been added in your cart."),['element' => 'success']);
		}
		$this->redirect(['controller'=>'pages', 'action' => 'index']);
	}
	public function ajaxupdatecartticket() {
		$this->autoRender = false;
		if ($this->request->is('post')) {	
			$event_id				=	$this->Events->getUpcomingEventID();
			$ticket_id				=	base64_decode($this->request->data['ticket_id']);
			$totalRemainingQty		=	$this->ReserveTickets->getTotalTicketRemaining($event_id,$ticket_id);
			$requestQuantity		=	$this->request->data['quantity'];
				
			if($totalRemainingQty >= $requestQuantity){
				$this->Carts->updateTicketToCart($ticket_id,$this->request->data['quantity']);
				$message		=	 __("Cart updated successfully.");
				$status			=	'success';
			}else{
				$message		=	__("Sorry! only $totalRemainingQty ticket(s) left.");
				$status			=	'error';
			}
		}
		$response	=	array();
		$response['cart_items']		=	$this->requestAction('/carts/cartitems');
		$response['cart_totals']		=	$this->requestAction('/carts/totals');
		$response['c_t']				=	base64_decode($this->request->data['ticket_id']);
		$response['message']		=	$message;
		$response['status']			=	$status;
		echo json_encode($response);
		exit;
	}
	public function ajaxupdatecartproduct() {
		$this->autoRender = false;
		if ($this->request->is('post')) {	
			$this->Carts->updateProductToCart(base64_decode($this->request->data['product_id']),$this->request->data['quantity']);
		}
		$response	=	array();
		$response['cart_items']		=	$this->requestAction('/carts/cartitems');
		$response['cart_totals']		=	$this->requestAction('/carts/totals');
		$response['c_p']				=	base64_decode($this->request->data['product_id']);
		$message					=	 __("Cart updated successfully.");
		$response['message']		=	$message;
		echo json_encode($response);
		exit;
	}
	public function ajaxupdatecartprogram() {
		$this->autoRender = false;
		if ($this->request->is('post')) {	
			$this->Carts->updateProgramToCart(base64_decode($this->request->data['program_id']),$this->request->data['quantity']);
		}
		$response	=	array();
		$response['cart_items']		=	$this->requestAction('/carts/cartitems');
		$response['cart_totals']		=	$this->requestAction('/carts/totals');
		$response['c_pp']				=	base64_decode($this->request->data['program_id']);
		$message					=	 __("Cart updated successfully.");
		$response['message']		=	$message;
		echo json_encode($response);
		exit;
	}
	public function removeItem($code=null) {
		$this->autoRender = false;
		if($code!=null) {	
			$carts 		= 	$this->Carts->readCartItem();
			$code		=	explode("||",base64_decode($code));
			$item_id	=	$code[1];
			$item_type	=	$code[0];
			if($item_type=='tickets' && $item_id){
				unset($carts['tickets'][$item_id]);
			}elseif($item_type=='products' && $item_id){
				unset($carts['products'][$item_id]);
			}elseif($item_type=='programs' && $item_id){
				unset($carts['programs'][$item_id]);
			}
			$this->Carts->saveCartItem($carts);
		}
		$this->redirect(['controller'=>'carts', 'action' => 'cart']);
	}
	public function removecoupon($coupon_code=null){
		$this->autoRender = false;	
		$this->viewBuilder()->autoLayout('');
		$this->Carts->removeCouponData();
		$response	=	array();
		$response['cart_totals']		=	$this->requestAction('/carts/totals');
		echo json_encode($response);
		exit;
	}	
	
	public function applycoupon($coupon_code=null){
		$this->autoRender = false;	
		$this->viewBuilder()->autoLayout('');
		$response			=	array();
		
		$response['status']	=	false;	
		$current_date		=	date("Y-m-d");	
		$Coupon 			=	$this->Coupons->find('all')->where(['Coupons.coupon_code'=>$coupon_code,'Coupons.expire_date >=' =>$current_date,'Coupons.status >='=>1])->first();
		$this->Carts->removeCouponData();
		$response['cart_totals']	=	$this->requestAction('/carts/totals');
		if($Coupon){
			$type				=	$Coupon->type;
			$totalDiscount		=	$this->Carts->getCouponDiscount($coupon_code);
			if($totalDiscount > 0){
				$couponData			=	$this->Carts->saveCouponData(array('couponStatus'=>true,'couponCode'=>$coupon_code));
				$response['message']	=	__("<strong>$coupon_code</strong> coupon code has been applied successfully.");
				$response['cart_totals']		=	$this->requestAction('/carts/totals');
				$response['status']		=	true;
			}else{
				if($type==1){
					$response['message']	=	__("Sorry! this <strong>$coupon_code</strong> coupon code is valid for ticket(s) only.");
					$response['status']		=	false;
				}elseif($type==2){
					$response['message']	=	__("Sorry! this <strong>$coupon_code</strong> coupon code is valid for food option(s) only.");
					$response['status']		=	false;
				}elseif($type==3){
					$response['message']	=	__("Sorry! this <strong>$coupon_code</strong> coupon code is valid for programme(s) only.");
					$response['status']		=	false;
				}elseif($type==4){
					$response['message']	=	__("Sorry! this  <strong>$coupon_code</strong> coupon code is valid for selected ticket(s) only.");
					$response['status']		=	false;
				}elseif($type==5){
					$response['message']	=	__("Sorry! this <strong>$coupon_code</strong> coupon code is valid for selected food option(s) only.");
					$response['status']		=	false;
				}elseif($type==6){
					$response['message']	=	__("Sorry! this <strong>$coupon_code</strong> coupon code is valid for selected programme(s) only.");
					$response['status']		=	false;
				}else{
					$response['message']	=	__("Sorry! this <strong>$coupon_code</strong> coupon code is not valid.");
					$response['status']		=	false;
				}
			}
		}else{
			if($coupon_code){
				$response['message']	=	__("<strong>$coupon_code</strong> coupon code is not valid.");
				$response['status']		=	false;
			}else{
				$response['message']	=	__("Please enter valid coupon code.");
				$response['status']		=	false;
			}
			
		}
		echo json_encode($response);
		exit;
	}
	public function applyshipping($val=null){
		$this->autoRender = false;	
		$this->viewBuilder()->autoLayout('');
		$response			=	array();
		if($val==1){
			$shippingData	=	$this->Carts->saveShippingData(array('shippingStatus'=>true));
		}else{
			$this->Carts->removeShippingData();
		}
		$response['cart_totals']		=	$this->requestAction('/carts/totals');
		echo json_encode($response);
		exit;
	}	
}