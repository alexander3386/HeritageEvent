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
use App\View\Helper\CsvHelper;

use App\Database\Expression\BetweenComparison;
use Cake\Database\Expression\IdentifierExpression;

/**
 * Reporting Controller
 *
 * @property \App\Model\Table\ReserveTicketsTable $reserve_tickets
 */
class ReportsController extends AppController
{
   public $paginate = [
		'maxLimit' => 1,
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
		$this->loadModel("Orders");
		$this->loadModel("Customers");
		$this->loadModel("OrderItems");
		$this->loadModel("Events");
		$this->loadModel("DefaultSettings");
		$this->loadModel('Carts');
		$this->loadModel('Tickets');
		$this->loadModel('Products');
		$this->loadComponent('Worldpay');
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
		$conditionsArr[] 		= ['Orders.order_status !=' => 'pending'];	
		
		$searchQuery 					= $this->Orders->find('all', ['contain' => ['Customers','Events','OrderItems']]);
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
			if(!empty($this->request->data['from_date'])){
				
				$from_date 		= $this->request->data['from_date'];
				$from_date 		= $this->convertDateToDBFormat($from_date).' '.'00:00:01';
				
				$conditionsArr[] 		= ['Orders.created >=' => $from_date];
			}
			else if(!empty($this->request->data['from_date']) && !empty($this->request->data['to_date'])){
				
				$from_date 		= $this->request->data['from_date'];
				$to_date 		= $this->request->data['to_date'];
				$from_date 		= $this->convertDateToDBFormat($from_date).' '.'00:00:01';
				$to_date 		= $this->convertDateToDBFormat($to_date).' '.'23:59:59';
				
				$searchQuery 	= 	$searchQuery->where(function($exp) use($from_date,$to_date) {
                                return $exp->between('DATE(Orders.created)', $from_date, $to_date, 'date');
				});
			
				$searchQuery 	= $searchQuery->andWhere([$conditionsArr]);
			
			}
			
			$searchQuery 	= $searchQuery->where([$conditionsArr]);
			
			if(isset($_GET['download_orders']))
			{
				$orders = $this->exportOrdersCsv($searchQuery);
			}

		}
		
		$orders = $this->paginate($searchQuery);
			
		$event		 	= 	TableRegistry::get('Events');
		$event_arr 	 	= 	$event->getEventArray();
		
