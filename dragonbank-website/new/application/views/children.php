<div class="page-header">
	<h1>Manage Children <small>manage children list</small></h1>
</div>

<div id="search-bar">
	<form method="POST" action="<?php echo base_url(); ?>admin/children/pagin" id="search-form">
		<label for="search">Search</label>
		<input type="search" name="search" id="search" />
		<input type="submit" name="submit" id="submit" />
	</form>
</div>

<table class="table table-striped">
	<thead>
	<tr>
		<th>Name</th>
		<th>Sex</th>
		<th>Parent Name</th>
		<th>Allowance Frequency</th>
		<th>Allowance Amount</th>
		<th>Birthday</th>
		<th>Allocation</th>
		<th class="text-right">Manage</th>
	</tr>
	</thead>
	<tbody>
	<?php //echo "<pre>"; print_r($children); exit; ?>
	<?php foreach( $children as $k => $v ): ?>

		<tr <?php if( $v['status'] != 1 ){ echo "class='danger'"; } ?> >
			<td><?= $v['user_full_name'] ?></td>
			<td><?php echo ($v['gender'] == "Male")? "M" : "F"; ?></td>
			<td width="90"><?php echo $v['parent_name']; ?></td>
			<td width="42"><?php echo ($v['allowance_frequency'] == "WEEK")? "W" : "M"; ?></td>
			<td width="100"><?php echo "$".number_format($v['allowance'], 2, ".", ","); ?></td>
			<td><?php echo date("M jS Y", strtotime($v['birthday'])); ?></td>
			<td>
				<ul class="list-unstyled">
					<li>Spend <span class="label label-danger pull-right">$ <?= $v['spend_amount'] ?></span></li>
					<li>Save <span class="label label-success pull-right">$ <?= $v['save_amount'] ?></span></li>
					<li>Give <span class="label label-primary pull-right">$ <?= $v['give_amount'] ?></span></li>
				</ul>
			</td>
			<td>
				<div class="btn-group pull-right">
					<button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">Manage <span class="caret"></span></button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#history<?= $v['child_id'] ?>" data-toggle="modal" data-target="#history<?= $v['child_id'] ?>" onclick="getHistory(<?= $v['child_id'] ?>)">History</a></li>
						<li><a href="#edit<?= $v['child_id'] ?>" data-toggle="modal" data-target="#edit<?= $v['child_id'] ?>">Edit</a></li>

						<?php if( $v['status'] == 2 ): ?>
							<li><a href="<?php echo base_url(); ?>admin/status?<?=$ret?>&amp;child_user_id=<?= $v['user_id'] ?>&amp;status=1">Activate</a></li>
						<?php else: ?>
							<li><a href="<?php echo base_url(); ?>admin/status?<?=$ret?>&amp;child_user_id=<?= $v['user_id'] ?>&amp;status=2">Suspend</a></li>
						<?php endif; ?>
						<li class="divider"></li>

						<?php if( $v['status'] == 0 ): ?>
							<li><a href="<?php echo base_url(); ?>admin/status?<?=$ret?>&amp;child_user_id=<?= $v['user_id'] ?>&amp;status=1">Activate</a></li>
						<?php else: ?>
							<li><a href="<?php echo base_url(); ?>admin/status?<?=$ret?>&amp;child_user_id=<?= $v['user_id'] ?>&amp;status=0">Delete</a></li>
						<?php endif; ?>

					</ul>
				</div>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<? foreach( $children as $k => $v ): ?>
	<div class="modal fade" id="edit<?= $v['child_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="edit1Label" aria-hidden="true">
		<form class="form-horizontal" role="form" id="user-edit" method="POST">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Edit Children's Info</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="fullname" class="col-sm-4 control-label">Full Name</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="user_info[user_full_name]" id="fullname" placeholder="Full Name" value="<?= $v['user_full_name'] ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="col-sm-4 control-label">Email</label>
							<div class="col-sm-8">
								<input type="email" class="form-control" name="user_info[user_email]" id="email" placeholder="Email" value="<?=$v['user_email']?>">
							</div>
						</div>
						<h4>Allocations</h4>
						<div class="form-group">
							<label for="spend" class="col-sm-4 control-label">Spend Amount</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="user_info[spend]" id="spend" placeholder="Spend Amount" value="<?= $v['spend'] ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="save" class="col-sm-4 control-label">Save Amount</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="user_info[save]" id="save" placeholder="Save Amount" value="<?= $v['save'] ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="give" class="col-sm-4 control-label">Give Amount</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="user_info[give]" id="give" placeholder="Give Amount" value="<?= $v['give'] ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="birth" class="col-sm-4 control-label">Birth Date</label>
							<div class="col-sm-8">
								<input type="text" class="form-control datepicker" name="user_info[birthday]" id="birth" placeholder="Birth Date" value="<?= $v['birthday'] ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="gender" class="col-sm-4 control-label">Gender</label>
							<div class="col-sm-8">
								<select class="form-control" name="user_info[gender]">
									<option value="Male" <?php if($v['gender'] == "Male"): echo "selected='selected'"; endif; ?> >Male</option>
									<option value="Female" <?php if($v['gender'] == "Female"): echo "selected='selected'"; endif; ?> >Female</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="password" class="col-sm-4 control-label">New Password</label>
							<div class="col-sm-8">
								<input type="password" class="form-control" name="user_info[password]" id="password" placeholder="New Password">
							</div>
						</div>
						<div class="form-group">
							<label for="check-password" class="col-sm-4 control-label">Verify New Password</label>
							<div class="col-sm-8">
								<input type="password" class="form-control" name="user_info[check-password]" id="check-password" placeholder="Verify New Password">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="user_info[user_id]" value="<?= $v['user_id'] ?>">
						<input type="hidden" name="user_info[child_id]" value="<?= $v['child_id'] ?>">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</form>
	</div><!-- /.modal -->

	<div class="modal fade" id="history<?= $v['child_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="history1Label" aria-hidden="true">
		<form class="form-horizontal" role="form">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Transaction History</h4>
					</div>
					<div class="modal-body">
						<table class="table table-striped history-table">
							<thead>
							<tr>
								<th>Date</th>
								<th>Transaction</th>
								<th>Money In/Out</th>
								<th>Balance</th>
								<th>Description</th>
							</tr>
							</thead>
							<tbody id="history-body<?= $v['child_id'] ?>">
							<!-- Populated via jQuery ajax. -->
							</tbody>
						</table>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</form>
	</div><!-- /.modal -->
<?php 
	endforeach;
	
	if (isset($pagination_links) && !empty($pagination_links))
	{
		echo '<div id="pagination">' . "\n";
		echo $pagination_links;
		echo "\n" . '</div>' . "\n";
	}
?>