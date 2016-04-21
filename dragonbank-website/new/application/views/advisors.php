<div class="page-header">
	<h1>Manage Advisors
		<div class="pull-right">
			<div class="btn-group">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-advisor">Add</button>
			</div>
		</div>
	</h1>
</div>

<div id="search-bar">
	<form method="POST" action="<?php echo base_url(); ?>admin/advisors/pagin" id="search-form">
		<label for="search">Search Advisors</label>
		<input type="search" name="search" id="search" />
		<input type="submit" name="submit" id="submit" />
	</form>
</div>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Regional Director</th>
			<th>Company</th>
			<th>Parents</th>
			<th>Manage</th>
		</tr>
	</thead>
	<tbody>	
<?php
	foreach ($advisors as $k => $v)
	{
?>
		<tr>
			<td><?php echo (empty($v['user_full_name'])) ? '---' : $v['user_full_name']; ?></td>
			<td><?php echo (empty($v['rdname'])) ? '---' : $v['rdname']; ?></td>
			<td><?php echo (empty($v['company'])) ? '---' : $v['company']; ?></td>
			<td><?php echo $v['parentCount']; ?></td>
			<td>
				<div class="btn-group">
					<button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">Manage <span class="caret"></span></button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#edit<?php echo $v['id']; ?>" data-toggle="modal" data-target="#edit<?php echo $v['id']; ?>">Edit</a></li>
					</ul>
				</div>
			</td>
		</tr>
<?php
	}

/* foreach( $parents as $k => $v): ?>
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
	<?php endforeach; */?>
	</tbody>
