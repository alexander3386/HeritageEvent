<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use App\View\Helper\BarcodeHelper;
use App\View\Helper\CustomHelper;
use Cake\Mailer\Email;
use CakePdf\Pdf\CakePdf;

class OrdersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
	public function initialize(array $config)
	{
		parent::initialize($config);
		$this->table('orders');
		$this->displayField('id');
		$this->primaryKey('id');
		$this->addBehavior('Timestamp');
		$this->belongsTo('customers');
		$this->belongsTo('events');
		$this->hasMany('OrderItems', [
			'foreignKey' => 'order_id',
			'dependent' => true
		]);
		
		
		$this->Carts 			= 	TableRegistry::get('Carts');
		$this->OrderItems 	= 	TableRegistry::get('OrderItems');
		$this->Products 		= 	TableRegistry::get('Products');
		$this->Programs 		= 	TableRegistry::get('Programs');
		$this->Customers 	= 	TableRegistry::get('Customers');
		$this->DefaultSettings 	= 	TableRegistry::get('DefaultSettings');
		$this->Tickets 			= 	TableRegistry::get('Tickets');
		$this->Events 			= 	TableRegistry::get('Events');
		

	}
    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
	public function validationDefault(Validator $validator)
	{
		$validator
		    ->integer('id')
		    ->allowEmpty('id', 'create');
		
		$validator
		    ->requirePresence('customer_id', 'create')
		    ->notEmpty('numberof_tickets');
		
		
		$validator
		    ->requirePresence('address1', 'create')
		    ->notEmpty('address1');
		
		$validator
		    ->requirePresence('address2', 'create')
		    ->notEmpty('address2');
		
		$validator
		    ->requirePresence('town', 'create')
		    ->notEmpty('town');
		
		$validator
		    ->requirePresence('county', 'create')
		    ->notEmpty('county');
		
		$validator
		    ->requirePresence('country', 'create')
		    ->notEmpty('country');
		
		$validator
		    ->requirePresence('postcode', 'create')
		    ->notEmpty('postcode');
		
		$validator
		    ->requirePresence('order_type', 'create')
		    ->notEmpty('order_type');

		$validator
		    ->requirePresence('tnx_id', 'create')
		    ->notEmpty('tnx_id');
		
		$validator
		    ->requirePresence('order_status', 'create')
		    ->notEmpty('order_status');

		$validator
		    ->requirePresence('admin_id', 'create')
		    ->notEmpty('admin_id');
		    
		$validator
		    ->requirePresence('admin_role', 'create')
		    ->notEmpty('admin_role');
		
		// $validator
		//     ->requirePresence('barcode', 'create')
		//     ->notEmpty('barcode');
		    
		return $validator;
	}
	/*
	 * save order to session
	 */
	public function saveOrderData($data) {
		$session = new Session();
		return $session->write('orderData',$data);
	}
	/*
	 * read order to session
	 */
	public function readOrderData() {
		$session = new Session();
		return $session->read('orderData');
	}
	/*
	 * read order to session
	 */
	public function removeOrderData() {
		$session = new Session();
		return $session->delete('orderData');
	}

	public function createNewOrder($ordersData,$role,$id){
		$entity = $this->newEntity();
		$ordersData->data['admin_role'] 			= $role;
		$ordersData->data['admin_id'] 			= $id;

		$ordersData->data['order_status'] 		= 'pending';
		$ordersData->data['tnx_id'] 				= 'HRE_'.time();
		//If customer is new data will be instert into customerss
		if(isset($ordersData->data['customer_type']) && $ordersData->data['customer_type'] == 'new')
		{
			if( $ordersData->data['password_type'] == 'auto' && $ordersData->data['password'] == '')
			{
				$passkey = uniqid();
				$ordersData->data['password'] = $passkey;
				$ordersData->data['confirm_password'] = $passkey;
			}
			
			$ordersData->data['status'] = 1;
			$ordersData->data['hseoptin'] = 'n';
			$ordersData->data['hostoptin'] = 'y';

			$cus_entity = $this->Customers->newEntity($ordersData->data);
			$cust_data = $this->Customers->patchEntity($cus_entity, $ordersData->data);
			$result= $this->Customers->save($cust_data);
			if ($result['id'] > 0) {	
				$ordersData->data['customer_id'] = $result['id'];
			}
        	
			if($cust_data->errors()){
				$error_msg = [];
				foreach( $cust_data->errors() as $errors){
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
		else
		{
			$customer 		= $this->Customers->find('all')->where( ['Customers.email' =>$ordersData->data['email']] )->first();
			if(!empty($customer))
			{
				$ordersData->data['customer_id'] = $customer['id'];
			}
		}	
		
		$data 				= $this->patchEntity($entity, $ordersData->data);
		$orderResult 		= $this->save($data);
		return $orderResult;

	}
	public function updateOrderDetails($order_id,$ordersUpdate)
	{
		//code to update order details
		$orderDetails 						= $this->get($order_id);
		$updatedData 						= $this->patchEntity($orderDetails, $ordersUpdate);
		$orderResult 						= $this->save($updatedData);
		return $orderResult;
	}
	 /**
     * send order email method
     * @access public
     * @param string|null .
     * @return \Cake\Network\Response|null send reset password email to the user.
     */    
	public function sendOrderEmail($orderid) {
		$order 			=	 $this->getOrder($orderid);
		$event 			= 	$this->Events->getUpcomingEvent();
		$tickets 			= 	$this->OrderItems->getTicketsItem($orderid);
		$products 		= 	$this->OrderItems->getProductItem($orderid);
		$programs 		= 	$this->OrderItems->getProgramItem($orderid);

		$name 				= $order['title']." ".$order['first_name']." ".$order['last_name'];
		$emailadd 			= $order['customers']['email'];	
		
		$id 				= $order['customer_id'];		
		$email 				= new Email();
		$email->template('orderemail');
		$email->emailFormat('both');
		$email->from(FROM_EMAIL);
		$email->to($emailadd);
		$email->subject('Thank you for your purchase from Heritage Special Events');
		$this->Custom		=	 new CustomHelper(new \Cake\View\View());
		$totalDiscount		=	$totalAfterDiscount	=	$shippingAmount	=	0;
		
		$totalAmount 		= 	$order['total_amount'];
		$subTotal 			= 	$order['subtotal_amount'];
		$totalDiscount 		= 	$order['discount_amount'];
		$shippingAmount 	= 	$order['shipping_amount'];
		$eventname 		=	 $event['title'];
		$email->viewVars(['event'=>$eventname,'products'=>$products,'programs'=>$programs,'tickets'=>$tickets, 'name' => $name,'totalAmount' =>$totalAmount,'totalDiscount'=>$totalDiscount,'subTotal'=>$subTotal,'shippingAmount'=>$shippingAmount]);
		
		//$this->set(compact('event','products','tickets','orders','name','totalAmount','subTotal','totalDiscount','shippingAmount'));die;
		$type = "attached";

		$invoice = $this->printInvoice($type,$orderid);
		$tickets = $this->printTicket($type,$orderid);
		if(file_exists($invoice))
		{
			$email->attachments(array($invoice,$tickets));
		}
		if ($email->send()) {
			return true;
		} else {
			return $email;
			$this->Flash->error(__('Error sending email: ') . $email->smtpError);
		}
	
		
	}
	/**
     * print invoice method
     * @access Public
     * @param string|null .
     * @return \Cake\Network\Response|null send reset password email to the user.
     */    
	public function printInvoice($type,$id) {
		$order 			= 	$this->getOrder($id);
		$event 			= 	$this->Events->getUpcomingEvent();
		$tickets 		= 	$this->OrderItems->getTicketsItem($id);
		$products 		= 	$this->OrderItems->getProductItem($id);
		$programs 		= 	$this->OrderItems->getProgramItem($id);
		$barcode 		= 	$this->generateBarCode($order['tnx_id'],$id);
		
		$pdf_name 		= 	$id.'_HRE_invoice.pdf';
		$location 		= 	WWW_ROOT.'uploads/invoice/'.$pdf_name;
		
		$totalAmount 	= 	$order['total_amount'];
		$subTotal 		= 	$order['subtotal_amount'];
		$totalDiscount 	= 	$order['discount_amount'];
		$shippingAmount = 	$order['shipping_amount'];
		$eventname 	= 	$event['title'];
		//settings
		$settings 		= $this->DefaultSettings->getDefaultSettings();
		
		$company_add 	= $settings->company_address;
		$company_num 	= $settings->company_number;
		$company_cont 	= $settings->contact_number;
		$company_vat 	= $settings->vat_number;

		$vars = ['products'=>$products,'tickets'=>$tickets,'totalAmount'=>$totalAmount,'subTotal'=>$subTotal,'totalDiscount'=>$totalDiscount,'shippingAmount'=>$shippingAmount,'eventname'=>$eventname,'barcode'=>$barcode,'company_add'=>$company_add,'company_num'=>$company_num,'company_cont'=>$company_cont,'company_vat'=>$company_vat,'settings'=>$settings,'programs'=>$programs];
		if($type == 'view')
		{
			return $viewVars = $vars;
		}
		else
		{
			if(!file_exists($location))	
			{
				$CakePdf = new \CakePdf\Pdf\CakePdf();
				$CakePdf->template('print_invoice', 'default');
				$CakePdf->viewVars($vars);
				$pdf = $CakePdf->output();
				$pdf = $CakePdf->write(WWW_ROOT . 'uploads' . DS. 'invoice' . DS . $pdf_name);
			}
			return 	$location;
		}
		
	}
	/**
     * print invoice method
     * @access Public
     * @param string|null .
     * @return \Cake\Network\Response|null send reset password email to the user.
     */    
	public function printTicket($type,$id) {
		$order 			= 	$this->getOrder($id);
		$event 			= 	$this->Events->getUpcomingEvent();
		$tickets 			= 	$this->OrderItems->getTicketsItem($id);
		$barcode 		= 	$this->generateBarCode($order['tnx_id'],$id);
		
		$pdf_name 		= $id.'_HRE_ticket.pdf';
		$location 		= WWW_ROOT.'uploads/invoice/'.$pdf_name;
		
		$totalAmount 		= 	$order['total_amount'];
		$subTotal 			= 	$order['subtotal_amount'];
		$totalDiscount 		= 	$order['discount_amount'];
		$shippingAmount	= 	$order['shipping_amount'];
		
		$eventname 	= 	$event['title'];
		$eventdate 		= 	$event['date_time'];
		//settings
		$settings 		= 	$this->DefaultSettings->getDefaultSettings();
		
		$company_add 	= 	$settings->company_address;
		$company_num 	= 	$settings->company_number;
		$company_cont 	= 	$settings->contact_number;
		$company_vat 	= 	$settings->vat_number;

		$vars = ['tickets'=>$tickets,'totalAmount'=>$totalAmount,'subTotal'=>$subTotal,'totalDiscount'=>$totalDiscount,'shippingAmount'=>$shippingAmount,'eventname'=>$eventname,'barcode'=>$barcode,'company_add'=>$company_add,'company_num'=>$company_num,'company_cont'=>$company_cont,'company_vat'=>$company_vat,'settings'=>$settings,'eventdate'=>$eventdate,'order'=>$order];

		if($type == 'view')
		{
			return $viewVars = $vars;
		}else
		{
			if(!file_exists($location))	
			{
				$CakePdf = new \CakePdf\Pdf\CakePdf();
				$CakePdf->template('print_ticket', 'default');
				$CakePdf->viewVars($vars);
				$pdf = $CakePdf->output();
				$pdf = $CakePdf->write(WWW_ROOT . 'uploads' . DS. 'invoice' . DS . $pdf_name);
			}
			return 	$location;
		}
	}

	public function generateBarCode($name,$id)
	{
		$file = 'uploads/barcode/'.$id.'_HRE_barcode.png';
		if(!file_exists($file)){
			$data_to_encode = $name.'-'.time().'-'.$id;
			$this->Barcode	 = new BarcodeHelper(new \Cake\View\View());       
			// Generate Barcode data
			$this->Barcode->barcode();
			$this->Barcode->setType('C128');
			$this->Barcode->setCode($data_to_encode);
			$this->Barcode->setSize(80,200);
			    
			// Generate filename            
			$random = rand(0,1000000);
			$file = 'uploads/barcode/'.$id.'_HRE_barcode.png';
			    
			// Generates image file on server            
			$this->Barcode->writeBarcodeFile($file);

		}
		
		return $file;
	}

	public function getOrder($orderid)
	{
		$order = $this->find('all')->where( ['Orders.id' =>$orderid] )->contain(['Customers', 'OrderItems'])->first();
		return $order;
	}

	public function getOnlineAllocatedTickets()
	{
		$find_online_allocation = $this->find('all', ['contain' => ['OrderItems']])->where(['Orders.order_type'=>'online'])->all();

		$total = 0;
		$data = $find_online_allocation->toArray();
		foreach($data as $items)
		{
			foreach($items['order_items'] as $or_items)
			{
				if($or_items['item_type'] == 'ticket')
				{
					$total+= $or_items['item_quantity'];
				}
			}
			
		}
		return $total;

	}
	public function getOfflineAllocatedTickets()
	{
		$find_offline_allocation = $this->find('all', ['contain' => ['OrderItems']])->where(['Orders.order_type'=>'telephone'])->all();

		$total = 0;
		$data = $find_offline_allocation->toArray();
		foreach($data as $items)
		{
			foreach($items['order_items'] as $or_items)
			{
				if($or_items['item_type'] == 'ticket')
				{
					$total+= $or_items['item_quantity'];
				}
			}
			
		}
		return $total;

	}
	
}
