<?php 
	namespace App\View\Helper;
	use Cake\View\Helper;
	use Cake\ORM\TableRegistry;
	use App\Database\Expression\BetweenComparison;
	use Cake\Database\Expression\IdentifierExpression;
	class CustomHelper extends Helper {
		public function displayDateFormat($datetime=null) {
			if($datetime==null || $datetime=='0000-00-00 00:00:00' || $datetime=='')
				return;	
			return date('l dS F Y', strtotime($datetime));
		}
		public function inputDateTimeFormat($datetime=null) {
			if($datetime==null || $datetime=='0000-00-00 00:00:00' || $datetime=='')
				return;	
			return date('d/m/Y H:i:s', strtotime($datetime));
		}
		public function inputDateFormat($date=null) {
			if($date==null || $date=='0000-00-00' || $date=='')
				return;	
			return date('d/m/Y', strtotime($date));
		}
		public function displayPriceHtml($price=0.00){
			setlocale(LC_MONETARY, 'en_GB');
			$price	 =	money_format('%!i', $price);
			return CURRENCY_SYMBOL.$price;	
		}
		public function displayPrice($price=0.00){
			setlocale(LC_MONETARY, 'en_GB');
			$price	 =	money_format('%!i', $price);
			return $price;	
		}
		public function getCouponTypeArray(){
			$options = ['0' => 'Total Cart Item(s)', '1' => 'All Tickets only','2'=>'All Products only','3'=>'All Programs only', '4' => 'Selected Tickets only','5'=>'Selected Products only','6'=>'Selected Programs only'];	
			return $options;
		}	
		public function displayCouponType($key=0){
			$options	=	$this->getCouponTypeArray();
			return $options[$key];	
		}
		public function getCutomerTitleArray(){
			$options = ['Mr' => 'Mr', 'Mrs' => 'Mrs','Ms'=>'Ms', 'Miss' => 'Miss','Dr'=>'Dr', 'Prof' => 'Prof','Other'=>'Other'];	
			return $options;
		}	
		public function displayCutomerTitle($key=0){
			$options	=	$this->getCutomerTitleArray();
			return $options[$key];	
		}
		public function getSpecialRequirementArray(){
			$options = ['wheelchair' => 'WHEELCHAIR USER', 'aisleseat' => 'AISLE SEAT','other'=>'Other'];	
			return $options;
		}	
		public function displaySpecialRequirementTitle($key=0){
			$options	=	$this->getSpecialRequirementArray();
			return $options[$key];	
		}
		public function getCountriesArray(){
			$countries	=	[
						'GB' => 'United Kingdom',	
						'AL' => 'Albania',
						'AT' => 'Austria',
						'AU' => 'Australia',
						'BE' => 'Belgium',
						'HR' => 'Croatia',
						'CY' => 'Cyprus',
						'CZ' => 'Czech Republic',
						'DK' => 'Denmark',
						'EG' => 'Egypt',
						'EE' => 'Estonia',
						'FO' => 'Faroe Islands',
						'FI' => 'Finland',
						'FR' => 'France',
						'DE' => 'Germany',
						'GI' => 'Gibraltar',
						'GR' => 'Greece',
						'HU' => 'Hungary',
						'IE' => 'Ireland',
						'IT' => 'Italy',
						'LV' => 'Latvia',
						'LI' => 'Liechtenstein',
						'LT' => 'Lithuania',
						'LU' => 'Luxembourg',
						'MK' => 'Macedonia, The Former Yugoslav Republic of',
						'MC' => 'Macedonia',
						'MC' => 'Monaco',
						'NL' => 'Netherlands',
						'NO' => 'Norway',
						'PL' => 'Poland',
						'PT' => 'Portugal',
						'RO' => 'Romania',
						'SM' => 'San Marino',
						'SK' => 'Slovakia',
						'SI' => 'Slovenia',
						'ES' => 'Spain',
						'SE' => 'Sweden',
						'CH' => 'Switzerland',
						'UA' => 'Ukraine'];
			return $countries;				
		}
		public function displayCountryName($key=0){
			$options	=	$this->getCountriesArray();
			return $options[$key];	
		}
		public function applyAddtionalPrice($ticket_id,$default_price='0.00',$quantity=1){
			
			$current_date_start		=	date("Y-m-d");
			$current_date_end		=	date("Y-m-d");
			$TicketPrices 		=	TableRegistry::get('TicketPrices');
			$ticketprices 		=	$TicketPrices->find('all')->where(['TicketPrices.ticket_id'=>$ticket_id,'TicketPrices.date_from <='=>$current_date_start,'TicketPrices.date_to >= '=>$current_date_end])->first();
			if($ticketprices){
				$extra_price		=	$ticketprices->extra_price;
				if($ticketprices->extra_price_type==1){
					$price		=	$default_price + (($default_price*$extra_price)/100);
				}else{
					$price		=	$default_price + $extra_price;
				}	
			}else{
				$price		=	$default_price;
			}
			
			
			return $price;
		}
		public function applyDiscountPrice($ticket_id,$total_price='0.00',$quantity=1){
			if($quantity > 1){
				$TicketGroupPrices 		=	TableRegistry::get('TicketGroupPrices');
				$ticketgroupprices 		=	$TicketGroupPrices->find('all')->where(['TicketGroupPrices.ticket_id'=>$ticket_id,'TicketGroupPrices.ticket_qty <='=>$quantity])->first();
				if($ticketgroupprices){
					$discount_price		=	$ticketgroupprices->discount_price;
					if($ticketgroupprices->discount_type==1){
						$total_price		=	$total_price - (($total_price*$discount_price)/100);	
					}else{
						$total_price		=	$total_price - $discount_price;
					}		
				}	
			}
			return $total_price;
		}
		public function getCartSubTotal(){
			$this->Carts 	= 	TableRegistry::get('Carts');
			$subTotal	=	$this->Carts->getCartSubTotal();
			return $subTotal;
		}
		public function getCouponStatus(){
			$this->Carts 		= 	TableRegistry::get('Carts');
			$couponData	=	$this->Carts->readCouponData();
			if($couponData!=null && $couponData['couponStatus']==true){
				return true;
			}
			return false;
		}
		public function getCouponCode(){
			$this->Carts 		= 	TableRegistry::get('Carts');
			$couponData	=	$this->Carts->readCouponData();
			if($couponData!=null && $couponData['couponStatus']==true){
				return $couponData['couponCode'];
			}
			return false;
		}
		public function getShippingStatus(){
			$this->Carts 		= 	TableRegistry::get('Carts');
			$shippingData	=	$this->Carts->readShippingData();
			if($shippingData['shippingStatus']==true){
				return true;
			}
			return false;
		}
		public function getDefaultSettings(){
			$this->DefaultSettings 		= 	TableRegistry::get('DefaultSettings');
			$DefaultSettings 		=	$this->DefaultSettings->find('all')->where(['DefaultSettings.id'=>1])->first();
			return $DefaultSettings;
		}
		public function checkAvailableTickets($event_id=0,$ticket_id=0){
			$this->ReserveTickets 		= 	TableRegistry::get('ReserveTickets');
			if($this->ReserveTickets->checkAvailableTickets($event_id,$ticket_id)){
				return true;
			}
			return false;
		}
		
       }
?>