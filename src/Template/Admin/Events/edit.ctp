<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Edit Event</h3>
	</div>
	<?php echo $this->Form->create($event, ['id' => 'form_id','type' => 'file']) ?>
	<div class="box-body">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label>Name <span class="require">*</span></label>
					<?php echo $this->Form->text('title', ['class' => 'form-control validate[required]', 'maxlength' => 200]) ?>
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
					<label>Venue <span class="require">*</span></label>
					<?php echo $this->Form->textarea('venue', ['class' => 'form-control validate[required]']) ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Date/Time <span class="require">*</span></label>
					<div class='input-group date datetimepicker' >
						<?php  $date_time	=	$this->Custom->inputDateTimeFormat($event['date_time']); ?>
						<?php echo $this->Form->text('date_time', ['class' => 'form-control validate[required]','value'=>$date_time]) ?>
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Change Date/Time</label>
					<div class='input-group date datetimepicker' >
						<?php  $change_date_time	=	$this->Custom->inputDateTimeFormat($event['change_date_time']); ?>
						<?php echo $this->Form->text('change_date_time', ['class' => 'form-control','value'=>$change_date_time]) ?>
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Barcode Prefix</label>
					<?php echo $this->Form->text('barcode_prefix', ['class' => 'form-control', 'maxlength' => 5]) ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Status <span class="require">*</span></label>
					<?php 
						$options = ['1' => 'Active', '0' => 'Inactive'];
						echo $this->Form->select('status', $options, ['class' => 'form-control'] ) 
					?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Featured Image <span class="require">*</span></label>
					<?php echo $this->Form->input('image', ['type'=>'file','class'=>'form-control',  'label'=>false, 'templates' => ['inputContainer'=>'{{content}}'],'error'=>false]); ?>
				</div>
				<div class="form-group">
					<?php
						$filePath = 'uploads'.DS.strtolower($event->source()).DS.'image'.DS.$event->get('upload_dir').DS.$event->get('image');
						$sizeArr = @getimagesize(WWW_ROOT.$filePath);
						$mimeArr = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
						echo $this->Html->image('../uploads/'.strtolower($event->source()).'/image/' .$event->get('upload_dir'). '/square_' . $event->get('image'));
					?>
				</div>
			</div>
			
			<div class="clear"></div>
			<div class="col-md-6">
				<div class="form-group">
					<label>More Images (<strong>Allowed extensions</strong>: .gif, .jpeg, .png, .jpg) :</label>
					<?php echo $this->Form->input('uploads.0.file', ['type'=>'file','rows'=>'5','cols'=>'5','class'=>'form-control',  'label'=>false, 'templates' => ['inputContainer'=>'{{content}}'],'error'=>false]); ?>
				</div>
				<div class="form-group">
					<ul class="fileList">
						<?php
							//echo "<pre>"; print_r($ticket->ticket_uploads); echo "</pre>";
							foreach($event->uploads as $k=>$upload){
								$filePath = 'uploads'.DS.strtolower($upload->source()).DS.'file'.DS.$upload->get('upload_dir').DS.$upload->get('file');
								//check if file uploaded was image then preview the image file other wise create the links
								$mime = @mime_content_type(WWW_ROOT.$filePath);
							        $mimeArr = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
								if(in_array($mime,$mimeArr)){
									echo '<li><a href="javascript:void(0);" class="removeImage" data-controller="events" rel='.$upload->get('id').' ><i class="glyphicon glyphicon-remove"></i></a>'.$this->Html->image('../uploads/'.strtolower($upload->source()).'/file/' .$upload->get('upload_dir'). '/square_' . $upload->get('file'));
									//for updating associated model we need to define this 
									echo $this->Form->hidden("uploads.$k.id",['value'=>$upload->id]);
									echo '</li>';
									
								} 
								
							}
						?>
					</ul>
				</div>
			</div>
			<div class="col-md-6">
				<label>&nbsp;</label><br />
				<span class="button btn btn-primary btn-flat" id="add_more_file">Add More Images</span>
			</div>
			<div class="col-md-12">
				<div class="row">
					<div id="file"></div>
				</div>
			</div>
		</div>
		<div class="box-tools pull-right">
			<?php echo $this->Form->button(__('Submit'), ['class' => 'btn btn-primary btn-block btn-flat']); ?>
		</div>
	</div>
	<?php echo $this->Form->end() ?>
</div>
<script>
	var rowCount = 0;
	$("#add_more_file").click(function(){
		rowCount++;
		$.ajax({
			type:"POST",
			url:"<?php echo $this->Url->build(["prefix"=>'admin',"controller" => "Events","action" => "add_new_field"]);?>/"+rowCount ,
			dataType: 'text',
			async:false,
			success: function(response){
				$('#file').append(response);
			},
			error: function (response) {
				alert('error');
			}
		});
	});
</script>
