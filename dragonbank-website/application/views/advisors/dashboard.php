<p>This dashboard provides you with a quick overivew and statistics on the impact your Dragon Bank Program is having in your community. <strong><em>Congratulations on your efforts!</em></strong></p>

<div id="dashboard-stats">
		<div id="total-main">
<?php
	$companyData = $this->session->userdata('companyData');
	if (!empty($companyData['logo']))
	{
?>
		<img src="<?= COMPANY_PROFILE_PATH . $companyData['logo']; ?>" alt="" title="">
<?php
	}
?>
		<em><?= $this->session->userdata('user_name'); ?></em>
	</div>

	<div id="total-spend-amount" class="stat-block">
		Total Spend<br>Amount<br>
		<em>${totalspendamount}</em>
	</div>

	<div id="total-save-amount" class="stat-block">
		Total Save<br>Amount<br>
		<em>${totalsaveamount}</em>
	</div>

	<div id="total-give-amount" class="stat-block">
		Total Give<br>Amount<br>
		<em>${totalgiveamount}</em>
	</div>

	<div id="total-impressions" class="stat-block">
		Total<br>Impressions<br>
		<em>{totalimpressions}</em>
	</div>

	<div id="total-birthdays" class="stat-block">
		Total Birthdays<br>This Month<br>
		<em>{totalbirthdays}</em>
		<a href="/advisors/clients/birthdays">Click here to view</a>
	</div>

	<div id="total-money" class="stat-block">
		Total Money<br>in Banks<br>
		<em>${totalbalance}</em>
	</div>
</div>

<table class="table table-condensed table-bordered">
	<tbody>
		<tr>
			<td>Total Parents:</td>
			<td>{parentcount}</td>
			<td>Total Weekly Allowance:</td>
			<td>${totalweeklyallowance}</td>
		</tr>
		<tr>
			<td>Total Kids:</td>
			<td>{childrencount}</td>
			<td>Total Monthly Allowance:</td>
			<td>${totalmonthlyallowance}</td>
		</tr>
		<tr>
			<td>Number of Boys:</td>
			<td>{malecount}</td>
			<td>Average Time Logged In:</td>
			<td>{averagetimeloggedin}</td>
		</tr>
		<tr>
			<td>Number of Girls:</td>
			<td>{femalecount}</td>
			<td>Average Spend Amount:</td>
			<td>${averagespendamount}</td>
		</tr>
		<tr>
			<td>Average Age of Children:</td>
			<td>{averageage}</td>
			<td>Average Save Amount:</td>
			<td>${averagesaveamount}</td>
		</tr>
		<tr>
			<td>Total Number of Logins:</td>
			<td>{logincount}</td>
			<td>Average Give Amount:</td>
			<td>${averagegiveamount}</td>
		</tr>
		<tr>
			<td>Average Logins Per Account:</td>
			<td>{averagelogins}</td>
			<td>Average Allowance Paid:</td>
			<td>${averageallowancepaid}</td>
		</tr>
	</tbody>
</table>