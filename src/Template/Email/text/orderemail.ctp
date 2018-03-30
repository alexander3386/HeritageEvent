<style>

.table{
    border: 1px solid black;
    width:60%;
    line-height:30px;
    word-wrap: break-word;
    border-collapse: initial !important;
}
.table-head{
	background-color:#dad7d7;
}
</style>

<table class="table" align="center">
	<tr>
		<td style="text-align:center;"><h1>HERITAGE SPECIAL EVENTS</h1></td>
	</tr>
	<tr>
		<td><p>Dear <?php echo $name; ?></p></td>
	</tr>
	<tr>
		<td>
			<p>Thank you for your purchase for the Leeds Castle Classical Concert which is itemised below:</p>
		</td>
	</tr>
	<tr>
		<td>
			<table style="width:80%;" align="center">
				<tr class="table-head">
					<th>Description	</th>
					<th>Quantity	</th>
					<th>Amount	</th>
				</tr>
				<?php 
					foreach($orders as $item){
					?>
						<tr>
							<td><?php echo $item['name'];?></td>
							<td><?php echo $item['qty'];?></td>
							<td><?php echo $item['amount'];?></td>
						</tr>
					<?php
					}
				?>
				<tr>
					<td>&nbsp;</td>
					<td class="table-head"> TOTAL</td>
					<td class="table-head"> <?php echo $total_amount;?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<p>IMPORTANT: Please check the website information to see when your tickets will be dispatched. Each ticket has a unique security barcode which will only admit one person, other attempts with the same ticket will be rejected. Our standard terms and conditions apply. For further information please go to <a href="http://www.leedscastleconcert.co.uk" target = "_blank">http://www.leedscastleconcert.co.uk</a></p>
		</td>
	</tr>
</table>