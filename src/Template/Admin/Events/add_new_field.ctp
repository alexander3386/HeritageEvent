<div class="col-md-6">
	<div class="form-group">
		<label for="inputdefault">Chose Image :</label>
		<?php echo $this->Form->input("uploads.$row_count.file", ['type'=>'file','rows'=>'5','cols'=>'5','class'=>'form-control',  'label'=>false, 'div'=>false]); ?>
	</div>
</div>
