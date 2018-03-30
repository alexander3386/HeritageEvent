<?php 
	namespace App\Controller\Component;
	use Cake\Controller\Component;
	use Worldpay\Worldpay;
	use Cake\Core\Exception\Exception;
	class WorldpayComponent extends Component
	{
		public function processPayment($request_param){
			
			
			$worldpay = new Worldpay("T_S_7365fec5-1ffc-42ea-b96f-d2f0159e66fd");
			$worldpay->disableSSLCheck(true);
			
			$name					= $request_param['cardholder_name'];
			$expiration_month		= $request_param['exp_month']['month'];
			$expiration_year		= $request_param['exp_year']['year'];
			$card_number			= $request_param['card_number'];
			$cvc					= $request_param['cvv'];

			$amount = is_numeric($request_param['totalAmount']) ? $request_param['totalAmount']*100 : -1;
			
			$obj					= array();
			$obj['paymentMethod'] 	=  array(
					"name" 		    => $name,
					"type" 		    => "Card",
					"expiryMonth"  	=> $expiration_month,
					"expiryYear"    => $expiration_year,	
					"cardNumber"	=> $card_number,
					"cvc"			=> $cvc,
					"issueNumber" 	=> "1",
				);
			$obj['orderType'] 		= $request_param["orderType"]; 
    		$obj['orderDescription']= "Payment through worldpay direct"; 
    		$obj['amount'] 			= $amount; 
    		$obj['currencyCode'] 	= WORLDPAY_CURRENCY;
    		$obj['name'] 			= $request_param['username'];
    		
    		//pr($obj);die;
    		try {
				$response = $worldpay->createOrder($obj);
				
				

				if($response['paymentStatus'] == 'SUCCESS')
				{
					return $response;
				}
				else
				{
					throw new Exception('Oops an error occur ');
				}
			} catch (Exception $e) {
				throw new Exception('Oops an error occur '.$e->getMessage());
			}
			
		
		
		}
		public function doComplexOperation($amount1, $amount2)
		{
			
			return $amount1 + $amount2;
		}
	}
?>