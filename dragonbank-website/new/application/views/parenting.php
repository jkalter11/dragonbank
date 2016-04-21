<div class="page-header">
	<h1>Manage Parents <small>manage parents list</small></h1>
</div>

<div id="search-bar">
	<form method="POST" action="<?php echo base_url(); ?>admin/parenting/pagin" id="search-form">
		<label for="search">Search Parents</label>
		<input type="search" name="search" id="search" />
		<input type="submit" name="submit" id="submit" />
	</form>
</div>

<table class="table table-striped">
	<thead>
	<tr>
		<th>Name</th>
		<th>Email</th>
		<th>Account Creation Date</th>
		<th>Total Logins</th>
		<th>Number of Children</th>
		<th>Number of Children with Accounts</th>
		<th>View Children</th>
		<th>Manage</th>
	</tr>
	</thead>
	<tbody><?php //echo "<pre>"; print_r($parents); exit; ?>
	<?php foreach( $parents as $k => $v): ?>
		<tr <?php if( $v['status'] != 1 ): echo "class='danger'"; endif; ?> >
			<td><?= $v['user_full_name'] ?></td>
			<td width="110" ><a href="mailto:"><?= $v['user_email'] ?></a></td>
			<td><?php echo date("M jS Y", strtotime($v['registration_date'])); ; ?></td>
			<td><?php echo $v['logins']; ?></td>
			<td><?= $v['kids'] ?></td>
			<td width="90"><a href="<?php echo base_url(); ?>admin/children?parent_id=<?=$v['parent_id']?>"><?= $v['active_kids'] ?></a></td>
			<td><a href="<?php echo base_url(); ?>admin/children?parent_id=<?=$v['parent_id']?>">View</a></td>
			<td>
				<div class="btn-group">
					<button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">Manage <span class="caret"></span></button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#edit<?=$v['parent_id']?>" data-toggle="modal" data-target="#edit<?=$v['parent_id']?>">Edit</a></li>
						<?php if( $v['status'] == 2 ): ?>
							<li><a href="<?php echo base_url(); ?>admin/status?<?=$ret?>&amp;parent_user_id=<?= $v['user_id'] ?>&amp;status=1">Activate</a></li>
						<?php else: ?>
							<li><a href="<?php echo base_url(); ?>admin/status?<?=$ret?>&amp;parent_user_id=<?= $v['user_id'] ?>&amp;status=2">Suspend</a></li>
						<?php endif; ?>
						<li class="divider"></li>

						<?php if( $v['status'] == 0 ): ?>
							<li><a href="<?php echo base_url(); ?>admin/status?<?=$ret?>&amp;parent_user_id=<?= $v['user_id'] ?>&amp;status=1">Activate</a></li>
						<?php else: ?>
							<li><a href="<?php echo base_url(); ?>admin/status?<?=$ret?>&amp;parent_user_id=<?= $v['user_id'] ?>&amp;status=0">Delete</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php foreach( $parents as $k => $v): ?>
	<div class="modal fade" id="edit<?=$v['parent_id']?>" tabindex="-1" role="dialog" aria-labelledby="edit1Label" aria-hidden="true">
		<form class="form-horizontal" role="form" id="user-edit" method="POST">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Edit Parent's info</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="fullname" class="col-sm-4 control-label">Full Name</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="fullname" name="user_info[user_full_name]" placeholder="Full Name" value="<?= htmlspecialchars($v['user_full_name']); ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="col-sm-4 control-label">Email</label>
							<div class="col-sm-8">
								<input type="email" class="form-control" id="email" name="user_info[user_email]" placeholder="Email" value="<?= htmlspecialchars($v['user_email']); ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="phone" class="col-sm-4 control-label">Phone</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="phone" name="user_info[user_phone]" placeholder="Phone Number" value="<?= htmlspecialchars($v['user_phone']); ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="children" class="col-sm-4 control-label">Number of Children</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="children" name="user_info[kids]" placeholder="Number of Children" value="<?= (int)$v['kids'] ?>">
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
						<input type="hidden" name="user_info[user_id]" value="<?= $v['parent_user_id'] ?>">
						<input type="hidden" name="user_info[parent_id]" value="<?= $v['parent_id'] ?>">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</form>
	</div><!-- /.modal -->
<?php endforeach;

	if (isset($pagination_links) && !empty($pagination_links))
	{
		echo '<div id="pagination">' . "\n";
		echo $pagination_links;
		echo "\n" . '</div>' . "\n";
	}
 ?>