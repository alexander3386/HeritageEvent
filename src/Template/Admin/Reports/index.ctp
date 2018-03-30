<style>
  .table td{vertical-align: middle !important;}
</style>
<div class="row">
  <div class="col-md-12">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Orders Report</h3>
			
		</div>
		<?php echo $this->Form->create($form,['url' => ['controller' =>'reports', 'action' => 'index'], 'id' => 'form_id', 'type' => 'get']) ?>
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
					<div class="form-group">
						<label>From Date/Time<span class="require">*</span></label>
						<div class='input-group date datepicker' >
							<?php echo $this->Form->text('from_date', ['class' => 'form-control','placeholder'=>'dd/mm/YYYY ']) ?>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>To Date/Time<span class="require">*</span></label>
						<div class='input-group date datepicker' >
							<?php echo $this->Form->text('to_date', ['class' => 'form-control ','placeholder'=>'dd/mm/YYYY']) ?>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group"><br />
						<div class="col-md-8">
								<?php echo $this->Form->button(__('Download CSV'), ['name'=>'download_orders','class' => 'btn btn-primary btn-block btn-flat']); ?>
							</div>
							<div class="col-md-4">
								<?php echo $this->Html->link(__('Reset'), ['controller' => 'orders', 'action' => 'index'], ['class' => 'btn btn-danger btn-flat'] ); ?>
							</div>
						
					</div>
				</div>
				
				
			</div>
		</div>
		<?php echo $this->Form->end() ?>
	
    </div>
   </div>
   