		$this->set(compact('orders','event_arr'));
		$this->set('title', 'Manage Orders');
		$this->set('form', $entity);
	}
    private function exportorderscsv($query=null)
    {
    
		$this->Custom			=	 new CustomHelper(new \Cake\View\View());
		$dataArr = $query->toArray();
		//pr($dataArr);die;
		$data = [];
		$_serialize ='data';
		$_header 	= ['Order Id','Transaction Id','Event Name', 'Title','Firstname','Lastname','Address1','Address2','Town','County','Country','Postcode','Subtotal Amount','Shipping Amount','Discount Amount', 'Total Amount','Order Status','Shipping Applied','Coupon Applied','Order Date'];
		$k = 20;
		$maxcount= 0;
		foreach($dataArr as $head)
		{
			if(count($head['order_items']) > $maxcount){
				$maxcount = count($head['order_items']);
			}
		}
		for($i =0; $i < $maxcount;$i++)
		{
			$_header[$k] = 'Item name';
			$k++;
			$_header[$k] = 'Item Quantity';
			$k++;
			
		}
		array_push($data, $_header);	
		foreach($dataArr as $items)
		{
			$d_arr[0] 	= $items['id'];
			$d_arr[1] 	= $items['tnx_id'];
			$d_arr[2] 	= $items['events']['title'];
			$d_arr[3] 	= ($items['customers']['title']!='')?$items['customers']['title']:'-';
			$d_arr[4] 	= ($items['customers']['first_name']!='')?$items['customers']['first_name']:'-';
			$d_arr[5] 	= ($items['customers']['last_name']!='')?$items['customers']['last_name']:'-';
			$d_arr[6] 	= ($items['address1']!='')?ucfirst($items['address1']):'-';
			$d_arr[7] 	= ($items['address2']!='')?ucfirst($items['address2']):'-';
			$d_arr[8] 	= ($items['town']!='')?ucfirst($items['town']):'-';
			$d_arr[9] 	= ($items['county']!='')?ucfirst($items['county']):'-';
			$d_arr[10] 	= ($items['country']!='')?$this->Custom->displayCountryName($items['country']):'-';
			$d_arr[11] 	= ($items['postcode']!='')?$items['postcode']:'-';
			
			$d_arr[12] 	= $items['subtotal_amount'];
			$d_arr[13] 	= $items['shipping_amount'];
			$d_arr[14] 	= $items['discount_amount'];
			$d_arr[15] 	= $items['total_amount'];
			$d_arr[16] 	= ucfirst($items['order_status']);
			$d_arr[17] 	= ($items['is_shipping']=='y')?'Yes':'No';
			$d_arr[18] 	= ($items['coupon_code']!='')?$items['coupon_code']:'-';
			$d_arr[19] 	= $this->Custom->displayDateFormat($items['created']);
			$j = 20;
			if(count($items['order_items']) > 0){
				
				for($i = 0; $i <count($items['order_items']);$i++)
				{
					$d_arr[$j] = $items['order_items'][$i]['item_name'];
					$j++;
					$d_arr[$j] = $items['order_items'][$i]['item_quantity'];
					$j++;
					
				}
			}

			array_push($data, $d_arr);
		}
		$filename='HRE_Order_Report_'.time().'.csv';
 		$this->export($filename,$data,$_serialize);
	}
   	public function customerReport(){
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
			if(!empty($this->request->data['from_date'])){
				
				$from_date 		= $this->request->data['from_date'];
				$from_date 		= $this->convertDateToDBFormat($from_date).' '.'00:00:01';
				
				$conditionsArr[] 		= ['Customers.created >=' => $from_date];
			}
			else if(!empty($this->request->data['from_date']) && !empty($this->request->data['to_date'])){
				
				$from_date 		= $this->request->data['from_date'];
				$to_date 		= $this->request->data['to_date'];
				$from_date 		= $this->convertDateToDBFormat($from_date).' '.'00:00:01';
				$to_date 		= $this->convertDateToDBFormat($to_date).' '.'23:59:59';
				
				$searchQuery 	= 	$searchQuery->where(function($exp) use($from_date,$to_date) {
                                return $exp->between('DATE(Customers.created)', $from_date, $to_date, 'date');
				});
			
				$searchQuery 	= $searchQuery->andWhere([$conditionsArr]);
			
			}
			
			$searchQuery 	= $searchQuery->where([$conditionsArr]);
			if(isset($_GET['download_customer']))
			{
				$orders = $this->exportcustomercsv($searchQuery);
			}
		}
		$customers = $this->paginate($searchQuery);
		$this->set(compact('customers'));
		$this->set('form', $entity);
   	}
   	private function exportcustomercsv($query=null)
    {
    	$dataArr = $query->toArray();
		$data = [];
		$_serialize 	='data';
		$_header 		= ['Title','Firstname','Lastname','Email','Address1','Address2','Town','County','Country','Postcode', 'Contact Number','Status'];
		$this->Custom 	=	 new CustomHelper(new \Cake\View\View());
		
		array_push($data, $_header);	
		foreach($dataArr as $items)
		{
			$d_arr[0] 	= ($items['title']!='')?$items['title']:'-';
			$d_arr[1] 	= ($items['first_name']!='')?$items['first_name']:'-';
			$d_arr[2] 	= ($items['last_name']!='')?$items['last_name']:'-';
			$d_arr[3] 	= ($items['email']!='')?$items['email']:'-';
			$d_arr[4] 	= ($items['address1']!='')?ucfirst($items['address1']):'-';
			$d_arr[5] 	= ($items['address2']!='')?ucfirst($items['address2']):'-';
			$d_arr[6] 	= ($items['town']!='')?ucfirst($items['town']):'-';
			$d_arr[7] 	= ($items['county']!='')?ucfirst($items['county']):'-';
			$d_arr[8] 	= ($items['country']!='')?$this->Custom->displayCountryName($items['country']):'-';
			$d_arr[9] 	= ($items['postcode']!='')?$items['postcode']:'-';
			
			$d_arr[10] 	= ($items['contact_number']!='')?$items['contact_number']:'-';
			$d_arr[11] 	= ($items['status']==1)?'Active':'Inactive';
			array_push($data, $d_arr);
		}
		$filename='HRE_Customer_Report_'.time().'.csv';
		$this->export($filename,$data,$_serialize);
	}
   	private function export($filename,$data,$_serialize)
   	{
   		$this->set(compact('data', '_serialize'));
		$this->response->download($filename);
		$this->viewBuilder()->className('CsvView.Csv');
   	}
	public function getcustomercount()
	{
		$filter 			= $this->request->data['filter'];
		$customerCount		= [];	
		for($i = 6;$i >= 0; $i--)
		{
			if($filter == "week")
			{
				$from = $i;
				$to = $i+1;
				$for = 'week';
			}
			elseif($filter == "month")
			{
				$from = $i;
				$to = $i+1;
				$for = 'month';
			}
			elseif($filter == "year")
			{
				$from = $i;
				$to = $i+1;
				$for = 'year';
			}
			else
			{
				$from = $i;
				$to = $i+1;
				$for = 'days';
			}
			
			$from_date 		= DATE('Y-m-d',strtotime('-'.$from.$for));
			
			$to_date 		= DATE('Y-m-d',strtotime('-'.$to.$for));
			
			$conOnCust 			= [];
			$conOnCust[] 		= ['Customers.status'=>'1'];
		
			$searchQueryCust = $this->Customers->find('all');
			
			$searchQueryCust 			= 	$searchQueryCust->where(function($exp) use($from_date,$to_date) {
                            return $exp->between('DATE(Customers.created)', $to_date, $from_date, 'date');
			});
			$searchQueryCust 	= $searchQueryCust->andWhere([$conOnCust])->count();
			array_push($customerCount, $searchQueryCust);
		}
		$response  =  array();
		$response['data']  =  $customerCount;
		
		echo json_encode($response);
		exit;
	}
	public function getonlineordercount()
	{
		$filter 			= $this->request->data['filter'];
		$customerCount		= [];	
		for($i = 6;$i >= 0; $i--)
		{
			if($filter == "week")
			{
				$from = $i;
				$to = $i+1;
				$for = 'week';
			}
			elseif($filter == "month")
			{
				$from = $i;
				$to = $i+1;
				$for = 'month';
			}
			elseif($filter == "year")
			{
				$from = $i;
				$to = $i+1;
				$for = 'year';
			}
			else
			{
				$from = $i;
				$to = $i+1;
				$for = 'days';
			}
			
			$from_date 		= DATE('Y-m-d',strtotime('-'.$from.$for));
			
			$to_date 		= DATE('Y-m-d',strtotime('-'.$to.$for));
			
			$conOnCust 			= [];
			$conOnCust[] 		= ['Orders.order_type'=>'online','Orders.order_status !='=>'pending'];
		
			$searchQueryCust = $this->Orders->find('all');
			
			$searchQueryCust 			= 	$searchQueryCust->where(function($exp) use($from_date,$to_date) {
                            return $exp->between('DATE(Orders.created)', $to_date, $from_date, 'date');
			});
			$searchQueryCust 	= $searchQueryCust->andWhere([$conOnCust])->count();
			array_push($customerCount, $searchQueryCust);
		}
		$response  =  array();
		$response['data']  =  $customerCount;
		
		echo json_encode($response);
		exit;
	}
	public function gettelephoneordercount()
	{
		$filter 			= $this->request->data['filter'];
		$customerCount		= [];	
		for($i = 6;$i >= 0; $i--)
		{
			if($filter == "week")
			{
				$from = $i;
				$to = $i+1;
				$for = 'week';
			}
			elseif($filter == "month")
			{
				$from = $i;
				$to = $i+1;
				$for = 'month';
			}
			elseif($filter == "year")
			{
				$from = $i;
				$to = $i+1;
				$for = 'year';
			}
			else
			{
				$from = $i;
				$to = $i+1;
				$for = 'days';
			}
			
			$from_date 		= DATE('Y-m-d',strtotime('-'.$from.$for));
			
			$to_date 		= DATE('Y-m-d',strtotime('-'.$to.$for));
			
			$conOnCust 			= [];
			$conOnCust[] 		= ['Orders.order_type'=>'telephone','Orders.order_status !='=>'pending'];
		
			$searchQueryCust = $this->Orders->find('all');
			
			$searchQueryCust 			= 	$searchQueryCust->where(function($exp) use($from_date,$to_date) {
                            return $exp->between('DATE(Orders.created)', $to_date, $from_date, 'date');
			});
			$searchQueryCust 	= $searchQueryCust->andWhere([$conOnCust])->count();
			array_push($customerCount, $searchQueryCust);
		}
		$response  =  array();
		$response['data']  =  $customerCount;
		
		echo json_encode($response);
		exit;
	}
	public function getcustomertotal()
	{
		$searchQueryCust = $this->Customers->find('all')->where(['status'=>'1'])->count();
		echo $searchQueryCust;
		exit;
	}
	public function getofflineordrtotal()
	{
		$searchQueryCust = $this->Orders->find('all')->where(['order_status !='=>'pending','order_type'=>'telephone'])->count();
		echo $searchQueryCust;
		exit;
	}
	public function getonlineordrtotal()
	{
		$searchQueryCust = $this->Orders->find('all')->where(['order_status !='=>'pending','order_type'=>'online'])->count();
		echo $searchQueryCust;
		exit;
	}
	public function getordrtotal()
	{
		$searchQueryCust = $this->Orders->find('all')->where(['order_status !='=>'pending'])->count();
		echo $searchQueryCust;
		exit;
	}
	public function comparebothorder()
	{
		$filter 			= $this->request->data['filter'];
		$orderCount =[];
		$i =1;
		if($filter == "week")
		{
			$for = 'week';
		}
		elseif($filter == "month")
		{
			$for = 'month';
		}
		elseif($filter == "year")
		{
			$for = 'year';
		}
		else
		{
			$for = 'days';
		}
		
		$from_date 		= DATE('Y-m-d');
		
		$to_date 		= DATE('Y-m-d',strtotime('-1'.$for));
		
		$conOn 			= [];
		$conOn[] 		= ['Orders.order_type'=>'online','Orders.order_status !='=>'pending'];

		$conTel 			= [];
		$conTell[] 		= ['Orders.order_type'=>'telephone','Orders.order_status !='=>'pending'];

		$searchQueryOn = $this->Orders->find('all');
		
		$searchQueryCust 			= 	$searchQueryOn->where(function($exp) use($from_date,$to_date) {
                        return $exp->between('DATE(Orders.created)', $to_date, $from_date, 'date');
		});
		$searchQueryCust 	= $searchQueryCust->andWhere([$conOn])->count();

		array_push($orderCount, $searchQueryCust);
		$searchQueryTel = $this->Orders->find('all');
		
		$searchQueryCust 			= 	$searchQueryTel->where(function($exp) use($from_date,$to_date) {
                        return $exp->between('DATE(Orders.created)', $to_date, $from_date, 'date');
		});
		$searchQueryTel 	= $searchQueryTel->andWhere([$conTell])->count();

		array_push($orderCount, $searchQueryTel);
		$response  =  array();
		$response['data']  =  $orderCount;
		
		echo json_encode($response);
		exit;
	}
}
