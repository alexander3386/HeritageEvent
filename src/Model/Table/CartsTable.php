<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Network\Session;
use Cake\Core\Configure;
use App\View\Helper\CustomHelper;
class CartsTable extends Table
{
	public function initialize(array $config)
	{
		parent::initialize($config);
		$this->setTable('carts');      
	}

	/*
	 * add a product to cart
	 */
	public function addTicketToCart($ticket_Id,$quantity=1,$data=array()) {
		$allItems 	= 	$this->readCartItem();
		if(isset($allItems['tickets']))
			$tickets		=	$allItems['tickets'];
		else
			$tickets		=	array();
		
		$quantity		=	(int)$quantity;
		if(!$quantity){
			$quantity	=	1;
		}
		$special_requirement	=	$special_description		=	'';
		if(isset($data['special_requirement']) && !empty($data['special_requirement'])){
			$special_requirement	=	$data['special_requirement'];
		}
		if(isset($data['special_description']) && !empty($data['special_description'])){
			$special_description	=	$data['special_description'];
		}
		if (null!=$tickets) {
			if (array_key_exists($ticket_Id, $tickets)) {
				$tickets[$ticket_Id]['qty']	=	$tickets[$ticket_Id]['qty']+$quantity;
			} else {
				$array				=	array();
				$array['qty']			=	$quantity;
				$array['special_requirement']	=	$special_requirement;
				$array['special_description']	=	$special_description;
				$tickets[$ticket_Id] 	= 	$array;
			}
			$allItems['tickets']		=	$tickets;
		} else {
			$array						=	array();
			$array['qty']					=	$quantity;
			$array['special_requirement']	=	$special_requirement;
			$array['special_description']	=	$special_description;
			$tickets[$ticket_Id] 	= 	$array;
			$allItems['tickets']		=	$tickets;
		}
		
		$this->saveCartItem($allItems);
	}
	public function addProductToCart($product_Id,$quantity=1) {
		$allItems 		= 	$this->readCartItem();
		if(isset($allItems['products']))
			$products		=	$allItems['products'];
		else
			$products		=	array();
		
		$quantity		=	(int)$quantity;
		if(!$quantity){
			$quantity	=	1;
		}
		if (null!=$products) {
			if (array_key_exists($product_Id, $products)) {
				$products[$product_Id]['qty']		=	$products[$product_Id]['qty']+$quantity;
			} else {
				$array					=	array();
				$array['qty']				=	$quantity;
				$products[$product_Id] 	= 	$array;
			}
			$allItems['products']		=	$products;
		} else {
			$array						=	array();
			$array['qty']					=	$quantity;
			$products[$product_Id] 		= 	$array;
			$allItems['products']			=	$products;
		}
		$this->saveCartItem($allItems);
	}
	public function addProgramToCart($program_Id,$quantity=1) {
		$allItems 		= 	$this->readCartItem();
		if(isset($allItems['programs']))
			$programs		=	$allItems['programs'];
		else
			$programs		=	array();
		
		$quantity		=	(int)$quantity;
		if(!$quantity){
			$quantity	=	1;
		}
		if (null!=$programs) {
			if (array_key_exists($program_Id, $programs)) {
				$programs[$program_Id]['qty']		=	$programs[$program_Id]['qty']+$quantity;
			} else {
				$array					=	array();
				$array['qty']				=	$quantity;
				$programs[$program_Id] 	= 	$array;
			}
			$allItems['programs']		=	$programs;
		} else {
			$array						=	array();
			$array['qty']					=	$quantity;
			$programs[$program_Id] 		= 	$array;
			$allItems['programs']			=	$programs;
		}
		$this->saveCartItem($allItems);
	}
	public function updateProductToCart($product_Id,$quantity=0) {
		$allItems 		= 	$this->readCartItem();
		if(isset($allItems['products']))
			$products		=	$allItems['products'];
		else
			$products		=	array();
		
		$quantity		=	(int)$quantity;
		if(!$quantity){
			$quantity	=	0;
		}
		if (null!=$products) {
			if($quantity > 0){
				if (array_key_exists($product_Id, $products)) {
					$products[$product_Id]['qty']		=	$quantity;
				}else{
					$array					=	array();
					$array['qty']				=	$quantity;
					$products[$product_Id] 	= 	$array;
				}
			}else{
				unset($products[$product_Id]['qty']);
			}
			$allItems['products']		=	$products;
		}else{
			if($quantity > 0){
				$array						=	array();
				$array['qty']					=	$quantity;
				$products[$product_Id] 		= 	$array;
				$allItems['products']			=	$products;
			}
		} 
		$this->saveCartItem($allItems);
	}
	
