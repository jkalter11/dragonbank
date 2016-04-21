<div class="row top-margin">
	<div class="col-xs-12">
		<ul class="nav nav-tabs">
			<li><a href="/advisors/clients">Dragon Banks</a></li>
			<li><a href="#">Videos</a></li>
			<li class="active"><a href="/advisors/clients/birthdays">Birthdays</a></li>
		</ul>
	</div>
</div>

<table id="birthdays" class="table table-condensed table-bordered">
	<thead>
		<tr>
			<th>Parent's First Name</th>
			<th>Parent's Last Name</th>
			<th>Child's First Name</th>
			<th>Gender</th>
			<th>Parent's Email</th>
			<th>Total Logins</th>
			<th>Age</th>
			<th style="width: 100px;">Birthdate</th>
		</tr>
	</thead>
	<tbody>
<?php
	if (count($children))
	{
		foreach ($children as $c)
		{
			$childname = explode(' ', $c->user_full_name);
			$parentname = explode(' ', $c->parentname);
?>
		<tr>
			<td><?= $parentname[0]; ?></td>
			<td><?= $parentname[1]; ?></td>
			<td><?= $childname[0]; ?></td>
			<td><?= $c->gender; ?></td>
			<td><a href="mailto:<?= $c->user_email; ?>"><?= $c->user_email; ?></a></td>
			<td><?= $c->logincount; ?></td>
			<td><?= $c->age; ?></td>
			<td><?= $c->birthday; ?></td>
		</tr>
<?php
		}
	}
	else
	{
?>
		<tr>
			<td colspan="8">There are no children with birthdays this month.</td>
		</tr>
<?php		
	}
?>
	</tbody>
</table>