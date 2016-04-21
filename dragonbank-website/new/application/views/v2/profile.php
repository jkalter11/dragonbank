				<div class="row">
					<div class="col-content clearfix">
						<div class="col-sm-9 border-right">
							
							<h1>My Money</h1>
							<div id="my-money">
								<img src="<?= ASS_IMG_PATH; ?>profile-bg.jpg" class="dragon-bg" alt="Dragon Bank" title="Dragon Bank">
								<div id="sub-nav">
									<a href="/new/profile/deposit<?= $get; ?>" class="btn btn-primary btn-xs">Deposit</a>
									<a href="/new/profile/withdraw<?= $get; ?>" class="btn btn-primary btn-xs">Withdraw</a>
									<a href="/new/profile/history<?= $get; ?>" class="btn btn-primary btn-xs">History</a>
									<a href="/new/profile/wishlist<?= $get; ?>" class="btn btn-primary btn-xs">Wishlist</a>
								</div>

								<div class="amounts" id="spend-amt">$<?= $spend_amount; ?></div>
								<div class="amounts" id="save-amt">$<?= $save_amount; ?></div>
								<div class="amounts" id="give-amt">$<?= $give_amount; ?></div>

								<div class="percents" id="spend-pct"><?= $spend; ?>%<br>SPEND</div>
								<div class="percents" id="save-pct"><?= $save ?>%<br>SAVE</div>
								<div class="percents" id="give-pct"><?= $give ?>%<br/>GIVE</div>

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
