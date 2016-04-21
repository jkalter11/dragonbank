				<div class="row">
					<div class="col-content clearfix">
						<div class="col-sm-9 border-right">
							
							<h1>Deposit</h1>
<?php
	display_message();
?>
							<div id="my-money">
								<img src="<?= ASS_IMG_PATH; ?>profile-bg.jpg" class="dragon-bg" alt="Dragon Bank" title="Dragon Bank">
								<div id="sub-nav">
									<a href="/new/profile/deposit<?= $get; ?>" class="btn btn-danger btn-xs">Deposit</a>
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

							<?php echo $this->session->flashdata("bank_transaction"); ?>
			
							<form class="form-horizontal default-form my-money-form" role="form" method="POST">
								<div class="row">
							
									<div class="col-sm-4">
										<div class="col-content clearfix">
											<div class="form-group">
												<label for="amount" class="col-sm-6 control-label">Amount to Deposit</label>
												<div class="col-sm-6 no-h-padding">
													<input type="text" class="form-control<?php if (isset($error_vars['money'])) { echo ' error'; } ?>" name="money" id="money" placeholder="$ Amount" value="<?= $money; ?>">
												</div>

											</div>
										</div>
									</div>

									<div class="col-sm-4">
										<div class="col-content clearfix">
											<div class="form-group">
												<label for="bank-allocations" class="col-sm-6 control-label">Deposit to</label>
												<div class="col-sm-6 no-h-padding">
													<select class="form-control" name="allocation" id="bank-allocations">
														<option<?php if ($allocation == 1) { echo ' selected'; } ?> value=<?php echo json_encode($default)?>>Default</option>
														<option<?php if ($allocation == 2) { echo ' selected'; } ?> value=<?php echo json_encode($spending)?>>Spending</option>
														<option<?php if ($allocation == 3) { echo ' selected'; } ?> value=<?php echo json_encode($saving)?>>Saving</option>
														<option<?php if ($allocation == 4) { echo ' selected'; } ?> value=<?php echo json_encode($giving)?>>Giving</option>
													</select>
												</div>
											</div>
										</div>
									</div>

									<div class="col-sm-4">
										<div class="col-content clearfix">
											<div class="form-group">
												<label for="reason" class="col-sm-6 control-label">Reason for Deposit</label>
												<div class="col-sm-6 no-h-padding">
													<input type="text" class="form-control<?php if (isset($error_vars['desc'])) { echo ' error'; } ?>" name="desc" id="reason" placeholder="Reason" value="<?= $desc; ?>">
												</div>
											</div>
										</div>
									</div>

								</div>

								<div id="my-money-conversion">

									<div class="conversion" id="spend-con">
										<div class="xx">$0.00</div>
										<div class="perc-block"><span><?=$spend?></span>%<br>SPEND</div>
										<input type="hidden" name="perc[]" value=<?=$spend?>>
									</div>

									<div class="conversion" id="save-con">
										<div class="xx">$0.00</div>
										<div class="perc-block"><span><?=$save?></span>%<br>SAVE</div>
										<input type="hidden" name="perc[]" value=<?=$save?>>
									</div>

									<div class="conversion" id="give-con">
										<div class="xx">$0.00</div>
										<div class="perc-block"><span><?=$give?></span>%<br>GIVE</div>
										<input type="hidden" name="perc[]" value=<?=$give?>>
									</div>
								</div>

								<div class="text-center">			
									<button type="submit" class="btn btn-primary">Done</button>
								</div>
							</form>

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
