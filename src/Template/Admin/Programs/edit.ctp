<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Edit Program</h3>
	</div>
	<?php echo $this->Form->create($program, ['id' => 'form_id','type' => 'file']) ?>
	<div class="box-body">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label>Name <span class="require">*</span></label>
					<?php echo $this->Form->text('title', ['class' => 'form-control validate[required]', 'maxlength' => 200]) ?>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label>Event Name <span class="require">*</span></label>
					<?php echo $this->Form->input('event_id', ['type'=>'select','options'=>$event_arr,'class'=>'form-control', 'id'=>'event_id', 'label'=>false, 'templates' => ['inputContainer'=>'{{content}}'],'empty' => 'Select Event']); ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Description <span class="require">*</span></label>
					<?php echo $this->Form->textarea('description', ['class' => 'form-control validate[required]']) ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Item code <span class="require">*</span></label>
					<?php echo $this->Form->text('item_code', ['class' => 'form-control validate[required]', 'maxlength' => 12]) ?>
				</div>
			</div>
			<div class="clear"></div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Price <span class="require">*</span></label>
					<div class="input-group col-md-4">
					 <span class="input-group-addon"><?php echo CURRENCY_SYMBOL; ?></span>
					 <?php $price	=	$this->Custom->displayPrice($program['price']);?>
					<?php echo $this->Form->text('price', ['class' => 'form-control validate[required,custom[number]]','placeholder'=>'0.00', 'maxlength' => 6,'value'=>$price]) ?>
					</div>
				</div>
			</div>
			
			
			<div class="clear"></div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Featured Image <span class="require">*</span></label>
					<?php echo $this->Form->input('image', ['type'=>'file','class'=>'form-control',  'label'=>false, 'templates' => ['inputContainer'=>'{{content}}'],'error'=>false]); ?>
				</div>
				<div class="form-group">
					<?php
						$filePath = 'uploads'.DS.strtolower($program->source()).DS.'image'.DS.$program->get('upload_dir').DS.$program->get('image');
						$sizeArr = @getimagesize(WWW_ROOT.$filePath);
						$mimeArr = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
						echo $this->Html->image('../uploads/'.strtolower($program->source()).'/image/' .$program->get('upload_dir'). '/square_' . $program->get('image'));
					?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Icon Image</label>
					<?php echo $this->Form->input('icon_image', ['type'=>'file','class'=>'form-control',  'label'=>false, 'templates' => ['inputContainer'=>'{{content}}'],'error'=>false]); ?>
				</div>
				<div class="form-group">
					<?php
						$filePath = 'uploads'.DS.strtolower($program->source()).DS.'icon_image'.DS.$program->get('icon_upload_dir').DS.$program->get('icon_image');
						$sizeArr = @getimagesize(WWW_ROOT.$filePath);
						$mimeArr = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
						echo $this->Html->image('../uploads/'.strtolower($program->source()).'/icon_image/' .$program->get('icon_upload_dir'). '/square_' . $program->get('icon_image'));
					?>
				</div>
			</div>
			<div class="clear"></div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Status <span class="require">*</span></label>
					<?php 
						$options = ['1' => 'Active', '0' => 'Inactive'];
						echo $this->Form->select('status', $options, ['class' => 'form-control'] ) 
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