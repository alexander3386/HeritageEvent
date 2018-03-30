<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class ReserveTicketsTable extends Table
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
		$this->table('reserve_tickets');
		$this->displayField('id');
		$this->primaryKey('id');
		//associations
		$this->belongsTo('Events');
		$this->belongsTo('Tickets');
		$this->belongsTo('Orders');
		$this->addBehavior('Timestamp');
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
		    ->requirePresence('event_id', 'create')
		    ->notEmpty('event_id');
		
		$validator
		    ->requirePresence('numberof_tickets', 'create')
		    ->notEmpty('numberof_tickets');
		
		$validator
		    ->requirePresence('from_date', 'create')
		    ->notEmpty('from_date');

		$validator
		    ->requirePresence('to_date', 'create')
		    ->notEmpty('from_date');

		$validator
		    ->requirePresence('status', 'create')
		    ->notEmpty('status');
		    
		return $validator;
	}
	function checkAvailableTickets($event_id=0,$ticket_id=0){
		if($this->getTotalTicketRemaining($event_id,$ticket_id) > 0){
			return true;
		}else{
			return false;
		}
	}
	function getTotalTicketRemaining($event_id=0,$ticket_id=0){
		//echo date("d h:i:s a");
		$current_date_start		=	date("c");
		$current_date_end		=	date("c");
		
		$ReserveTickets 			= 	$this->find('all')->where(['ReserveTickets.event_id' =>$event_id,'ReserveTickets.ticket_id' =>$ticket_id,'ReserveTickets.from_date <='=>$current_date_start,'ReserveTickets.to_date >= '=>$current_date_end,'ReserveTickets.status' =>1])->first();
		
		if($ReserveTickets){
			$reserveBookTicket	=	$ReserveTickets->numberof_tickets;
			$from_date			=	$ReserveTickets->from_date;
			$to_date			=	$ReserveTickets->to_date;
			
			$orderItems 		= 		$this->Orders->find('all')
										->where(function($exp) use($from_date,$to_date) {
											return $exp->between('Orders.created', $from_date, $to_date, 'datetime');
										})
										->andwhere(['Orders.order_status !='=>'pending','Orders.event_id'=>$event_id,'OrderItems.item_id' =>$ticket_id,'OrderItems.item_type'=>'ticket'] )->hydrate(false)->join([
											'table' => 'order_items',
											'alias' => 'OrderItems',
											'type' => 'LEFT',
											'conditions' => 'OrderItems.order_id = Orders.id'
										])->autoFields(false)->select('OrderItems.item_quantity')->all()->toArray();
			$totalItemQuantity	=	0;	
			if($orderItems && count($orderItems) > 0){
				foreach($orderItems as $orderItem){
					$totalItemQuantity	+=	$orderItem['OrderItems']['item_quantity'];
				}
			}
			
			$leftQuatityForSell	=	($reserveBookTicket	-	$totalItemQuantity);
			if($leftQuatityForSell < 1){
				$leftQuatityForSell	=	0;
			}
			return $leftQuatityForSell;
		}
		return 999;
	}
}
