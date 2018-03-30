<div class="group_price_row_<?php echo $row_count;?>">
<div class="col-md-10">
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label>Group Tickets Qty.</label>
				<?php echo $this->Form->text("ticket_group_prices.$row_count.ticket_qty", ['class' => 'form-control validate[custom[onlyNumberSp]']) ?>
			</div>
		</div> 
		<div class="col-md-4">
			<div class="form-group">
				<label>Additional Discount Price</label>
				<?php echo $this->Form->text("ticket_group_prices.$row_count.discount_price",['class' => 'form-control validate[custom[number]]','placeholder'=>'0.00']) ?>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Additional Discount Price In</label>
				<?php 
					$options = [0 => 'Fixed Cost', 1 => 'In percent(%)'];
					echo $this->Form->select("ticket_group_prices.$row_count.discount_type", $options, ['class' => 'form-control','value'=>0] ) 
				?>
			</div>
		</div>
	</div>
</div>
<div class="col-md-2">
	<div class="form-group">
		<label>&nbsp;</label><br />
		<a href="javascript:void(0)" onclick="remove_group_price('<?php echo $row_count;?>');"class="remove_group_price" rel="<?php echo $row_count;?>"><i class="glyphicon glyphicon-remove"></i></a>
	</div>
</div>
</div>