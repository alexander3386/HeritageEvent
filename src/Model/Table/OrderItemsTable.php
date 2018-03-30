<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use App\View\Helper\CustomHelper;
class OrderItemsTable extends Table
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
		$this->table('order_items');
		$this->displayField('id');
		$this->primaryKey('id');
		$this->addBehavior('Timestamp');
		//associations
		$this->belongsTo('tickets',[
						'foreignKey' => 'item_id',
						'dependent' => true,
						'Tickets.item_type' => 'ticket'
					]);
		$this->belongsTo('products',[
						'foreignKey' => 'item_id',
						'dependent' => true,
						'Products.item_type' => 'product'
						]);
		$this->belongsTo('programs',[
						'foreignKey' => 'item_id',
						'dependent' => true,
						'Program.item_type' => 'program'
						]);
		
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
		    ->requirePresence('order_id', 'create')
		    ->notEmpty('order_id');
		
		$validator
		    ->requirePresence('item_id', 'create')
		    ->notEmpty('item_id');

		$validator
		    ->requirePresence('item_type', 'create')
		    ->notEmpty('item_type');
	
		$validator
		    ->requirePresence('item_price', 'create')
		    ->notEmpty('item_price');

		$validator
		    ->requirePresence('item_quantity', 'create')
		    ->notEmpty('item_quantity');
		$validator
		    ->requirePresence('item_total', 'create')
		    ->notEmpty('item_total');
		
		return $validator;
	}
	
	public function saveOrderItems($order_id)
	{
		$this->Carts 			= 	TableRegistry::get('Carts');
		$this->OrderItems 	= 	TableRegistry::get('OrderItems');
		$this->Products 		= 	TableRegistry::get('Products');
		$this->Programs 		= 	TableRegistry::get('Programs');
		
		$carts = $this->Carts->readCartItem();
		$count = $this->Carts->getCount();
		$saveItemCount =0;
		$this->Custom			=	 new CustomHelper(new \Cake\View\View());
		if (null!=$carts) {
			if(isset($carts['tickets'])){
				foreach ($carts['tickets'] as $id => $array) {
					$newEntity = $this->newEntity();
					$ticketData 					= 	$this->Tickets->get($id);
					if($ticketData){
						$ticket 					=	 [];
						$ticket['item_quantity']	= 	$array['qty'];
						$ticket['item_id']			= 	$id;
						$ticket['item_name']		= 	$ticketData['title'];
						$ticket['item_type']		= 	'ticket';
						$ticket['order_id']		= 	$order_id;
						$ticket_price			= 	$this->Custom->applyAddtionalPrice($id,$ticketData['price'],$array['qty']);
						$total_price				= 	($ticket_price*$array['qty']);
						$discount_total_price	= 	$this->Custom->applyDiscountPrice($id,$total_price,$array['qty']);

						$ticket['item_price']		= 	$ticket_price;
						if($discount_total_price < $total_price){
							$ticket['item_total']		= $discount_total_price;
						}
						else{
							$ticket['item_total']			= 	$total_price;
						}
						if(isset($array['special_requirement'])){
							$ticket['special_requirement']		= 	$array['special_requirement'];
						}
						if(isset($array['special_description'])){
							$ticket['special_description']		= 	$array['special_description'];
						}
						
						$data 							= 	$this->patchEntity($newEntity,$ticket);
						$orderResult 					= 	$this->save($data);
						
						if($orderResult['id'] > 0)
						{
							$saveItemCount++;
						}
					}
				}
			}
			if(isset($carts['products'])){
				foreach ($carts['products'] as $id => $array) {
					$newEntity = $this->newEntity();
					$productData 					= 	$this->Products->get($id);
					if($productData){
						$product 					= 	[];
						$product['item_quantity']		= 	$array['qty'];
						$product['item_id']			= 	$id;
						$product['item_name']		= 	$productData['title'];
						$product['item_type']		= 	"product";
						$product['order_id']			= 	$order_id;
						$product['item_price']		= 	$productData['price'];
						$product['item_total']		= 	$array['qty']*$productData['price'];
						$data 						= 	$this->patchEntity($newEntity,$product);
						$orderResult 				= 	$this->save($data);
						if($orderResult['id'] > 0)
						{
							$saveItemCount++;
						}
					}
				}
			}
			if(isset($carts['programs'])){
				foreach ($carts['programs'] as $id => $array) {
					$newEntity = $this->newEntity();
					$programData 					= 	$this->Programs->get($id);
					if($programData){
						$program 					= 	[];
						$program['item_quantity']		= 	$array['qty'];
						$program['item_id']			= 	$id;
						$program['item_name']		= 	$programData['title'];
						$program['item_type']		= 	"program";
						$program['order_id']			= 	$order_id;
						$program['item_price']		= 	$programData['price'];
						$program['item_total']		= 	$array['qty']*$programData['price'];
						$data 						= 	$this->patchEntity($newEntity,$program);
						$orderResult 				= 	$this->save($data);
						if($orderResult['id'] > 0)
						{
							$saveItemCount++;
						}
					}
				}
			}
			if($count == $saveItemCount)
			{
				return true;
			}
		}
		return false;
	}
	public function getProductItem($orderid)
	{
		$products = $this->find('all')->where( ['OrderItems.order_id' =>$orderid,'OrderItems.item_type'=>'product'] )->all();
		return $products;
	}
	public function getProgramItem($orderid)
	{
		$programs = $this->find('all')->where( ['OrderItems.order_id' =>$orderid,'OrderItems.item_type'=>'program'] )->all();
		return $programs;
	}
	
	public function getTicketsItem($orderid)
	{
		$tickets = $this->find('all')->where( ['OrderItems.order_id' =>$orderid,'OrderItems.item_type'=>'ticket'] )->all();
		return $tickets;
	}
}
