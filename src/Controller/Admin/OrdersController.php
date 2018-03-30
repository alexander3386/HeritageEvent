<?php

namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use CakePdf\Pdf\CakePdf;
//use Cake\Core\App;
use App\View\Helper\BarcodeHelper;
use App\View\Helper\CustomHelper;
/**
 * Reservtickets Controller
 *
 * @property \App\Model\Table\ReserveTicketsTable $reserve_tickets
 */
class OrdersController extends AppController
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
		$this->loadModel("Customers");
		$this->loadModel("OrderItems");
		$this->loadModel("Events");
		$this->loadModel("DefaultSettings");
		$this->loadModel('Carts');
		$this->loadModel('Tickets');
		$this->loadModel('Products');
		$this->loadComponent('Worldpay');
		$this->loadModel('Programs');
    }
	/**
		* Index method
		*
		* @return \Cake\Network\Response|null
	*/
	public function index()
	{
	
		$entity 						= $this->Orders->newEntity();
		$orders 						= $this->Orders->newEntity();
		$conditionsArr 					= [];
		$searchQuery 					= $this->Orders->find('all', ['contain' => ['Customers','Events']]);
		$conditionsArr[] 		= ['Orders.order_status !=' => 'pending'];	
			
		if ($this->request->is(['get','put'])) {
			$this->request->data 		= $this->request->query;
			if(!empty($this->request->data['search_keyword']))
			{
				$search_keyword	=	$this->request->data['search_keyword'];
				$conditionsCUST = [];
				$conditionsCUST['OR'][] = ['Customers.first_name LIKE' => $search_keyword."%"];
				$conditionsCUST['OR'][] = ['Customers.last_name LIKE' =>  $search_keyword."%"];
				$conditionsCUST['OR'][] = ['Customers.postcode LIKE' =>  "%".$search_keyword."%"];
				$conditionsCUST['OR'][] = ['Customers.contact_number LIKE' =>  "%".$search_keyword."%"];
				
				$all_cust = $this->Customers->find('all', array('conditions'=>$conditionsCUST,'fields'=>array('id')));
				//pr($all_cust);
				$conditionsArr[] 		= ['Orders.customer_id IN' => $all_cust];
			
			}
			if(!empty($this->request->data['event_id'])){
				

				$conditionsArr[] 		= ['Orders.event_id' => $this->request->data['event_id']];
			}
			if(isset($this->request->data['status']) && $this->request->data['status']!='A'){
			$conditionsArr[] 			= ['Orders.order_status' => $this->request->data['status']];
			}
			if(isset($this->request->data['order_type']) && $this->request->data['order_type']!='A'){
			$conditionsArr[] 			= ['Orders.order_type' => $this->request->data['order_type']];
			}
			//pr($conditionsArr);die;
			$searchQuery 	= $searchQuery->where([$conditionsArr]);
		}
		
		$orders = $this->paginate($searchQuery);
		
		$event		 	= 	TableRegistry::get('Events');
		$event_arr 	 	= 	$event->getEventArray();
		
		$tickets		= 	TableRegistry::get('Tickets');
		$ticket_arr 	= 	$tickets->getTicketArray();

		$products		= 	TableRegistry::get('Products');
		$products_arr 	= 	$products->getProductArray();

		$this->set(compact('orders','event_arr','ticket_arr','products_arr'));
		$this->set('title', 'Manage Orders');
		$this->set('form', $entity);
	}
    
    public function add()
	{
		$entity = $this->Orders->newEntity($this->request->data);
        $role = $this->Auth->user('role');
        $id = $this->Auth->user('id');
       	if ($this->request->is('post')) {
       		$email = $this->request->data['email'];
           	$customer_id = $this->Customers->getByEmailId($email);
           	$this->request->data['customer_type'];
           	if($customer_id > 0 && $this->request->data['customer_type'] == 'new')
			{
				$this->Flash->error( __("Email Id is already in use"));
				return $this->redirect(['action' => 'add']);
			}
			else{
           	
           		$this->Orders->saveOrderData($this->request);
           		return $this->redirect(['action' => 'cart']);
           	}
        }

	 	$id		=	$this->Events->getUpcomingEventID();
		$event 	= 	$this->Events->find('all')->where( ['Events.id' =>$id] )->contain(['Uploads', 'Tickets', 'Products', 'Programs'])->first();
		$this->set(compact('event'));
		$this->set('form', $entity);
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
		$orders = $this->Orders->get($id);
		if ($this->Orders->delete($orders)) {
			$this->Flash->success(__('Order deleted successfully.'));
		} else {
			$this->Flash->error(__('Order could not be deleted. Please, try again.'));
		}
		return $this->redirect(['action' => 'index']);
	}    
	public function updatestatus() {
		if ($this->request->is(['ajax'])) {
			$status 	= 	$this->request->data['status_val'];
			$orders 	= 	explode(',',$this->request->data['sele_orders']);
			//pr($orders);//die;
			for($i= 0; $i < count($orders); $i++)
			{
				$query 		=	$this->Orders->query();
				$query->update()  
					->set(['order_status' => $status])
					->where(['id' => $orders[$i]])
					->execute();
				
			}
			$sta = array('status'=>'true',"order_status"=>ucfirst($status));
			echo json_encode($sta);
			exit();
			
		}
	}
	
	/**************add to cart ************************/
	public function cart() {
		
		$entity 	= $this->Orders->newEntity();
		
		$id		=	$this->Events->getUpcomingEventID();
		$event 	= 	$this->Events->find('all')->where( ['Events.id' =>$id] )
										->contain(['Uploads', 'Tickets', 'Products', 'Programs'])
										->first();
		
		$carts = $this->Carts->readCartItem();
		$tickets 		= 	array();
		$programs 	= 	array();
		if (null!=$carts) {
			if(isset($carts['tickets'])){
				$tickets 		=	$carts['tickets'];
			}
			if(isset($carts['programs']) && count($carts['programs']) > 0){
				$programs 		=	$carts['programs'];
			}
		}
		
		$this->set('title', 'Heritage Events');
		$this->set(compact('event','tickets','carts','programs'));
		$this->set('form',$entity);
		
	}
	public function cartitems(){
		$this->viewBuilder()->autoLayout('');
		$carts = $this->Carts->readCartItem();
		$tickets 	= 	array();
		$products 	= 	array();
		$programs 	= 	array();
		if (null!=$carts) {
			if(isset($carts['tickets'])){
				foreach ($carts['tickets'] as $id => $array) {
					$ticket 			= 	$this->Tickets->get($id);
					$ticket['qty'] 		= 	$array['qty'];
					$tickets[]			=	$ticket;
				}
			}
			if(isset($carts['products'])){
				foreach ($carts['products'] as $id => $array) {
					$product 			= 	$this->Products->get($id);
					$product['qty'] 	= 	$array['qty'];
					$products[]			=	$product;
				}
			}
			if(isset($carts['programs'])){
				foreach ($carts['programs'] as $id => $array) {
					$program 			= 	$this->Programs->get($id);
					$program['qty'] 	= 	$array['qty'];
					$programs[]			=	$program;
				}
			}
		}
		$this->set('form');
		$settings 	= 	$this->DefaultSettings->get(1);
		
		$this->set(compact('products','tickets','carts','settings','programs'));
	}
	public function totals(){
		$this->viewBuilder()->autoLayout('');
		$this->Custom			=	 new CustomHelper(new \Cake\View\View());
		$totalDiscount			=	$totalAfterDiscount	=	$shippingAmount	=	0;
		
		$subTotal				=	$this->Carts->getCartSubTotal();
		$couponData				=	$this->Carts->readCouponData();
		if(isset($couponData) && $couponData['couponStatus']==true && !empty($couponData['couponCode']) && $subTotal > 0){
			$coupon_code		=	$couponData['couponCode'];
			$totalDiscount		=	$this->Carts->getCouponDiscount($coupon_code);
		}
		$shippingAmount			=	$this->Carts->getCartShippingAmount();
		$totalAmount			=	$this->Carts->getCartTotalAmount();
		
		$this->set(compact('subTotal','totalDiscount','shippingAmount','totalAmount'));
	}
	public function addticket() {
		if ($this->request->is(['ajax']))
		{	
			$ticket_id 	= $this->request->data['ticket_id'];
			$quantity 	= $this->request->data['quantity'];
			$this->Carts->addTicketToCart(base64_decode($ticket_id),$quantity);
		}
		$count = $this->Carts->getCount();
		$sta = array('status'=>'true',"cart_count"=>$count);
		echo json_encode($sta);
		exit();
	}
	public function addproduct() {
		if ($this->request->is(['ajax'])) {	
			$product_id 	= $this->request->data['product_id'];
			$quantity 	= $this->request->data['quantity'];
			$this->Carts->addProductToCart(base64_decode($product_id),$quantity);
		}
		$count = $this->Carts->getCount();
		$sta = array('status'=>'true',"cart_count"=>$count);
		echo json_encode($sta);
		exit();
	}
	public function addprogram() {
		if ($this->request->is(['ajax'])) {	
			$program_id 	= $this->request->data['program_id'];
			$quantity 	= $this->request->data['quantity'];
			
			$this->Carts->addProgramToCart(base64_decode($program_id),$quantity);
		}
		$count = $this->Carts->getCount();
		$sta = array('status'=>'true',"cart_count"=>$count);
		echo json_encode($sta);
		exit();
	}
	public function ajaxupdatecartproduct() {
		$this->autoRender = false;
		if ($this->request->is('post')) {	
			$this->Carts->updateProductToCart(base64_decode($this->request->data['product_id']),$this->request->data['quantity']);
		}
		$response	=	array();
		$response['cart_items']		=	$this->requestAction('/admin/orders/cartitems');
		$response['cart_totals']		=	$this->requestAction('/admin/orders/totals');
		echo json_encode($response);
		exit;
	}
	public function ajaxupdatecartticket() {
		$this->autoRender = false;
		if ($this->request->is('post')) {	
			$this->Carts->updateTicketToCart(base64_decode($this->request->data['ticket_id']),$this->request->data['quantity']);
		}
		$response	=	array();
		$response['cart_items']		=	$this->requestAction('/admin/orders/cartitems');
		$response['cart_totals']		=	$this->requestAction('/admin/orders/totals');
		echo json_encode($response);
		exit;
	}
	public function ajaxupdatecartprogram() {
		$this->autoRender = false;
		if ($this->request->is('post')) {	
			$this->Carts->updateProgramToCart(base64_decode($this->request->data['program_id']),$this->request->data['quantity']);
		}
		$response	=	array();
		$response['cart_items']		=	$this->requestAction('/admin/orders/cartitems');
		$response['cart_totals']		=	$this->requestAction('/admin/orders/totals');
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
			}
			elseif($item_type=='programs' && $item_id){
				unset($carts['programs'][$item_id]);
			}
			$this->Carts->saveCartItem($carts);
		}
		$this->redirect(['action' => 'cart']);
	}
	public function removecoupon($coupon_code=null){
		$this->autoRender = false;	
		$this->viewBuilder()->autoLayout('');
		$this->Carts->removeCouponData();
		$response	=	array();
		$response['cart_totals']		=	$this->requestAction('/admin/orders/totals');
		echo json_encode($response);
		exit;
	}	
	
	public function applycoupon($coupon_code=null){
		$this->autoRender = false;	
		$this->viewBuilder()->autoLayout('');
		$response			=	array();
		$this->loadModel('Coupons');
		
		$response['status']	=	false;	
		$current_date		=	date("Y-m-d");	
		$Coupon 			=	$this->Coupons->find('all')->where(['Coupons.coupon_code'=>$coupon_code,'Coupons.expire_date >=' =>$current_date,'Coupons.status >='=>1])->first();
		$this->Carts->removeCouponData();
		$response['cart_totals']	=	$this->requestAction('/admin/orders/totals');
		if($Coupon){
			$type				=	$Coupon->type;
			$totalDiscount		=	$this->Carts->getCouponDiscount($coupon_code);
			if($totalDiscount > 0){
				$couponData			=	$this->Carts->saveCouponData(array('couponStatus'=>true,'couponCode'=>$coupon_code));
				$response['message']	=	__("<strong>$coupon_code</strong> coupon code has been applied successfully.");
				$response['cart_totals']		=	$this->requestAction('/admin/orders/totals');
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
			$response['message']	=	__("<strong>$coupon_code</strong> coupon code is not valid.");
			$response['status']		=	false;
		}
		echo json_encode($response);
		exit;
	}
	public function clearcart()
	{
		$carts 		= 	$this->Carts->emptyCartData();
		$count = $this->Carts->getCount();
		if($count == 0)
		{
			$this->Flash->success(__('Cart item cleared successfully'));
            return $this->redirect(['action' => 'add']);
		}
		else
		{
			$this->Flash->success(__('Unable to clear cart item'));
            return $this->redirect(['action' => 'add']);
		}
	}

	public function proceedtocheckout()
	{
		if ($this->request->is(['patch', 'post', 'put']) )
		{
			$this->autoRender 	= false;	
			$this->viewBuilder()->autoLayout('');
			$ordersData 		= $this->Orders->readOrderData();
			$customer_id 		= $this->Customers->getByEmailId($ordersData->data['email']);
			if($customer_id > 0 && $ordersData->data['customer_type'] == 'new')
			{
				$this->Flash->error( __("Email Id already exists"));
				return $this->redirect(['action' => 'add']);
			}
			else
			{
				$role = $this->Auth->user('role');
	        	$user_id = $this->Auth->user('id');
	        
				
				$totalDiscount = $totalAfterDiscount= $shippingAmount	=	0;
				$subTotal							= $this->Carts->getCartSubTotal();
				$couponData							= $this->Carts->readCouponData();
				if(isset($couponData) && $couponData['couponStatus']==true && !empty($couponData['couponCode']) && $subTotal > 0)
				{
					$coupon_code					= $couponData['couponCode'];
					$totalDiscount					= $this->Carts->getCouponDiscount($coupon_code);
				}
				$shippingAmount						= $this->Carts->getCartShippingAmount();	
				$totalAmount						= $this->Carts->getCartTotalAmount();
				
				$couponData							= $this->Carts->readCouponData();
				if($couponData['couponStatus']){
					$ordersUpdate['coupon_code'] 	= $couponData['couponCode'];

				}
				$ordersData->data['shipping_amount'] 	= $shippingAmount;
				$ordersData->data['subtotal_amount'] 	= $subTotal;
				$ordersData->data['discount_amount'] 	= $totalDiscount;
			
				$ordersData->data['total_amount'] 	= $totalAmount;//die;
				
				if($shippingAmount > 0){
					$ordersData->data['is_shipping']	= 'y';
				}
				$ordersData->data['payment_type'] 	= $this->request->data['payment_type'];
				
				$orderResult	= $this->Orders->createNewOrder($ordersData,$role,$user_id);
		  
				if ($orderResult['id']>0) 
				{	
					
					//code to save order items
					$saveOrderHistory	= $this->OrderItems->saveOrderItems($orderResult['id']);
					
					if($this->request->data['payment_type'] == 'heritage_worldpay')
					{
						
						$response['urlslug']	=	base64_encode($orderResult->id.'-'.$customer_id);
						
						$this->redirect(["action" => "processpayment","slug" => $response['urlslug']]);
					}
					elseif($this->request->data['payment_type'] == 'override')
					{
						
						$ordersUpdate['order_status'] 		= 'processing';
						
						$updateorderdetails 	= $this->Orders->updateOrderDetails($orderResult['id'],$ordersUpdate);
						$sendOrderEmail 		= $this->Orders->sendOrderEmail($orderResult['id']);
		                if($sendOrderEmail)
		                {
		                	$this->Carts->emptyCartData();
		                	$this->Flash->success(__('Orders has been created successfully.'));
		                	return $this->redirect(['action' => 'index']);
		                }
		                else
		                {
		                	$this->Flash->error(__('Error sending email: ') . $sendOrderEmail->smtpError);
		                }
			            
					}
				}
		        else
		        {
		        	pr($ordersData);die;
				
		        	if($orderResult->errors()){
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
		        
		    }
		}
	}
	
	/**
     * print invoice method
     * @access Public
     * @param string|null .
     * @return \Cake\Network\Response|null send reset password email to the user.
     */    
	public function printInvoice($type,$id) {
		
		
		if($type == 'view')
		{
			$data = $this->Orders->printInvoice($type,$id);

			$products 		= $data['products'];
			$tickets 		= $data['tickets'];
			$programs 		= $data['programs'];
			$totalAmount 	= $data['totalAmount'];
			$subTotal 		= $data['subTotal'];
			$totalDiscount 	= $data['totalDiscount'];
			$shippingAmount = $data['shippingAmount'];
			$eventname		= $data['eventname'];
			$barcode 		= $data['barcode'];
			$company_add 	= $data['company_add'];
			$company_num 	= $data['company_num'];
			$company_cont 	= $data['company_cont'];
			$company_vat 	= $data['company_vat'];
			$settings 		= $data['settings'];
			$this->set(compact('products','tickets','totalAmount','subTotal','totalDiscount','shippingAmount','eventname','barcode','company_add','company_num','company_cont','company_vat','settings','programs'));
			
			$pdf_name 	= time().'_invoice.pdf';
	        $this->viewBuilder()->layout('default');
			$this->viewBuilder()->options([
				'pdfConfig' => [
				    'orientation' => 'portrait',
				    'filename' => $pdf_name
				]
			]);
			$this->RequestHandler->renderAs($this, 'pdf', ['attachment' => $pdf_name]);
		
		}
		else
		{
			$location = $this->Orders->printInvoice($type,$id);
			return 	$location;
		}
		
	}
	 /**
     * print ticket method
     * @access Public
     * @param string|null .
     * @return \Cake\Network\Response|null send reset password email to the user.
     */    
	public function printTicket($type,$id) {
		
		if($type == 'view')
		{
			$data = $this->Orders->printTicket($type,$id);
			$tickets 		= $data['tickets'];
			$totalAmount 	= $data['totalAmount'];
			$subTotal 		= $data['subTotal'];
			$totalDiscount 	= $data['totalDiscount'];
			$shippingAmount = $data['shippingAmount'];
			$eventname		= $data['eventname'];
			$eventdate		= $data['eventdate'];
			$barcode 		= $data['barcode'];
			$company_add 	= $data['company_add'];
			$company_num 	= $data['company_num'];
			$company_cont 	= $data['company_cont'];
			$company_vat 	= $data['company_vat'];
			$settings 		= $data['settings'];
			$order 			= $data['order'];
			$customername 	= $order['customers']['title'].' '.$order['customers']['first_name'].' '.$order['customers']['last_name'];

			$this->Custom			=	 new CustomHelper(new \Cake\View\View());
			$customeradd 	= $order['address1'].'<br>'.$order['address2'].'<br>'.$order['county'].'<br>'.$this->Custom->displayCountryName($order['country']).'<br>'.$order['postcode'].'<br>';
			
			$this->set(compact('tickets','totalAmount','subTotal','totalDiscount','shippingAmount','eventname','barcode','company_add','company_num','company_cont','company_vat','settings','eventdate','customername','customeradd'));
    	
	    	$pdf_name 	= time().'_ticket.pdf';
	        $this->viewBuilder()->layout('default');
			$this->viewBuilder()->options([
				'pdfConfig' => [
				    'orientation' => 'portrait',
				    'filename' => $pdf_name
				]
			]);
			$this->RequestHandler->renderAs($this, 'pdf', ['attachment' => $pdf_name]);
   		}
   		else
		{
			$location = $this->Orders->printTicket($type,$id);
			return 	$location;
		}
	}
	public function orderdetails($orderid=null)
	{
		if($orderid!=null)
		{
			$order = $this->Orders->getOrder($orderid);
		
			$event = $this->Events->getUpcomingEvent();
		
			$tickets = $this->OrderItems->getTicketsItem($orderid);
		
			$products = $this->OrderItems->getProductItem($orderid);
			$programs = $this->OrderItems->getProgramItem($orderid);

			$this->set(compact('order','event','tickets','products','programs'));
		}
		else
		{
			return $this->redirect(['action' => 'index']);
		}
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
		$response['cart_totals']		=	$this->requestAction('/admin/orders/totals');
		echo json_encode($response);
		exit;
	}
	
	public function processpayment($slug=null) {
		$this->viewBuilder()->autoLayout('');
		//pr($this->request);die;
		$slug = $this->request->query['slug'];
		if($slug){
			$slugArr		=	explode('-',base64_decode($slug));
			$order_id		=	$slugArr[0];	
			$customer_id	=	$slugArr[1];	
			$totalAmount	=	$this->Carts->getCartTotalAmount();
			$order 			= 	$this->Orders->find('all')->where( ['Orders.id' =>$order_id,'Orders.customer_id' =>$customer_id])->contain(['Customers'])->first();
			
			$data				=	array();
			$data['accId1']		=	'11111';
			$data['cartId']		=	base64_encode('backend'.'-'.$customer_id.'-'.$order_id);
			$data['amount']		=	$totalAmount;
			if($order){
				//$data['name']		=	$order['customer']['first_name'].' '.$order['customer']['last_name'];
				$data['address1']	=	$order['address1'];
				$data['address2']	=	$order['address2'];
				$data['town']		=	$order['town'];
				$data['region']		=	$order['county'];
				$data['postcode']	=	$order['postcode'];
				$data['country']	=	$order['country'];
				$data['tel']		=	$order['customer']['contact_number'];
				$data['email']		=	$order['customer']['email'];
			}
			$this->set(compact('data'));
		}else{
			$this->autoRender 	= 	false;
		}	
	}
	
}
