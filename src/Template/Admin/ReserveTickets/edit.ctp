<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Edit Reserve Ticket</h3>
	</div>
	<?php echo $this->Form->create($reserveTickets, ['id' => 'form_id']) ?>
	<div class="box-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Event Name <span class="require">*</span></label>
					<?php
						$event  = 'Select Event';
						if(isset($reserveTickets['event_id'])){
							$event	=	$reserveTickets['event_id'];
						}
						echo $this->Form->select('event_id', $event_arr, ['class' => 'form-control validate[required]','value'=>$event ,'empty' => 'Select Event','id'=>'event_id'] )
					?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Ticket Name <span class="require">*</span></label>
					<div id ="ticketdrop">
						<?php
							$ticket = 'Select Ticket';
							if(isset($reserveTickets['ticket_id'])){
							$ticket	=	$reserveTickets['ticket_id'];
						}
							echo $this->Form->select('ticket_id', $ticket_arr, ['class' => 'form-control validate[required]','value'=>$ticket ,'empty' => 'Select Ticket'] )
						?>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
					<label>From Date/Time<span class="require">*</span></label>
					<div class='input-group date datetimepicker' >
						<?php  $date_from	=	$this->Custom->inputDateTimeFormat($reserveTickets['from_date']); 

						echo $this->Form->text('from_date', ['class' => 'form-control validate[required]','placeholder'=>'dd/mm/YYYY hh:mm:ss','value'=>$date_from]) ?>
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>To Date/Time<span class="require">*</span></label>
					<div class='input-group date datetimepicker' >
						<?php 
						$date_to	=	$this->Custom->inputDateTimeFormat($reserveTickets['to_date']); 

						echo $this->Form->text('to_date', ['class' => 'form-control validate[required]','placeholder'=>'dd/mm/YYYY hh:mm:ss','value'=>$date_to]) ?>
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Allow Ticket(s) Quantity <span class="require">*</span></label>
					<?php echo $this->Form->number('numberof_tickets', ['class' => 'form-control validate[required,custom[number]]', 'min' => 1,'step'=>1, 'max'=>'10000']) ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Status <span class="require">*</span></label>
					<?php 
						$options = ['1' => 'Active', '0' => 'Inactive'];
						$status  = 'active';
						if(isset($reserveTickets['status'])){
							$status	=	$reserveTickets['status'];
						}
						echo $this->Form->select('status', $options, ['class' => 'form-control validate[required]','value'=>$status] ) 
					?>
				</div>
			</div>
		</div>
		<div class="box-tools pull-right">
			<?php echo $this->Form->button(__('Submit'), ['class' => 'btn btn-primary btn-block btn-flat']); ?>
		</div>
	</div>
	<?php echo $this->Form->end() ?>
</div>
