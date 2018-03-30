<div class="more_price_row_<?php echo $row_count;?>">
<div class="col-md-10">
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label>Form</label>
				<div class='input-group date datepicker' >
					<?php echo $this->Form->text("ticket_prices.$row_count.date_from", ['class' => 'form-control validate[required]','placeholder'=>'dd/mm/YYYY']) ?>
					
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>To</label>
				<div class='input-group date datepicker' >
					<?php echo $this->Form->text("ticket_prices.$row_count.date_to", ['class' => 'form-control validate[required]','placeholder'=>'dd/mm/YYYY']) ?>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>Additional Price</label>
				<?php echo $this->Form->text("ticket_prices.$row_count.extra_price", ['class' => 'form-control validate[custom[number]]','placeholder'=>'0.00','value'=>'0.00']) ?>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>Additional Price In</label>
				<?php 
					$options = [0 => 'Fixed Cost', 1 => 'In percent(%)'];
					echo $this->Form->select("ticket_prices.$row_count.extra_price_type", $options, ['class' => 'form-control','value'=>0] ) 
				?>
			</div>
		</div>
	</div>
</div>
<div class="col-md-2">
	<div class="form-group">
		<label>&nbsp;</label><br />
		<a href="javascript:void(0)" onclick="remove_more_price('<?php echo $row_count;?>');"class="remove_more_price" rel="<?php echo $row_count;?>"><i class="glyphicon glyphicon-remove"></i></a>
	</div>
</div>
</div>