<div  id ="successmsg" style="display:none;">
  
</div>


<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Create Order</h3>
		
	</div>
	<?php echo $this->Form->create($form, ['id' => 'form_id']) ?>
	<div class="box-body">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label>Event Name <span class="require">*</span></label>
					<input type="text" name="event_name" value="<?php echo $event['title'];?>" class="form-control" readonly/>
					
					<input type="hidden" name="event_id" value="<?php echo $event['id'];?>" class="form-control" readonly/>

					<input type="hidden" name="order_type" value="telephone" readonly/>
			
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="form-group customer-type">
					<label>Customer <span class="require">*</span></label>
					<input type="radio" name="customer_type" value="new" onChange="chooseCustomer();"/><span class="title">New Customer</span><input type="radio" name="customer_type" value="existing" onChange="chooseCustomer();" checked id="existing_cust"/><span class="title">Existing Customer</span>
					
				</div>
			</div>
			<div class="col-md-4" id="search_cust" >
				<div class="form-group">
					<label>Search Customer</label>
					<?php echo $this->Form->text('search_customer', ['class' => 'form-control','placeholder'=>'search by name, enail or postcode','id'=>'search_exists_customer']) ?>
					
				</div>
			</div>
			<div class="col-md-12" id="searched_Customer" style="display:none;">
				
			</div>
			<div class="col-md-12" id="hidden-field" style="display:none;">
				<div class="col-md-4">
					<div class="form-group">
						<label>Title<span class="require">*</span></label>
						<?php echo $this->Form->text('title_name', ['class' => 'form-control validate[required]','placeholder'=>'Title','id'=>'title_name', 'readonly'=>'readonly', 'maxlength'=>'100']) ?>

						<?php 
						$options = $this->Custom->getCutomerTitleArray();
						echo $this->Form->select('title', $options, ['class' => 'form-control ','value'=>1,'id'=>'title' ,'style'=>'display:none;'] );?> 
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="form-group">
						<label>Firstname<span class="require">*</span></label>
						<?php echo $this->Form->text('first_name', ['class' => 'form-control validate[required]' ,'placeholder'=>'Firstname','id'=>'first_name', 'readonly'=>'readonly', 'maxlength'=>'100']) ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Lastname<span class="require">*</span></label>
						<?php echo $this->Form->text('last_name', ['class' => 'form-control validate[required]','placeholder'=>'Lastname','id'=>'last_name', 'readonly'=>'readonly', 'maxlength'=>'100']) ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Email<span class="require">*</span></label>
						<?php echo $this->Form->email('email', ['class' => 'form-control validate[required]','placeholder'=>'Email','id'=>'email', 'readonly'=>'readonly', 'maxlength'=>'100']) ?>
						<div id="email-error"></div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Contact Number<span class="require">*</span></label>
						<?php echo $this->Form->text('contact_number', ['class' => 'form-control validate[required]','placeholder'=>'Contact Number','id'=>'contact_number', 'readonly'=>'readonly', 'maxlength'=>'100']) ?>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="form-group">
						<label>Address 1<span class="require">*</span></label>
						<?php echo $this->Form->text('address1', ['class' => 'form-control validate[required]','placeholder'=>'Address line 1','id'=>'address1', 'maxlength'=>'100']) ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Address 2<span class="require">*</span></label>
						<?php echo $this->Form->text('address2', ['class' => 'form-control validate[required]','placeholder'=>'Address line 2','id'=>'address2', 'maxlength'=>'100']) ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Town<span class="require">*</span></label>
						<?php echo $this->Form->text('town', ['class' => 'form-control validate[required]','placeholder'=>'Town','id'=>'town', 'maxlength'=>'100']) ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>County<span class="require">*</span></label>
						<?php echo $this->Form->text('county', ['class' => 'form-control validate[required]','placeholder'=>'County','id'=>'county', 'maxlength'=>'100']) ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Country<span class="require">*</span></label>
						<?php 
							$options = $this->Custom->getCountriesArray();
							echo $this->Form->select('country', $options, ['class' => 'form-control validate[required]','empty'=>'Select Country','id'=>'country'] ) 
						?>

					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Postcode<span class="require">*</span></label>
						<?php echo $this->Form->text('postcode', ['class' => 'form-control validate[required]','placeholder'=>'Postcode','id'=>'postcode', 'maxlength'=>'10']) ?>
					</div>
				</div>
				
				<div class="col-md-4" id="pass_created" style="display:none;">
					<div class="form-group">
						<label>Password<span class="require">*</span></label>
						<div class="radio">
	  						<label><input type="radio" name="password_type" value="mannual" onChange="choosePassword();"/>Mannual</label>
						</div>
						<div class="radio">	
	  						<label><input type="radio" name="password_type" value="auto" onChange="choosePassword();" checked />Auto-Generated</label>
						</div>
					</div>
				</div>
				<div id="password_show" style="display:none;">
					<div class="col-md-4">
						<div class="form-group">
							<label>Password<span class="require">*</span></label>
							<?php echo $this->Form->password('password', ['class' => 'form-control validate[required]','placeholder'=>'Password','id'=>'password', 'maxlength'=>'20']) ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Confirm Password<span class="require">*</span></label>
							<?php echo $this->Form->password('confirm_password', ['class' => 'form-control validate[required]','placeholder'=>'Confirm Password','id'=>'confirm_password', 'maxlength'=>'20']) ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label>Tickets</label>
					<table class="table table-bordered">
					<?php 
						foreach($event->tickets as $tr_item){

							$filePath = 'uploads'.DS.strtolower($tr_item->source()).DS.'image'.DS.$tr_item->get('upload_dir').DS.$tr_item->get('image');
							$sizeArr = @getimagesize(WWW_ROOT.$filePath);
							$mimeArr = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
							$img = $this->Html->image('../uploads/'.strtolower($tr_item->source()).'/image/' .$tr_item->get('upload_dir'). '/square_' . $tr_item->get('image'));
							
							$ticket_price	=	 $this->Custom->applyAddtionalPrice($tr_item->id,$tr_item['price']);

							?>
							<tr>
								<td style="width:200px;" > 
								<div class="ticket_img">
									<?php echo $img;?>
									</div>
								</td>
								<td style="width:400px;"><?php echo $tr_item['title'];?></td>
								<td style="width:100px;"><?php echo $this->Custom->displayPriceHtml($ticket_price);?></td>
								<td class="action action-sec"><span>Qty:</span>
									<input type="number" name="item_id_qty[]" min='1' max='100' id="id_qty_val_<?php echo $tr_item['id'];?>" class="form-control" value="1"value="1">
								</td>
								<td><input type="button" class ="btn btn-info" name="add_to_cart" value="Add To Cart" id="item_id_cart" data-val="<?php echo $tr_item['id'];?>" onclick="addTicketToCart('<?php echo base64_encode($tr_item["id"]);?>',<?php echo $tr_item['id'];?>);"/></td>
							</tr>
							<?php
							}
						?>
					</table>
				</div>
				
			</div>
			<div class="col-md-12">
				<div class="form-group">
				<label>Products</label>
					
					<table class="table table-bordered">
						<?php 
						foreach($event->products as $pr_item){
							
							$filePath = 'uploads'.DS.strtolower($pr_item->source()).DS.'image'.DS.$pr_item->get('upload_dir').DS.$pr_item->get('image');
							$sizeArr = @getimagesize(WWW_ROOT.$filePath);
							$mimeArr = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
							$img =$this->Html->image('../uploads/'.strtolower($pr_item->source()).'/image/' .$pr_item->get('upload_dir'). '/square_' . $pr_item->get('image'));
						?>
						<tr>
							<td style="width:200px;">
							<div class="ticket_img">
								<?php echo $img;?>
								</div>
							</td>
							<td style="width:400px;"><?php echo $pr_item['title'];?></td>
							<td style="width:100px;"><?php echo $this->Custom->displayPriceHtml($pr_item['price']);?></td>
							<td class="action action-sec"><span>Qty: </span> 
								<input type="number" name="item_type_qty[]" min='1' max='100' id="type_qty_val_<?php echo $pr_item['id'];?>" class="form-control" value="1">
							</td>
							<td ><input type="button" class ="btn btn-info" name="add_to_cart" value="Add To Cart" id="item_type_cart" data-val="<?php echo $pr_item['id'];?>" onclick="addProductToCart('<?php echo base64_encode($pr_item["id"]);?>','<?php echo $pr_item['id'];?>')"/></td>
						</tr>
						<?php
						}
						?>
					</table>
					
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
				<label>Program</label>
					
					<table class="table table-bordered">
						<?php 
						foreach($event->programs as $pm_item){
							
							$filePath = 'uploads'.DS.strtolower($pm_item->source()).DS.'image'.DS.$pm_item->get('upload_dir').DS.$pm_item->get('image');
							$sizeArr = @getimagesize(WWW_ROOT.$filePath);
							$mimeArr = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
							$img =$this->Html->image('../uploads/'.strtolower($pm_item->source()).'/image/' .$pm_item->get('upload_dir'). '/square_' . $pm_item->get('image'));
						?>
						<tr>
							<td style="width:200px;">
							<div class="ticket_img">
								<?php echo $img;?>
								</div>
							</td>
							<td style="width:400px;"><?php echo $pm_item['title'];?></td>
							<td style="width:100px;"><?php echo $this->Custom->displayPriceHtml($pm_item['price']);?></td>
							<td class="action action-sec"><span>Qty: </span> 
								<input type="number" name="item_program_qty[]" min='1' max='100' id="program_qty_val_<?php echo $pm_item['id'];?>" class="form-control" value="1">
							</td>
							<td ><input type="button" class ="btn btn-info" name="add_to_cart" value="Add To Cart" id="item_type_cart" data-val="<?php echo $pm_item['id'];?>" onclick="addProgramToCart('<?php echo base64_encode($pm_item["id"]);?>','<?php echo $pm_item['id'];?>')"/></td>
						</tr>
						<?php
						}
						?>
					</table>
					
				</div>
			</div>
			
		</div>
		
		<div class="box-tools pull-right">
			<?php echo $this->Form->button(__('Checkout'), ['class' => 'btn btn-primary btn-block btn-flat ','id'=>'saveOrderDet']); ?>
		</div>
	</div>
	<?php echo $this->Form->end() ?>
</div>
