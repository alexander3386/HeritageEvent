<style>
  .table td{vertical-align: middle !important;}
</style>
<div class="row">
  <div class="col-md-12">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Customers Report</h3>
			
		</div>
		<?php echo $this->Form->create($form,['url' => ['controller' =>'reports', 'action' => 'customer-report'], 'id' => 'form_id', 'type' => 'get']) ?>
		<div class="box-body">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>Search </label>
						<?php echo $this->Form->text('search_keyword', ['class' => 'form-control', 'placeholder' => 'Search by customer name or email address']); ?>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Search by contact number </label>
						<?php echo $this->Form->text('search_contact_number', ['class' => 'form-control', 'placeholder' => 'Search by customer contact number']); ?>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Search by postcode </label>
						<?php echo $this->Form->text('search_postcode', ['class' => 'form-control', 'placeholder' => 'Search by customer postcode']); ?>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Status </label>
						<?php 
							$options = ['A' => 'All','1' => 'Active', '0' => 'Inactive'];
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
				<div class="col-md-4">
					<div class="form-group"><br />
						<div class="box-tools ">
							<div class="col-md-8">
								<?php echo $this->Form->button(__('Download CSV'), ['class' => 'btn btn-primary btn-block btn-flat','name'=>'download_customer']); ?>
							</div>
							<div class="col-md-4">
								<?php echo $this->Html->link(__('Reset'), ['controller' => 'Reports', 'action' => 'customer-report'], ['class' => 'btn btn-danger btn-flat'] ); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php echo $this->Form->end() ?>
		
	</div>
    </div>
   </div>