</table>
<?php
	foreach ($advisors as $k => $v)
	{
?>
	<div class="modal fade" id="edit<?php echo $v['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="edit1Label" aria-hidden="true">
	<form class="form-horizontal" role="form" id="user-edit" method="POST" enctype="multipart/form-data">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Edit Advisors's info</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="regional_director_id" class="col-sm-4 control-label">Regional Director</label>
						<div class="col-sm-8">
							<select class="form-control" name="advisor[regional_director_id]" id="regional_director_id">
<?php
		foreach ($regionaldirectors as $d)
		{
			$select = '';
			if ($v['regional_director_id'] == $d->id)
			{
				$select = ' selected';
			}
?>
								<option value="<?= $d->id?>"<?= $select; ?>><?= $d->user_full_name; ?></option>
<?php
		}
?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="fullname" class="col-sm-4 control-label">Full Name</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="fullname" name="user[user_full_name]" placeholder="Full Name" value="<?php echo htmlspecialchars($v['user_full_name']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-sm-4 control-label">Email</label>
						<div class="col-sm-8">
							<input type="email" class="form-control" id="email" name="user[user_email]" placeholder="Email" value="<?= htmlspecialchars($v['user_email']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-4 control-label">New Password</label>
						<div class="col-sm-8">
							<input type="password" class="form-control" name="user[user_password]" id="password" placeholder="New Password">
						</div>
					</div>
					<div class="form-group">
						<label for="check-password" class="col-sm-4 control-label">Confirm Password</label>
						<div class="col-sm-8">
							<input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
						</div>
					</div>
					<div class="form-group">
						<label for="phone" class="col-sm-4 control-label">Phone</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="phone" name="user[user_phone]" placeholder="Phone Number" value="<?= htmlspecialchars($v['user_phone']); ?>">
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label for="position" class="col-sm-4 control-label">Position / Title</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="position" name="advisor[position]" placeholder="Position / Title" value="<?= htmlspecialchars($v['position']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="address1" class="col-sm-4 control-label">Address 1</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="address1" name="advisor[address1]" placeholder="Address 1" value="<?= htmlspecialchars($v['address1']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="address2" class="col-sm-4 control-label">Address 2</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="address2" name="advisor[address2]" placeholder="e.g.: suite number" value="<?= htmlspecialchars($v['address2']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="city" class="col-sm-4 control-label">City</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="city" name="advisor[city]" placeholder="City" value="<?= htmlspecialchars($v['city']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="province_id" class="col-sm-4 control-label">Province</label>
						<div class="col-sm-8">
							<select class="form-control" name="advisor[province_id]" id="province_id">
<?php
		foreach ($provinces as $p)
		{
			$select = '';

			if ($p->id == $v['province_id'])
			{
				$select = ' selected';
			}
?>
								<option value="<?= $p->id?>"<?= $select; ?>><?= $p->name; ?></option>
<?php
		}
?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="postalcode" class="col-sm-4 control-label">Postal Code</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="postalcode" name="advisor[postalcode]" placeholder="Postal Code" value="<?= htmlspecialchars($v['postalcode']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="cell" class="col-sm-4 control-label">Cell</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="cell" name="advisor[cell]" placeholder="Cell Number" value="<?= htmlspecialchars($v['cell']); ?>">
						</div>
					</div>

					<div class="form-group">
						<label for="cell" class="col-sm-4 control-label">Fax</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="fax" name="advisor[fax]" placeholder="Fax Number" value="<?= htmlspecialchars($v['fax']); ?>">
						</div>
					</div>

					<div class="form-group">
						<label for="photo" class="col-sm-4 control-label">Photo</label>
						<div class="col-sm-8">
							<img src="<?= ADV_PROFILE_PATH . ((empty($v['photo'])) ? 'default.png' : $v['photo']); ?>" alt="" title="">
							<input type="file" id="photo" name="photo">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="user[user_id]" value="<?php echo $v['user_id']; ?>">
					<input type="hidden" name="advisor[id]" value="<?php echo $v['id']; ?>">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</form>
	</div><!-- /.modal -->
<?php
	}

	if (isset($pagination_links))
	{
		echo '<div id="pagination">' . "\n";
		echo $pagination_links;
		echo "\n" . '</div>' . "\n";
	}
?>

	<div class="modal fade" id="add-advisor" tabindex="-1" role="dialog" aria-labelledby="edit1Label" aria-hidden="true">
	<form class="form-horizontal" role="form" id="user-edit" method="POST" enctype="multipart/form-data">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Add Advisor</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="regional_director_id" class="col-sm-4 control-label">Regional Director</label>
						<div class="col-sm-8">
							<select class="form-control" name="advisor[regional_director_id]" id="regional_director_id">
<?php
		foreach ($regionaldirectors as $d)
		{
?>
								<option value="<?= $d->id?>"><?= $d->user_full_name; ?></option>
<?php
		}
?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="fullname" class="col-sm-4 control-label">Full Name</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="fullname" name="user[user_full_name]" placeholder="Full Name">
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-sm-4 control-label">Email</label>
						<div class="col-sm-8">
							<input type="email" class="form-control" id="email" name="user[user_email]" placeholder="Email">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-4 control-label">New Password</label>
						<div class="col-sm-8">
							<input type="password" class="form-control" name="user[user_password]" id="password" placeholder="New Password">
						</div>
					</div>
					<div class="form-group">
						<label for="check-password" class="col-sm-4 control-label">Confirm Password</label>
						<div class="col-sm-8">
							<input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
						</div>
					</div>
					<div class="form-group">
						<label for="phone" class="col-sm-4 control-label">Phone</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="phone" name="user[user_phone]" placeholder="Phone Number">
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label for="position" class="col-sm-4 control-label">Position / Title</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="position" name="advisor[position]" placeholder="Position / Title">
						</div>
					</div>
					<div class="form-group">
						<label for="address1" class="col-sm-4 control-label">Address 1</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="address1" name="advisor[address1]" placeholder="Address 1">
						</div>
					</div>
					<div class="form-group">
						<label for="address2" class="col-sm-4 control-label">Address 2</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="address2" name="advisor[address2]" placeholder="e.g.: suite number">
						</div>
					</div>
					<div class="form-group">
						<label for="city" class="col-sm-4 control-label">City</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="city" name="advisor[city]" placeholder="City">
						</div>
					</div>
					<div class="form-group">
						<label for="province_id" class="col-sm-4 control-label">Province</label>
						<div class="col-sm-8">
							<select class="form-control" name="advisor[province_id]" id="province_id">
<?php
		foreach ($provinces as $p)
		{
?>
								<option value="<?= $p->id?>"><?= $p->name; ?></option>
<?php
		}
?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="postalcode" class="col-sm-4 control-label">Postal Code</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="postalcode" name="advisor[postalcode]" placeholder="Postal Code">
						</div>
					</div>
					<div class="form-group">
						<label for="cell" class="col-sm-4 control-label">Cell</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="cell" name="advisor[cell]" placeholder="Cell Number">
						</div>
					</div>

					<div class="form-group">
						<label for="cell" class="col-sm-4 control-label">Fax</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="fax" name="advisor[fax]" placeholder="Fax Number">
						</div>
					</div>

					<div class="form-group">
						<label for="photo" class="col-sm-4 control-label">Photo</label>
						<div class="col-sm-8">
							<input type="file" id="photo" name="photo">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Add Advisor</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</form>
	</div><!-- /.modal -->
