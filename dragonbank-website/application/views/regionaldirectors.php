<div class="page-header">
	<h1>Manage Regional Directors 
		<div class="pull-right">
			<div class="btn-group">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-director">Add</button>
			</div>
		</div>
	</h1>
</div>

<div id="search-bar">
	<form method="POST" action="<?php echo base_url(); ?>admin/regionaldirectors/pagin" id="search-form">
		<label for="search">Search Regional Directors</label>
		<input type="search" name="search" id="search" />
		<input type="submit" name="submit" id="submit" />
	</form>
</div>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Company</th>
			<th># of Advisors</th>
			<th>Manage</th>
		</tr>
	</thead>
	<tbody>	
<?php
	foreach ($directors as $k => $v)
	{
?>
		<tr>
			<td><?php echo $v['user_full_name']; ?></td>
			<td><?php echo $v['company']; ?></td>
			<td><a href="<?php echo base_url(); ?>admin/advisors?regional_director_id=<?=$v['id']?>"><?php echo $v['advisorCount']; ?></a></td>
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
	foreach($directors as $k => $v)
	{
?>
<div class="modal fade" id="edit<?= $v['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="codeLabel" aria-hidden="true">
<form class="form-horizontal" role="form" method="POST">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Edit Regional Director</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					
					<label for="company_id" class="col-sm-4 control-label">Company</label>
					<div class="col-sm-8">
<?php
	if ($v['advisorCount'] == 0)
	{
?>
						<select class="form-control" name="director[company_id]" id="company_id">
<?php
		foreach ($companies as $c)
		{
			$select = '';
			if ($v['company_id'] == $c->id)
			{
				$select = ' selected';
			}
?>
							<option value="<?= $c->id?>"<?= $select; ?>><?= $c->name; ?></option>
<?php
		}
?>
						</select>
<?php
	}
	else
	{
?>
							<p class="form-control-static"><?= $v['company']; ?></p>
<?php
	}
?>
					</div>
				</div>
				<div class="form-group">
					<hr>
					<label for="user_full_name" class="col-sm-4 control-label">Full Name</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="user[user_full_name]" id="user_full_name" placeholder="Full Name" value="<?= $v['user_full_name']; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="user_email" class="col-sm-4 control-label">Email</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="user[user_email]" id="user_email" placeholder="Email" value="<?= $v['user_email']; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="user_password" class="col-sm-4 control-label">Password</label>
					<div class="col-sm-8">
						<input type="password" class="form-control" name="user[user_password]" id="user_password" placeholder="Password">
					</div>
				</div>
				<div class="form-group">
					<label for="confirm_password" class="col-sm-4 control-label">Confirm Password</label>
					<div class="col-sm-8">
						<input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
					</div>
				</div>
				<div class="form-group">
					<label for="user_phone" class="col-sm-4 control-label">Phone</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="user[user_phone]" id="user_phone" placeholder="Phone" value="<?= $v['user_phone']; ?>">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="user[user_id]" value="<?= $v['user_id'] ?>">
				<input type="hidden" name="director[id]" value="<?= $v['id'] ?>">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save Changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</form>
</div><!-- /.modal -->
<?php
	}

 /* foreach( $parents as $k => $v): ?>
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
<?php endforeach; */?>

<?php
	if (isset($pagination_links) && !empty($pagination_links))
	{
		echo '<div id="pagination">' . "\n";
		echo $pagination_links;
		echo "\n" . '</div>' . "\n";
	}
?>

<div class="modal fade" id="add-director" tabindex="-1" role="dialog" aria-labelledby="codeLabel" aria-hidden="true">
<form class="form-horizontal" role="form" method="POST">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Add New Regional Director</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					
					<label for="company_id" class="col-sm-4 control-label">Company</label>
					<div class="col-sm-8">
						<select class="form-control" name="director[company_id]" id="company_id">
<?php
	foreach ($companies as $c)
	{
?>
							<option value="<?= $c->id?>"><?= $c->name; ?></option>
<?php
	}
?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<hr>
					<label for="user_full_name" class="col-sm-4 control-label">Full Name</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="user[user_full_name]" id="user_full_name" placeholder="Full Name">
					</div>
				</div>
				<div class="form-group">
					<label for="user_email" class="col-sm-4 control-label">Email</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="user[user_email]" id="user_email" placeholder="Email">
					</div>
				</div>
				<div class="form-group">
					<label for="user_password" class="col-sm-4 control-label">Password</label>
					<div class="col-sm-8">
						<input type="password" class="form-control" name="user[user_password]" id="user_password" placeholder="Password">
					</div>
				</div>
				<div class="form-group">
					<label for="confirm_password" class="col-sm-4 control-label">Confirm Password</label>
					<div class="col-sm-8">
						<input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
					</div>
				</div>
				<div class="form-group">
					<label for="user_phone" class="col-sm-4 control-label">Phone</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="user[user_phone]" id="user_phone" placeholder="Phone">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Add Regional Director</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</form>
</div><!-- /.modal -->