<div class="box-body">
	<table class="table table-bordered">
		<tr>
			<th class="sno">#</th>
			<th>Customer Name</th>
			<th>Email</th>
			<th>Address</th>
			<th>Contact Number</th>
			
		</tr>
<?php 
		if(count($customers)>0) {
			//$count = $this->Paginator->params()['perPage'];
			//$page = $this->Paginator->params()['page'];
			$i = 1; //(( $page - 1) * $count) + 1 ;
			foreach($customers as $item) {
				$id = $item['id'];
				$class="btn btn-danger btn-xs";
				$stType="Inactive";
				$stVal=1;
				if($item['status']==1)
				{
					$class="btn btn-success btn-xs";
					$stType="Active";
					$stVal=0;
				}
				$title = $this->Custom->displayCutomerTitle($item['title']);
			?>    
			<tr>
				<td>
					<div class="radio">
  						<label><input type="radio" name="selected_user" value="<?php echo $item['id']; ?>" onchange = "getSelectedCustomer('<?php echo addslashes($item['id']); ?>','<?php echo addslashes($item['first_name']); ?>','<?php echo addslashes($item['last_name']); ?>','<?php echo addslashes($item['address1']); ?>','<?php echo addslashes($item['address2']); ?>','<?php echo addslashes($item['town']); ?>','<?php echo addslashes($item['county']); ?>','<?php echo addslashes($item['country']); ?>','<?php echo addslashes($item['postcode']); ?>','<?php echo addslashes($item['email']); ?>','<?php echo addslashes($item['title']); ?>','<?php echo addslashes($item['contact_number']);?>');"/></label>
  					</div>
  				</td>
				<td><?php echo $item['title']; ?> <?php echo $item['first_name']; ?> <?php echo $item['last_name']; ?></td>
				<td><?php echo $item['email']; ?></td>
				<td>
					<?php echo $item['address1']; ?> <?php echo $item['address2']; ?> <?php echo $item['town']; ?> <?php echo $item['county']; ?> <br /><?php echo $item['country']; ?> <?php echo $item['postcode']; ?>
				</td>
				<td><?php echo $item['contact_number']; ?></td>
				
			</tr>
			<?php 
				$i++;
			}
		}
	else {
		echo '<tr><td  colspan="5" align="center"><i>No results found!</i></td></tr>';
	}
?>
	</table>
</div>
