
<div class="container-fluid home-slider">
	<div class="row ">
		<div class="owl-carousel owl-theme" id="home-slider">
			<?php
				if($event->uploads){
					foreach($event->uploads as $k=>$upload){
						$filePath = 'uploads'.DS.strtolower($upload->source()).DS.'file'.DS.$upload->get('upload_dir').DS.$upload->get('file');
						//check if file uploaded was image then preview the image file other wise create the links
						$mime = @mime_content_type(WWW_ROOT.$filePath);
						$mimeArr = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
						if(in_array($mime,$mimeArr)){
			?>			
					<div class="item"><?php echo $this->Html->image('../uploads/'.strtolower($upload->source()).'/file/' .$upload->get('upload_dir'). '/' . $upload->get('file'))?>
						<div class="banner-caption">
							<h2><?php echo $event->title;?></h2>
							<p class="date"><?php echo $this->Custom->displayDateFormat($event->date_time); ?></p>
						</div>
					</div>	
			<?php			
						} 
					}
				}
			?>
		</div>
	</div>
</div>