	public function updateProgramToCart($program_Id,$quantity=0) {
		$allItems 		= 	$this->readCartItem();
		if(isset($allItems['programs']))
			$programs		=	$allItems['programs'];
		else
			$programs		=	array();
		
		$quantity		=	(int)$quantity;
		if(!$quantity){
			$quantity	=	0;
		}
		if (null!=$programs) {
			if($quantity > 0){
				if (array_key_exists($program_Id, $programs)) {
					$programs[$program_Id]['qty']		=	$quantity;
				}else{
					$array					=	array();
					$array['qty']				=	$quantity;
					$programs[$program_Id] 	= 	$array;
				}
			}else{
				unset($programs[$program_Id]['qty']);
			}
			$allItems['programs']		=	$programs;
		}else{
			if($quantity > 0){
				$array						=	array();
				$array['qty']					=	$quantity;
				$programs[$program_Id] 	= 	$array;
				$allItems['programs']			=	$programs;
			}
		} 
		$this->saveCartItem($allItems);
	}
	public function updateTicketToCart($ticket_Id,$quantity=0) {
		$allItems 		= 	$this->readCartItem();
		if(isset($allItems['tickets']))
			$tickets		=	$allItems['tickets'];
		else
			$tickets		=	array();
		
		$quantity		=	(int)$quantity;
		if(!$quantity){
			$quantity	=	0;
		}
		if (null!=$tickets) {
			if($quantity > 0){
				$tickets[$ticket_Id]['qty']		=	$quantity;
			}else{
				unset($tickets[$ticket_Id]['qty']);
			}
			$allItems['tickets']		=	$tickets;
		} 
		$this->saveCartItem($allItems);
	}
	/*
	 * get total count of products
	 */
	public function getCount() {
		$allItems = $this->readCartItem();
		if (count($allItems) < 1) {
			return 0;
		}
		$count = 0;
		if(isset($allItems['tickets']) && count($allItems['tickets']) > 0){
			foreach ($allItems['tickets'] as $item) {
				$count	=	$count+1;
			}
		}
		if(isset($allItems['products']) && count($allItems['products']) > 0){
			foreach ($allItems['products'] as $item) {
				$count	=	$count	+ 1;
			}
		}
		if(isset($allItems['programs']) && count($allItems['programs']) > 0){
			foreach ($allItems['programs'] as $item) {
				$count	=	$count	+ 1;
			}
		}
		return $count;
	}
	/*
	 * get total count of products
	 */
	public function getCartSubTotal() {
		$carts = $this->readCartItem();
		if (count($carts) < 1) {
			return 0;
		}
		
		$this->Tickets 	= 	TableRegistry::get('Tickets');
		$this->Products 	= 	TableRegistry::get('Products');
		$this->Programs 	= 	TableRegistry::get('Programs');
		$this->Custom	 = new CustomHelper(new \Cake\View\View());
		
		$cart_sub_total	=	0;
		$tickets 			= 	array();
		$products 		= 	array();
		if (null!=$carts) {
			if(isset($carts['tickets']) && count($carts['tickets']) > 0){
				$ticketSubTotal		=	$this->getTicketSubTotal($carts['tickets']);
				$cart_sub_total		=	$cart_sub_total+$ticketSubTotal;
			}
			if(isset($carts['products']) && count($carts['products']) > 0){
				$productSubTotal		=	$this->getProductSubTotal($carts['products']);
				$cart_sub_total			=	$cart_sub_total+$productSubTotal;
			}
			if(isset($carts['programs']) && count($carts['programs']) > 0){
				$programSubTotal		=	$this->getProgramSubTotal($carts['programs']);
				$cart_sub_total			=	$cart_sub_total+$programSubTotal;
			}
		}
		return $cart_sub_total;
	}
	public function getTicketSubTotal($tickets=array()){
		$this->Tickets 	= 	TableRegistry::get('Tickets');
		$this->Custom	 = new CustomHelper(new \Cake\View\View());
		$cart_sub_total		=	0;
		if($tickets){
			foreach ($tickets as $id => $array) {
				$ticket 				= 	$this->Tickets->get($id);
				$ticket['qty'] 		= 	$array['qty'];
				$ticket_price			=	 $this->Custom->applyAddtionalPrice($ticket['id'],$ticket['price'],$ticket['qty']);
				$total_price				=	($ticket_price*$ticket['qty']);
				$discount_item_total_price	=	 $this->Custom->applyDiscountPrice($ticket['id'],$total_price,$ticket['qty']);
				
				$cart_sub_total		=	$cart_sub_total+$discount_item_total_price;
			}
		}
		return $cart_sub_total;
	}
	public function getSelectedTicketSubTotal($tickets=array(),$ticket_ids=array()){
		$this->Tickets 	= 	TableRegistry::get('Tickets');
		$this->Custom	 = new CustomHelper(new \Cake\View\View());
		$cart_sub_total		=	0;
		if($tickets){
			foreach ($tickets as $id => $array) {
				if(@in_array($id,$ticket_ids)){
					$ticket 				= 	$this->Tickets->get($id);
					$ticket['qty'] 		= 	$array['qty'];
					$ticket_price			=	 $this->Custom->applyAddtionalPrice($ticket['id'],$ticket['price'],$ticket['qty']);
					$total_price				=	($ticket_price*$ticket['qty']);
					$discount_item_total_price	=	 $this->Custom->applyDiscountPrice($ticket['id'],$total_price,$ticket['qty']);
					$cart_sub_total		=	$cart_sub_total+$discount_item_total_price;
				}
			}
		}
		return $cart_sub_total;
	}
	
