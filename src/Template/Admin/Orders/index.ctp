<style>
  .table td{vertical-align: middle !important;}
</style>
<div class="row">
  <div class="col-md-12">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Manage Orders</h3>
			<span class="add_btn">
			<a href="<?php echo $this->Url->build(['controller' => 'orders', 'action' => 'add'])?>" class="btn btn-success btn-sm">Create New Order</a></span>
		</div>
		<?php echo $this->Form->create($form,['url' => ['controller' =>'orders', 'action' => 'index'], 'id' => 'form_id', 'type' => 'get']) ?>
		<div class="box-body">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>Search Customer</label>
						<?php echo $this->Form->text('search_keyword', ['class' => 'form-control', 'placeholder' => 'Search by name, phone, postalcode']); ?>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Event </label>
						<?php echo $this->Form->select('event_id', $event_arr, ['class' => 'form-control', 'id' => 'event_id', 'empty' => 'All'] ); ?>
					</div>
				</div>
				
				<div class="col-md-3">
					<div class="form-group">
						<label>Order Status </label>
						<?php 
							$options = ['A' => 'All', 'processing' => 'Processing','complete'=>'Complete','cancel'=>'Cancel'];
							$status	='A';
							if(isset($this->request->data['status'])){
								$status	=	$this->request->data['status'];
							}
							echo $this->Form->select('status', $options, ['class' => 'form-control','value'=>$status] ) 
						?>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Order Type</label>
						<?php 
							$options = ['A' => 'All','online' => 'Online Order', 'telephone' => 'Telephone Order'];
							$order_type	='A';
							if(isset($this->request->data['order_type'])){
								$order_type	=	$this->request->data['order_type'];
							}
							echo $this->Form->select('order_type', $options, ['class' => 'form-control','value'=>$order_type] ) 
						?>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group"><br />
						<div class="box-tools ">
							<div class="col-md-8">
								<?php echo $this->Form->button(__('Submit'), ['class' => 'btn btn-primary btn-block btn-flat']); ?>
							</div>
							<div class="col-md-4">
								<?php echo $this->Html->link(__('Reset'), ['controller' => 'orders', 'action' => 'index'], ['class' => 'btn btn-danger btn-flat'] ); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div id="action_set" class="box-body " >
			<div class = "row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Update Order Status </label>
						<?php 
							$options = ['A' => 'Select', 'processing' => 'Processing','dispatch'=>'Dispatch','complete'=>'Complete','cancel'=>'Cancel'];
							$or_status	='A';
							if(isset($this->request->data['or_status'])){
								$or_status	=	$this->request->data['or_status'];
							}
							echo $this->Form->select('or_status', $options, ['class' => 'form-control','value'=>$or_status ,'id'=>'or_status'] ) 
						?>
						<intput type="text" id="all_orders" name="all_orders"/>

						
									
						
					</div>
				</div>
				<div class="col-md-2">
				<label>&nbsp; </label>
					<?php echo $this->Form->button(__('Update'), ['class' => 'btn btn-primary btn-block btn-flat','id'=>'update_status']); ?>
				</div>

			</div>
		</div>
		<?php echo $this->Form->end() ?>
		<div class="box-body">
			<table class="table table-bordered">
				 <tr>
					<th><div class="check">
	  						<label><input type="checkbox" name="check_all" value="all" id="checked_all"/></label>
	  				</th>
					<th >
						#
					</th>
					<th>Event Name</th>
					<th>Customer Name</th>
					<th>Total Amount</th>
					<th>Order Status</th>
					<th>Order Date</th>
					<th >Action</th>
				 </tr>
				<?php 
				//pr($orders);
				if(count($orders) > 0) {
					$i=1;
					foreach($orders as $items)
					{
						$class="btn btn-danger btn-xs";
						$stType ='Inactive';
						$stVal=1;
						if($items['status']=='1')
						{
							$class="btn btn-success btn-xs";
							$stType ='Active';
							$stVal=0;
						}
						$id =$items['id'];
						$name = $items['customers']['title'].'. '.$items['customers']['first_name'].' '.$items['customers']['last_name'];
						$type = 'view';
					?>
						<tr>
							
							<td>
								<div class="check">
			  						<label><input type="checkbox" name="check" value="<?php echo $items['id']; ?>"  class="checkbox" /></label>
								</div>
							</td>
							<td>
								<?php echo $i;?>
							</td>
							<td><?php echo $items['events']['title']; ?></td>
							
							
							<td><?php echo $items['customers']['title'].'. '.$items['customers']['first_name'].' '.$items['customers']['last_name'];?></td>
							
							<td><?php echo $this->Custom->displayPriceHtml($items['total_amount']);?></td>
							
							<td class="status_val"><?php echo ucfirst($items['order_status']); ?></td>
							<td>
								<?php echo $this->Custom->displayDateFormat($items['created']); ?>
							</td>
							<td>
								
									<a class="btn btn-success btn-xs" title="Payment Invoice"  href="<?php echo $this->Url->build(['controller' => 'orders', 'action' => 'print-invoice/'.$type.'/'.$id])?>">
										<i class="glyphicon glyphicon-download"></i>
									</a>
									<a class="btn btn-primary btn-xs" title="Event Invoice"  href="<?php echo $this->Url->build(['controller' => 'orders', 'action' => 'print-ticket/'.$type.'/'.$id])?>">
										<i class="glyphicon glyphicon-print"></i>
									</a>
									<a class="btn btn-danger btn-xs" title="View Order"  href="<?php echo $this->Url->build(['controller' => 'orders', 'action' => 'orderdetails/'.$id])?>">
										<i class="glyphicon glyphicon-eye-open"></i>
									</a>
									
								
								
							</td>
							
						</tr>
					<?php
					$i++;
					}
				}
			else {
				echo '<tr><td  colspan="5" align="center"><i>No results found!</i></td></tr>';
			}
		?>
			</table>
		</div>
		<div class="box-footer clearfix">
			<ul class="pagination pagination-sm no-margin pull-right">
				  <?php echo $this->Paginator->prev(' << '); ?>
				  <?php echo $this->Paginator->numbers(); ?>
				  <?php echo $this->Paginator->next(' >> '); ?>
			</ul>
		</div>
	</div>
    </div>
   </div>
   <script type="text/javascript">
   		var orders = [];
   		
   		$('#checked_all').on('change', function() {     
                $('.checkbox').prop('checked', $(this).prop("checked")); 
                if($('#action_set').css('display')== 'none')
                {
                	//$("#action_set").css('display','block');
                }   
                else
                {
                //$("#action_set").css('display','none');
                }  
                  
        });
        $('.checkbox').change(function(){ //".checkbox" change 
            if($('.checkbox:checked').length == $('.checkbox').length){
                   $('#checked_all').prop('checked',true);

                   
            }else{
                   $('#checked_all').prop('checked',false);
                   
            }
        });

        $("#checked_all, .checkbox").change(function(){
        	$("input:checkbox[name=check]").each(function(){
				if($(this).prop('checked')==true)
				{
					var valu = $(this).val();
					if(jQuery.inArray(valu, orders )  === -1)
					orders.push($(this).val());
					 
				}
				else
				{
					var valu = $(this).val();
					orders = jQuery.grep(orders, function(value) {
		  			return value != valu;
					});
				}
			});
			$("#all_orders").val(orders);
        });
        $("#update_status").click(function(){
			var status_val = $("#or_status").val();
			var sele_orders = $("#all_orders").val();
			//alert(sele_orders);
			if(sele_orders != '' && status_val !=''){
				if (confirm("Are you you want to change orders status?")) {
					$.ajax({
						type:"POST",
						data:{status_val:status_val, sele_orders : sele_orders},
						url:"<?php echo $this->Url->build(["prefix"=>'admin',"controller" => "Orders","action" => "updatestatus"]);?>" ,
						//dataType: JSON,
						success: function(response){
							console.log(JSON.parse(response));
							var response = JSON.parse(response)
							if(response.status == "true")
							$(".status_val").html(response.order_status);
						},
						error: function (response) {
							console.log(response);
						}
					});
				}
				else
				{
					return false;
				}
			}
			else
			{
				alert("Oops...You have not select any order");
				return false;
			}
		})
   </script>