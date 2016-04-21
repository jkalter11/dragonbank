<div class="row top-margin">
	<div class="col-xs-12">
		<ul class="nav nav-tabs">
			<li class="active"><a href="/advisors/clients">Dragon Banks</a></li>
			<li><a href="#">Videos</a></li>
			<li><a href="/advisors/clients/birthdays">Birthdays</a></li>
		</ul>
	</div>
</div>

<table id="clients" class="table table-condensed table-bordered">
	<thead>
		<tr>
			<th>Parent's First Name</th>
			<th>Parent's Last Name</th>
			<th>Child's First Name</th>
			<th>Gender</th>
			<th>Total Logins</th>
			<th>Allowance Frequency</th>
			<th>Allowance Amount</th>
			<th>Den Allocation</th>
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
			<td><?= $c->logincount; ?></td>
			<td><?= ucfirst($c->allowance_frequency); ?></td>
			<td><?= $c->allowance; ?></td>
			<td style="width: 120px">Spend: <?= $c->spend; ?><br>
				Save: <?= $c->save; ?> <br>
				Give: <?= $c->give; ?> </td>
			<td><?= $c->birthday; ?></td>
		</tr>
<?php
		}
	}
	else
	{
?>
		<tr>
			<td colspan="9">You have no clients yet.</td>
		</tr>
<?php		
	}
?>
	</tbody>
</table>