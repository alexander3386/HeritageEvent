<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo __('Default Settings')?></h3>
	</div>
	<?php echo $this->Form->create($setting,['type' => 'file'],['url' =>['controller'=>'settings','action'=>'defaultsettings',$setting_id]]); ?>
	<?php echo $this->Form->hidden('id');?>
	<div class="box-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Allow Shipping : </label>
					<?php 
						$options = ['1' => 'Active', '0' => 'Inactive'];
						echo $this->Form->select('is_shipping', $options, ['class' => 'form-control'] ) 
					?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Shipping Price : </label>
					<div class="input-group col-md-4">
					 <span class="input-group-addon"><?php echo CURRENCY_SYMBOL; ?></span>
					<?php echo $this->Form->text('shipping_price', ['class' => 'form-control validate[custom[number]]', 'maxlength' => 8,'placeholder'=>'0.00']) ?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Company Number : </label>
					<?php echo $this->Form->input('company_number', ['class'=>'form-control', 'id'=>'company_number', 'label'=>false ]);?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Company VAT Number : </label>
					<?php echo $this->Form->input('vat_number', ['class'=>'form-control', 'id'=>'vat_number', 'label'=>false ]);?>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
					<label>Contact Number : </label>
					<?php echo $this->Form->input('contact_number', ['class'=>'form-control validate[custom[phone]]', 'id'=>'contact_number', 'label'=>false ]);?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Info Email : <span class="require">*</span></label>
					<?php echo $this->Form->input('info_email', ['class'=>'form-control', 'id'=>'info_email validate[require,custom[email]]', 'label'=>false ]);?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>New Order Email : <span class="require">*</span></label>
					<?php echo $this->Form->input('order_email', ['class'=>'form-control validate[require,custom[email]]', 'id'=>'order_email', 'label'=>false ]);?>
				</div>
			</div>
			<div class="clear"></div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="inputdefault">Company address :</label>
					<?php echo $this->Form->input('company_address', ['type'=>'textarea','rows'=>'3','cols'=>'5','class'=>'form-control myeditor', 'id'=>'company_address', 'label'=>false, 'templates' => ['inputContainer'=>'{{content}}']]);?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="inputdefault">Offer Content :</label>
					<?php echo $this->Form->input('offer_content', ['type'=>'textarea','rows'=>'3','cols'=>'5','class'=>'form-control myeditor', 'id'=>'offer_content', 'label'=>false, 'templates' => ['inputContainer'=>'{{content}}']]);?>
				</div>
			</div>
			<div class="clear"></div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Offer Image : </label>
					<?php echo $this->Form->input('image', ['type'=>'file','class'=>'form-control',  'label'=>false, 'templates' => ['inputContainer'=>'{{content}}'],'error'=>false]); ?>
				</div>
				<div class="form-group">
					<?php
						$filePath = 'uploads'.DS.strtolower($setting->source()).DS.'image'.DS.$setting->get('upload_dir').DS.$setting->get('image');
						$sizeArr = @getimagesize(WWW_ROOT.$filePath);
						$mimeArr = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
						echo $this->Html->image('../uploads/'.strtolower($setting->source()).'/image/' .$setting->get('upload_dir'). '/' . $setting->get('image'));
					?>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
					<label>Logo : </label>
					<?php echo $this->Form->input('logo', ['type'=>'file','class'=>'form-control',  'label'=>false, 'templates' => ['inputContainer'=>'{{content}}'],'error'=>false]); ?>
				</div>
				<div class="form-group">
					<?php
						$filePath = 'uploads'.DS.strtolower($setting->source()).DS.'logo'.DS.$setting->get('logo_upload_dir').DS.$setting->get('logo');
						$sizeArr = @getimagesize(WWW_ROOT.$filePath);
						$mimeArr = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
						echo $this->Html->image('../uploads/'.strtolower($setting->source()).'/logo/' .$setting->get('logo_upload_dir'). '/' . $setting->get('logo'));
					?>
				</div>
			</div>
			
			<div class="clear"></div>
		</div>
		<div class="box-tools pull-right">
			<?php echo $this->Form->button(__('Submit'), ['class' => 'btn btn-primary btn-block btn-flat']); ?>
		</div>
	</div>
	<?php echo $this->Form->end() ?>
</div>


