<?php 
	namespace App\Controller\Component;
	use Cake\Controller\Component;
	//use Mailchimp\MCAPI;
	use Cake\Core\Exception\Exception;
	use Cake\Core\Configure;
	class MailchimpComponent extends Component
	{		
		public function listSubscribe($email=NULL, $merge_vars=array()){
			
			require_once(ROOT .DS. 'vendor' . DS . 'mailchimp' .DS.'MCAPI.php');
			$mailchimp_apikey	=	MAILCHIMP_API_KEY;
			$mailchimp_list_id	=	MAILCHIMP_LIST_ID;
			$mcapi 				= 	new \MCAPI($mailchimp_apikey);
			$mcapi->listSubscribe($mailchimp_list_id, $email, $merge_vars, 'html', false, false);
			echo $mcapi->errorCode;
			echo $mcapi->errorMessage;
			if ($mcapi->errorCode){
				return false;
			} else {
				return true;
			}
		}
	}
