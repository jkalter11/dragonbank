				<div class="row">
					<div class="col-content clearfix">
						<div class="col-sm-9 border-right">
							
							<h1>History</h1>
<?php
	display_message(85);
?>

							<div id="sub-nav">
								<a href="/new/profile/deposit<?= $get; ?>" class="btn btn-primary btn-xs">Deposit</a>
								<a href="/new/profile/withdraw<?= $get; ?>" class="btn btn-primary btn-xs">Withdraw</a>
								<a href="/new/profile/history<?= $get; ?>" class="btn btn-danger btn-xs">History</a>
								<a href="/new/profile/wishlist<?= $get; ?>" class="btn btn-primary btn-xs">Wishlist</a>
							</div>
							
							<h4><span class="text-success">Total Dens Balance: $<?=$balance?></span> <strong>as of today <?=date("F d, Y");?></strong></h4>
							<p><?php 
								if( (float)$allowance > 0.00 && isset( $allowance_paydate ) && $allowance_paydate !== NULL ):
									echo "$". $allowance . " will be added on ". date("F jS, Y", strtotime($allowance_paydate)); 
								endif; 
								?></a></p>
							<?php /*<p><?=date("F", $start)?> 01 - <?=date("F d", $end)?>, <?=date("Y", $start)?></p>*/ ?>
			
							<form method="get" class="form-inline default-form" role="form" id="date-search">
<?php 
	if( isset( $_GET['child_id'] ) )
	{ 
?>
							<input type="hidden" name="child_id" value="<?=(int)$_GET['child_id']?>">
<?php 
	}

	if( isset( $_GET['h'] ) )
	{
?>
							<input type="hidden" name="h" value="<?=$_GET['h']?>">
<?php 
	} 
?>
							<div class="form-group">
								<label for="exampleInputEmail2">See Den Activity</label>
							</div>
							<div class="form-group">
								<select class="den-select form-control" name="year" id="year">
									<option value="0000">All</option>
<?php 
	foreach($years as $k => $v)
	{
		if( $v == ( (int)date("Y") ) && ! isset( $sy ) )
		{
?>
											<option value="<?=$v?>" selected="selected"><?=$v?></option>
<?php 
		}
		else if( isset( $sy ) && $sy == $v )
		{
?>
											<option value="<?=$v?>" selected="selected"><?=$v?></option>
<?php
		}
		else
		{
?>
											<option value="<?=$v?>" ><?=$v?></option>
<?php 
		}
	}
?>
								</select>
							</div>
							<div class="form-group">
								<select class="den-select form-control" name="month" id="month">
									<option value="00" <?php if( ( isset($sm) && $sm == 0 ) || !isset( $sm ) ){ echo "selected='selected'"; } ?> >All</option>
									<option value="01" <?php if( isset($sm) && $sm == 1 ){ echo "selected='selected'"; } ?> >January</option>
									<option value="02" <?php if( isset($sm) && $sm == 2 ){ echo "selected='selected'"; } ?> >February</option>
									<option value="03" <?php if( isset($sm) && $sm == 3 ){ echo "selected='selected'"; } ?> >March</option>
									<option value="04" <?php if( isset($sm) && $sm == 4 ){ echo "selected='selected'"; } ?> >April</option>
									<option value="05" <?php if( isset($sm) && $sm == 5 ){ echo "selected='selected'"; } ?> >May</option>
									<option value="06" <?php if( isset($sm) && $sm == 6 ){ echo "selected='selected'"; } ?> >June</option>
									<option value="07" <?php if( isset($sm) && $sm == 7 ){ echo "selected='selected'"; } ?> >July</option>
									<option value="08" <?php if( isset($sm) && $sm == 8 ){ echo "selected='selected'"; } ?> >August</option>
									<option value="09" <?php if( isset($sm) && $sm == 9 ){ echo "selected='selected'"; } ?> >September</option>
									<option value="10" <?php if( isset($sm) && $sm == 10 ){ echo "selected='selected'"; } ?> >October</option>
									<option value="11" <?php if( isset($sm) && $sm == 11 ){ echo "selected='selected'"; } ?> >November</option>
									<option value="12" <?php if( isset($sm) && $sm == 12 ){ echo "selected='selected'"; } ?> >December</option>
								</select>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary" id="search-date">Search</button>
							</div>

							</form>
			<!--<p>
				Money In: <span class="text-success text-big">$XX.XX</span> <span class="sep">	
				</span> Money Out: <span class="text-danger text-big">$XX.XX</span>
			</p>-->

							<table class="table table-striped history-table top-margin">
								<thead>
									<tr>
										<th class="text-center">Date</th>
										<th class="text-center">Transaction</th>
										<th class="text-center">Money In/Out</th>
										<th class="text-center">Balance</th>
										<th class="text-center">Description</th>
									</tr>
								</thead>
								<tbody>
<?php 
	foreach( $history as $k => $v )
	{
?>
									<tr>
									  <td class="text-center"><?=$v['date']?></td>
									  <td class="text-center"><?=$v['transaction']?></td>
									  <td class="text-center<?php echo ($v['minus']) ? ' text-danger' : ''; ?>" >$<?=$v['money']?></td>
									  <td class="text-center">$<?=$v['balance']?></td>
									  <td class="text-center"><?=$v['desc']?></td>
									</tr>
<?php 
	} 
?>
								</tbody>
							</table>
			
							<div class="spending-bottom">
<?php
	/*								<a href="deposit<?=$get?>" class="btn btn-primary btn-xs">Make a Deposit</a> 
								<a href="withdraw<?=$get?>" class="btn btn-primary btn-xs">Make a Withdrawal</a>
	*/
?> 
								<a href="history/export<?=$export?>" class="btn btn-warning">Export</a>
								<a href="profile<?=$get?>" class="btn btn-primary">Done</a>
							</div>

						</div>


						<div class="col-sm-3">

							<div class="text-center">
								<h3><?= $user_full_name; ?></h3>
								<img src="<?= ASS_PROFILE_PATH . $profile_image; ?>" alt="profile" title="profile" width="105" height="135"><br>
<?php 
	if ((int)$this->sud->type_id > 0 && $this->sud->user_group == 3)
	{
?>
								<a href="kidprofile" class="btn btn-danger btn-xs" style="position: relative; top: -5px;">Edit Profile</a>
<?php		
	}
?>
							</div>
<?php
	$from = new DateTime($birthday);
	$to = new DateTime('today');

	$age = $from->diff($to)->y;
?>
							<div class="row">
								<div class="col-sm-4 text-right">
									<strong>Age:</strong>
								</div>
								<div class="col-sm-8">
									<?= $age; ?>
								</div>
							</div>
<?php
	if (isset($supports) && !empty($supports))
	{
?>
							<div class="row">
								<div class="col-sm-4 text-right">
									<strong>Supports:</strong>
								</div>
								<div class="col-sm-8">
									<?= trim($supports); ?>
								</div>
							</div>
<?php	
	}
?>

							<div id="achievements">
								<h4 class="ribbon"><div>ACHIEVEMENTS</div></h4>
<?php
	if (isset($_GET['child_id']) && $this->session->userdata('user_group') == 2)
	{
		getAchievements((int)$_GET['child_id']);
	}
	else if ($this->session->userdata('user_group') == 3)
	{
		getAchievements($this->session->userdata('type_id'));
	}
?>
							</div>
						</div>
					</div>
				</div>
