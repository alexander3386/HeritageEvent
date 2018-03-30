<style>
  .table td{vertical-align: middle !important;}
</style>
<div class="row">
  <div class="col-md-12">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Manage Users</h3>
			<span class="add_btn">
			<a href="<?php echo $this->Url->build(['controller' => 'users', 'action' => 'add'])?>" class="btn btn-success btn-sm">Add New</a></span>
		</div>
		<?php echo $this->Form->create($form,['url' => ['controller' =>'users', 'action' => 'index'], 'id' => 'form_id', 'type' => 'get']) ?>
		<div class="box-body">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>Email </label>
						<?php echo $this->Form->text('search_email', ['class' => 'form-control', 'placeholder' => 'Search by Email']); ?>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Name </label>
						<?php echo $this->Form->text('search_name', ['class' => 'form-control', 'placeholder' => 'Search by name']); ?>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Role </label>
						<?php 
						 $options = ['A' => 'All','superadmin' => 'Superadmin', 'heritage_admin' => 'Heritage Admin','lead_castle_admin'=>'Lead Castle Admin'];
						$role	='A';
						if(isset($this->request->data['role'])){
							$role	=	$this->request->data['role'];
						}
						echo $this->Form->select('role', $options, ['class' => 'form-control','value'=>$role] )
						?>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Status </label>
						<?php 
						$options = ['A'=>'All','1' => 'Active', '0' => 'Inactive'];
						$status	='A';
						if(isset($this->request->data['status'])){
							$status	=	$this->request->data['status'];
						}
						echo $this->Form->select('status', $options, ['class' => 'form-control','value'=>$status] )
						?>
					</div>
				</div>
				
				<div class="col-md-3">
					<div class="form-group"><br />
						<div class="box-tools ">
							<div class="col-md-8">
								<?php echo $this->Form->button(__('Submit'), ['class' => 'btn btn-primary btn-block btn-flat']); ?>
							</div>
							<div class="col-md-4">
								<?php echo $this->Html->link(__('Reset'), ['controller' => 'users', 'action' => 'index'], ['class' => 'btn btn-danger btn-flat'] ); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php echo $this->Form->end() ?>
		<div class="box-body">
			<table class="table table-bordered">
				 <tr>
					<th class="sno">#</th>
					<th>Name</th>
					<th>Email</th>
					<th style="width:200px;">Role</th>
					<th class="status">Status</th>
					<th class="action">Action</th>
				 </tr>
				<?php
				//echo "<pre>";
				//print_r($users); 
				if(count($users) > 0) {
					$count = $this->Paginator->params()['perPage'];
					$page = $this->Paginator->params()['page'];
					$i =  (( $page - 1) * $count) + 1 ;
					foreach($users as $item) {
						$id = $item['id'];
						$class="btn btn-danger btn-xs";
						$stType="Inactive";
						$stVal=1;
						if($item['status']=='1')
						{
							$class="btn btn-success btn-xs";
							$stType="Active";
							$stVal=0;
						}
					
						$role = str_replace('_',' ',$item['role']);
					?>    
					<tr>
						<td><?php echo $i; ?></td>
						
						<td><?php echo ucfirst($item['first_name']).' '.ucfirst($item['last_name']); ?></td>
						
						<td><?php echo $item['email']; ?></td>
						<td><?php echo ucfirst($role); ?></td>
						<td >
							<span id="status_<?php echo $id; ?>">
							<a href="javascript:changeStatus('users', <?php echo $id; ?>,<?php echo $stVal; ?>);" class="<?php echo $class; ?>"><?php echo $stType; ?></a>
							</span>
						</td>
						
						<td align="center" class="action">
							<a class="btn btn-info btn-xs" title="Edit" href="<?php echo $this->Url->build(['controller' => 'users', 'action' => 'edit/'.$id])?>">
								<i class="glyphicon glyphicon-edit"></i>
							</a>
							<a class="btn btn-info btn-xs" title="Delete" onclick='return confirm("Are you sure you want to delete this.")' href="<?php echo $this->Url->build(['controller' => 'users', 'action' => 'delete/'.$id])?>">
								<i class="glyphicon glyphicon-remove"></i>
							</a>
						</td>
					</tr>
					<?php 
						$i++;
					}
				}
			else {
				echo '<tr><td  colspan="6" align="center"><i>No results found!</i></td></tr>';
			}
		?>
			</table>
		</div>
		<div class="box-footer clearfix">
			<ul class="pagination pagination-sm no-margin pull-right">
				  <?php echo $this->Paginator->prev(' << '); ?>
				  <?php echo $this->Paginator->numbers(); ?>
				  <?php echo $this->Paginator->next(' >> '); ?>
			</ul>
		</div>
	</div>
    </div>
   </div>