				<div class="row">
					<div class="col-content clearfix">
						<div class="col-sm-9 border-right relative">
							<h1>Wishlist</h1>
<?php
	display_message(85);

	if (isset($deleteid))
	{
?>
							<div class="alert top-margin alert-warning alert-dismissible" role="alert" style="text-align: center; width: 85%">
								<form action="" method="post">
									<p>Are you sure you want to delete this item?</p>
									<input type="hidden" name="wishlistid" value="<?= $deleteid; ?>">
									<input type="submit" class="btn btn-danger" name="deletewishlist" value="YES">
									<input type="submit" class="btn btn-primary" name="deletewishlist" value="NO">
								</form>
							</div>
<?php
	}
?>
							<div id="sub-nav">
								<a href="/new/profile/deposit<?= $get; ?>" class="btn btn-primary btn-xs">Deposit</a>
								<a href="/new/profile/withdraw<?= $get; ?>" class="btn btn-primary btn-xs">Withdraw</a>
								<a href="/new/profile/history<?= $get; ?>" class="btn btn-primary btn-xs">History</a>
								<a href="/new/profile/wishlist<?= $get; ?>" class="btn btn-danger btn-xs">Wishlist</a>
							</div>

							<h4><span class="text-success">Total Dens Balance: $<?=$balance?></span> <strong>as of today <?=date("F d, Y");?></strong></h4>
							<p><?php 
								if( (float)$allowance > 0.00 && isset( $allowance_paydate ) && $allowance_paydate !== NULL ):
									echo "$". $allowance . " will be added on ". date("F jS, Y", strtotime($allowance_paydate)); 
								endif; 
								?></a></p>
							<h3>Total amount on spend: <strong>$<?= $spend_amount; ?></strong></h3>


							<table class="table table-striped history-table top-margin">
								<thead>
									<tr>
										<th>&nbsp;</th>
										<th class="text-center">Date</th>
										<th class="text-center">Item</th>
										<th class="text-center">Cost</th>
										<th class="text-center">% of Money to Goal</th>
									</tr>
								</thead>
								<tbody>
<?php 
	foreach ($wishlist as $k => $v)
	{
		$percent = (int)($spend_amount / $v->cost * 100);

		if ($percent > 100)
		{
			$percent = 100;
		}
?>
									<tr>
										<td><form action="" method="post">
											<input type="hidden" name="wid" value="<?= $v->id; ?>">
											<input type="submit" class="btn btn-danger btn-xs" name="deletewishlistitem" value="x">
										</form></td>
										<td class="text-center"><?= date('Y-m-d', $v->date); ?></td>
										<td class="text-center"><?= $v->item; ?></td>
										<td class="text-center">$<?= $v->cost; ?></td>
										<td>
											<div class="progress">
												<div class="progress-bar<?php if ($percent == 100) { echo ' progress-bar-success'; }?>" role="progressbar" aria-valuenow="<?= $percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $percent; ?>%;"><?= $percent; ?>%</div>
											</div>
										</td>
									</tr>
<?php 
	} 
?>
								</tbody>
							</table>
<?php
	//if ($this->session->userdata('user_group') == 3)
	//{
?>
							<form action="" method="post" class="form-inline default-form wishlist-add" role="form">
								<div class="form-group">
									<label>Add an item:</label>
								</div>
								<div class="form-group">
									<input type="text" placeholder="Item Name" class="form-control<?php if (isset($error_vars['item'])) { echo ' error'; } ?>" name="item" value="<?= $item; ?>">
								</div>
								<div class="form-group">
									<input type="text" placeholder="Cost" class="form-control<?php if (isset($error_vars['cost'])) { echo ' error'; } ?>" name="cost" value="<?= $cost; ?>">
								</div>

								<div class="form-group">
									<input type="submit" class="btn btn-primary" name="add_wishlist" value="Add Item">
								</div>
							</form>
<?php
	//}
?>
							<div class="spending-bottom">
								<?php /* <a href="/profile/deposit<?=$get?>" class="btn btn-primary btn-xs">Make a Deposit</a> 
								<a href="/profile/withdraw<?=$get?>" class="btn btn-primary btn-xs">Make a Withdrawal</a> 
								<a href="/profile/wishlist/export" class="btn btn-warning btn-xs">Export</a> */ ?>
							</div>
						
							<div class="top-margin">
								<a href="/new/profile/wishlist/export<?=$get?>" class="btn btn-warning">Export</a>
								<a href="/new/profile<?=$get?>" class="btn btn-primary">Done</a>
							</div>
<?php
	//var_dump($wishlist);
?>

							
							
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

	$from = new DateTime($birthday);
	$to = new DateTime('today');

	$age = $from->diff($to)->y;
?>
							</div>
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
