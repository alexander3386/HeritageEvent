<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Edit Product</h3>
	</div>
	<?php echo $this->Form->create($product, ['id' => 'form_id','type' => 'file']) ?>
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
					 <?php $price	=	$this->Custom->displayPrice($product['price']);?>
					<?php echo $this->Form->text('price', ['class' => 'form-control validate[required,custom[number]]','placeholder'=>'0.00', 'maxlength' => 6,'value'=>$price]) ?>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Per price <span class="require">*</span></label>
					<div class="input-group col-md-4">
					<?php echo $this->Form->text('price_postfix', ['class' => 'form-control','placeholder'=>'each', 'maxlength' =>50]) ?>
					</div>
				</div>
			</div>
			<!--<div class="col-md-4">
				<div class="form-group">
					<label>Shipping Price <span class="require">*</span></label>
					<div class="input-group col-md-4">
					 <span class="input-group-addon"><?php echo CURRENCY_SYMBOL; ?></span>
					  <?php $shipping_price	=	$this->Custom->displayPrice($product['shipping_price']);?>
					<?php echo $this->Form->text('shipping_price', ['class' => 'form-control validate[custom[number]]','placeholder'=>'0.00', 'maxlength' => 6,'value'=>$shipping_price]) ?>
					</div>
				</div>
			</div>-->
			<div class="clear"></div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Featured Image <span class="require">*</span></label>
					<?php echo $this->Form->input('image', ['type'=>'file','class'=>'form-control',  'label'=>false, 'templates' => ['inputContainer'=>'{{content}}'],'error'=>false]); ?>
				</div>
				<div class="form-group">
					<?php
						$filePath = 'uploads'.DS.strtolower($product->source()).DS.'image'.DS.$product->get('upload_dir').DS.$product->get('image');
						$sizeArr = @getimagesize(WWW_ROOT.$filePath);
						$mimeArr = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
						echo $this->Html->image('../uploads/'.strtolower($product->source()).'/image/' .$product->get('upload_dir'). '/square_' . $product->get('image'));
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
						$filePath = 'uploads'.DS.strtolower($product->source()).DS.'icon_image'.DS.$product->get('icon_upload_dir').DS.$product->get('icon_image');
						$sizeArr = @getimagesize(WWW_ROOT.$filePath);
						$mimeArr = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
						echo $this->Html->image('../uploads/'.strtolower($product->source()).'/icon_image/' .$product->get('icon_upload_dir'). '/square_' . $product->get('icon_image'));
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