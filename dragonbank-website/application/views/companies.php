<div class="page-header">
	<h1>Manage Companies
		<div class="pull-right">
			<div class="btn-group">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-company">Add</button>
			</div>
		</div>
	</h1>
</div>

<div id="search-bar">
	<form method="POST" action="<?php echo base_url(); ?>admin/companies/pagin" id="search-form">
		<label for="search">Search Companies</label>
		<input type="search" name="search" id="search" />
		<input type="submit" name="submit" id="submit" />
	</form>
</div>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th># of Regional Directors</th>
			<th># of Advisors</th>
			<th>Manage</th>
		</tr>
	</thead>
	<tbody>	
<?php
	foreach ($companies as $k => $v)
		//var_dump($v);
	{
?>
		<tr>
			<td><?php echo $v['name']; ?></td>
			<td><a href="<?php echo base_url(); ?>admin/regionaldirectors?company_id=<?php echo $v['id']; ?>"><?php echo $v['directorCount']; ?></a></td>
			<td><a href="<?php echo base_url(); ?>admin/advisors?company_id=<?php echo $v['id']; ?>"><?php echo $v['advisorCount']; ?></a></td>
			<td>
				<div class="btn-group">
					<button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">Manage <span class="caret"></span></button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#edit<?php echo $v['id']; ?>" data-toggle="modal" data-target="#edit<?php echo $v['id']; ?>">Edit</a></li>
<?php 

	if ($v['advisorCount'] === 0 && $v['directorCount'] === 0)
	{
?>
						<li class="divider"></li>
						<li><a href="/admin/parenting/delete/<?= $v['id']; ?>">Delete</a></li>
<?php
	}
?>
						
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
	foreach($companies as $k => $v) 
	{
?>
<div class="modal fade" id="edit<?=$v['id']?>" tabindex="-1" role="dialog" aria-labelledby="edit1Label" aria-hidden="true">
<form class="form-horizontal" role="form" id="user-edit" method="POST" enctype="multipart/form-data">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Edit Company's info</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="companyname" class="col-sm-4 control-label">Company Name</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="fullname" name="company[name]" placeholder="Company Name" value="<?= htmlspecialchars($v['name']); ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="companylogo" class="col-sm-4 control-label">Company Logo</label>
					<div class="col-sm-8">
<?php
		if (!empty($v['logo']))
		{
?>
						<img src="<?= COMPANY_PROFILE_PATH . $v['logo']; ?>" alt="<?= $v['name']; ?>"  title="<?= $v['name']; ?>">
<?php
		}
?>
						<input type="file" name="logo" id="companylogo">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="company[id]" value="<?= $v['id'] ?>">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</form>
</div><!-- /.modal -->
<?php
	}

	if (isset($pagination_links) && !empty($pagination_links))
	{
		echo '<div id="pagination">' . "\n";
		echo $pagination_links;
		echo "\n" . '</div>' . "\n";
	}

?>


<div class="modal fade" id="add-company" tabindex="-1" role="dialog" aria-labelledby="codeLabel" aria-hidden="true">
<form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Add New Company</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="companyname" class="col-sm-4 control-label">Company Name</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="company[name]" id="companyname" placeholder="Company Name">
					</div>
				</div>
				<div class="form-group">
					<label for="companylogo" class="col-sm-4 control-label">Company Logo</label>
					<div class="col-sm-8">
						<input type="file" name="logo" id="companylogo">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Create</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</form>
</div><!-- /.modal -->