	public function getProductSubTotal($products=array()){
		$this->Products 	= 	TableRegistry::get('Products');
		$this->Custom	 =	 new CustomHelper(new \Cake\View\View());
		$cart_sub_total		=	0;
		if($products){
			foreach ($products as $id => $array) {
				$product 			= 	$this->Products->get($id);
				$product['qty'] 		= 	$array['qty'];
				$item_total_price	=	$product['qty']*$product['price'];
				$cart_sub_total		=	$cart_sub_total+$item_total_price;
			}
		}
		return $cart_sub_total;
	}
	public function getSelectedProductSubTotal($products=array(),$product_ids=array()){
		$this->Products 	= 	TableRegistry::get('Products');
		$this->Custom	 =	 new CustomHelper(new \Cake\View\View());
		$cart_sub_total		=	0;
		if($products){
			foreach ($products as $id => $array) {
				if(@in_array($id,$product_ids)){
					$product 			= 	$this->Products->get($id);
					$product['qty'] 		= 	$array['qty'];
					$item_total_price	=	$product['qty']*$product['price'];
					$cart_sub_total		=	$cart_sub_total+$item_total_price;
				}
			}
		}
		return $cart_sub_total;
	}
	public function getProgramSubTotal($programs=array()){
		$this->Programs 	= 	TableRegistry::get('Programs');
		$this->Custom	 =	 new CustomHelper(new \Cake\View\View());
		$cart_sub_total		=	0;
		if($programs){
			foreach ($programs as $id => $array) {
				$program 			= 	$this->Programs->get($id);
				$program['qty'] 		= 	$array['qty'];
				$item_total_price	=	$program['qty']*$program['price'];
				$cart_sub_total		=	$cart_sub_total+$item_total_price;
			}
		}
		return $cart_sub_total;
	}
	public function getSelectedProgramSubTotal($programs=array(),$program_ids=array()){
		$this->Programs 	= 	TableRegistry::get('Programs');
		$this->Custom	 =	 new CustomHelper(new \Cake\View\View());
		$cart_sub_total		=	0;
		if($programs){
			foreach ($programs as $id => $array) {
				if(@in_array($id,$program_ids)){
					$program 			= 	$this->Programs->get($id);
					$program['qty'] 		= 	$array['qty'];
					$item_total_price	=	$program['qty']*$program['price'];
					$cart_sub_total		=	$cart_sub_total+$item_total_price;
				}
			}
		}
		return $cart_sub_total;
	}
	public function getCouponDiscount($coupon_code=null){
		$this->Coupons 	= 	TableRegistry::get('Coupons');
		$totalDiscount	=	0;
		$subTotal		=	$this->getCartSubTotal();
		if($coupon_code){
			$current_date		=	date("Y-m-d");
			$Coupon 			=	$this->Coupons->find('all')->where(['Coupons.coupon_code'=>$coupon_code,'Coupons.expire_date >=' =>$current_date,'Coupons.status >='=>1])->first();
			$carts				= 	$this->readCartItem();
			if($Coupon && $carts!=null){
				$type				=	$Coupon->type;
				$discount_price		=	$Coupon->discount_price;
				$discount_type		=	$Coupon->discount_type;
				$discountApplicableAmount	=	0;
				if($type==1){
					if(null!=$carts && isset($carts['tickets'])){
						$ticketSubTotal				=	$this->getTicketSubTotal($carts['tickets']);
						$discountApplicableAmount	=	$ticketSubTotal;
					}
				}elseif($type==2){
					if(null!=$carts && isset($carts['products'])){
						$productSubTotal		=	$this->getProductSubTotal($carts['products']);
						$discountApplicableAmount	=	$productSubTotal;
					}
				}elseif($type==3){
					if(null!=$carts && isset($carts['programs'])){
						$programSubTotal			=	$this->getProgramSubTotal($carts['programs']);
						$discountApplicableAmount	=	$programSubTotal;
					}
				}elseif($type==4){
					$ticket_ids				=	@unserialize($Coupon->ticket_ids);
					if(null!=$carts && isset($carts['tickets']) && count($ticket_ids) > 0){
						$selectedTicketSubTotal		=	$this->getSelectedTicketSubTotal($carts['tickets'],$ticket_ids);
						$discountApplicableAmount	=	$selectedTicketSubTotal;
					}
				}elseif($type==5){
					$product_ids				=	@unserialize($Coupon->product_ids);
					if(null!=$carts && isset($carts['products']) && count($product_ids) > 0 ){
						$selectedProductSubTotal		=	$this->getSelectedProductSubTotal($carts['products'],$product_ids);
						$discountApplicableAmount		=	$selectedProductSubTotal;
					}
				}elseif($type==6){
					$program_ids				=	@unserialize($Coupon->program_ids);
					if(null!=$carts && isset($carts['programs']) && count($program_ids) > 0 ){
						$selectedProgramSubTotal		=	$this->getSelectedProgramSubTotal($carts['programs'],$program_ids);
						$discountApplicableAmount		=	$selectedProgramSubTotal;
					}
				}else{
					$discountApplicableAmount	=	$subTotal;
				}
				
				if($discountApplicableAmount > 0){
					if($discount_type==1){
						$totalDiscount			=	($discountApplicableAmount*$discount_price)/100;
					}else{
						$totalDiscount			=	$discountApplicableAmount - $discount_price;
					}
					if($totalDiscount < 0){
						$totalDiscount		=	0;
					}
					return $totalDiscount;
				}
			}
		}
		return $totalDiscount;
	}
	public function getCartShippingAmount(){
		$this->Custom	 		=	 new CustomHelper(new \Cake\View\View());
		$shippingAmount		=	0;
		$subTotal				=	$this->getCartSubTotal();
		$DefaultSettings			=	$this->Custom->getDefaultSettings();
		$shippingData			=	$this->readShippingData();
		if($DefaultSettings && $DefaultSettings['is_shipping']==1 && $subTotal > 0 && $shippingData['shippingStatus']==true){
			$shippingAmount			=		(double)$DefaultSettings['shipping_price'];
		}
		return $shippingAmount;
	}
	public function getCartTotalAmount(){
		$totalDiscount		=	$totalAfterDiscount	=	$shippingAmount	=	$totalAmount	=	0;
		$subTotal			=	$this->getCartSubTotal();
		$couponData		=	$this->readCouponData();
		if(isset($couponData) && $couponData['couponStatus']==true && !empty($couponData['couponCode']) && $subTotal > 0){
			$coupon_code		=	$couponData['couponCode'];
			$totalDiscount		=	$this->getCouponDiscount($coupon_code);
		}
		$shippingAmount		=	$this->getCartShippingAmount();
		$totalAmount			=	$subTotal - $totalDiscount+$shippingAmount;
		return $totalAmount;
	}
	/*
	 * save data to session
	 */
	public function saveCartItem($data) {
		if(isset($data['tickets']) && count($data['tickets']) < 1){
			unset($data['tickets']);
		}
		if(isset($data['products']) && count($data['products']) < 1){
			unset($data['products']);
		}
		if(isset($data['programs']) && count($data['programs']) < 1){
			unset($data['programs']);
		}
		$session = new Session();
		return $session->write('cart',$data);
	}
	/*
	 * read cart data from session
	 */
	public function readCartItem() {
		$session = new Session();
		return $session->read('cart');
	}
	/*
	 * remove cart data from session
	 */
	public function emptyCartData() {
		$session = new Session();
		return $session->delete('cart');
	}
	/*
	 * save cart coupon to session
	 */
	public function saveCouponData($data) {
		$session = new Session();
		return $session->write('couponData',$data);
	}
	/*
	 * read cart coupon from session
	 */
	public function readCouponData() {
		$session = new Session();
		return $session->read('couponData');
	}
	/*
	 * delete cart coupon from session
	 */
	public function removeCouponData() {
		$session = new Session();
		return $session->delete('couponData');
	}
	/*
	 * save cart shipping to session
	 */
	public function saveShippingData($data) {
		$session = new Session();
		return $session->write('shippingData',$data);
	}
	/*
	 * read cart shipping from session
	 */
	public function readShippingData() {
		$session = new Session();
		return $session->read('shippingData');
	}
	/*
	 * delete cart shipping from session
	 */
	public function removeShippingData() {
		$session = new Session();
		return $session->delete('shippingData');
	}
}
