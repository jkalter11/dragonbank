				<div class="row">
					<div class="col-content clearfix">
						<div class="col-sm-9 border-right">
							<form class="form-horizontal default-form short" role="form" method="post">
							<h1>Parent's Profile</h1>
<?php
	display_message();
?>						
							<div class="form-group">
								<div class="col-sm-6">
									<input type="text" placeholder="First Name*" name="user_info[user_first_name]" class="form-control<?php if (isset($error_vars['ufname'])) { echo ' error'; }?>" id="firstname" value="<?=$ufname?>">
								</div>

								<div class="col-sm-6">
									<input type="text" placeholder="Last Name*" name="user_info[user_last_name]" class="form-control<?php if (isset($error_vars['ulname'])) { echo ' error'; }?>" id="lastname" value="<?=$ulname?>">
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-6">
									<input type="text" placeholder="Email*" name="user_info[user_email]" class="form-control<?php if (isset($error_vars['uemail'])) { echo ' error'; }?>" id="email" value="<?=$uemail?>">
								</div>

								<div class="col-sm-6">
									<input type="text" placeholder="Confirm Email*" name="check_parent_email" class="form-control<?php if (isset($error_vars['ucemail'])) { echo ' error'; }?>" id="check_parent_email" value="<?=$ucemail?>">
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-6">
									<input type="password" placeholder="Change Password" name="user_info[user_password]" class="form-control<?php if (isset($error_vars['upassword'])) { echo ' error'; }?>" id="password">
								</div>

								<div class="col-sm-6">
									<input type="password" placeholder="Confirm Password" name="check_parent_password" class="form-control<?php if (isset($error_vars['ucpassword'])) { echo ' error'; }?>" id="check_parent_password">
								</div>
							</div>

							<div class="form-group">	
								<div class="col-sm-6">
									<input type="text" placeholder="Phone Number*" name="user_info[user_phone]" class="form-control<?php if (isset($error_vars['user_phone'])) { echo ' error'; }?>" id="phone" value="<?=$phone?>">

								</div>
							</div>

							<div class="row">
								<div class="col-content">
									<div class="col-sm-3 short-padding">
										<div class="checkbox">
											<label for="newsletter">
												<input type="checkbox" name="comm_info[dragon]" id="newsletter" value="1" <?php if( $newsletter ){ echo "checked='checked'"; } ?>> Dragon Bank Newsletter
											</label>
										</div>
									</div>
									<div class="col-sm-3 short-padding">
										<div class="checkbox">
											<label for="reminder">
												<input type="checkbox" name="comm_info[allowance_reminder]" id="reminder" value="1" <?php if( $alreminder ){ echo "checked='checked'"; } ?>> Allowance Reminder
											</label>
										</div>
									</div>
									<div class="col-sm-3 short-padding">
										<div class="checkbox">
											<label for="partner">
												<input type="checkbox" name="comm_info[quarterly_reminder]" id="partner" value="1" <?php if( $qreminder ){ echo "checked='checked'"; } ?>> Savings &amp; Giving Reminder
											</label>
										</div>
									</div>
									<div class="col-sm-3 short-padding">
										<div class="checkbox">
											<label for="allowance_status">
												<input type="checkbox" name="comm_info[allowance_status]" id="allowance_status" value="1" <?php if( $alstatus ){ echo "checked='checked'"; } ?>> Automate Allowance
											</label>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-content">
									<div class="col-sm-12 text-center top-margin">
										<input type="submit" name="parent_submit" id="parent_submit" class="btn btn-primary" value="UPDATE MY PROFILE">
									</div>
								</div>
							</div>

							</form>



							<div id="child-panel-head" class="top-margin">
								<div class="row">			
									<form class="form-horizontal default-form" role="form" method="post">
									<div class="col-content clearfix">
										<div class="form-group">

											<div class="col-sm-5">
												<h3>Your Child's Profile</h3>
											</div>

											<div class="col-sm-7 top-margin">
												<div class="form-group">
													<div class="col-sm-7">
														<select class="form-control" name="child" id="select-child-select" onchange="showChildDiv(this.value)">
<?php 
	foreach ($child as $k => $v)
	{
		$selected = '';

		if (isset($curChild) && $curChild == $v['child_id'])
		{
			$selected = ' selected';
		}
?>
															<option value="<?= $k; ?>"<?= $selected; ?>><?= $v['user_full_name']; ?> - <?= $v['user_name']; ?></option>
<?php 
	}
?>
														</select>
													</div>
													<div class="col-sm-5">
														<a href="/signup" class="btn btn-primary">Add a new child</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									</form>
								</div>
							</div>
<?php 
	foreach ($child as $k => $v)
	{
		$cfirstname = (isset($curChild) && $curChild == $v['child_id'] && isset($cfirst)) ? $cfirst : reset(explode(" ", $v['user_full_name']));
		$clastname = (isset($curChild) && $curChild == $v['child_id'] && isset($clast)) ? $clast : end(explode(" ", $v['user_full_name']));
		$cbirthday = (isset($curChild) && $curChild == $v['child_id'] && isset($birthday)) ? $birthday : $v['birthday'];
		$cgender = (isset($curChild) && $curChild == $v['child_id'] && isset($gender)) ? $gender : $v['gender'];
		$cfreq = (isset($curChild) && $curChild == $v['child_id'] && isset($freq)) ? $freq : $v['allowance_frequency'];
		$callowance = (isset($curChild) && $curChild == $v['child_id'] && isset($allowance)) ? $allowance : $v['allowance'];
		$cpaidon = (isset($curChild) && $curChild == $v['child_id'] && isset($paidon)) ? $paidon : $v['allowance_payday'];
		$cspend = (isset($curChild) && $curChild == $v['child_id'] && isset($spend)) ? $spend : $v['spend'];
		$csave = (isset($curChild) && $curChild == $v['child_id'] && isset($save)) ? $save : $v['save'];
		$cgive = (isset($curChild) && $curChild == $v['child_id'] && isset($give)) ? $give : $v['give'];
		$callocation = (isset($curChild) && $curChild == $v['child_id'] && isset($allocation)) ? $allocation : $v['allocation_type'];
?>
							<div class="child-panel-body">
							<div class="row select-child-div" id="child<?=$k?>" style="<?php echo ( ($k == 0 && !isset($curChild)) || (isset($curChild) && $curChild == $v['child_id']) )? 'display:block' : 'display:none'; ?>">
								<form action="/new/profile/parentsprofile?child_id=<?=$v['child_user_id']?>" class="form-horizontal default-form short" role="form" method="post" enctype="multipart/form-data">	
								<input type="hidden" name="child_info[user_id]" value="<?=$v['child_user_id']?>">
								<input type="hidden" name="child_info[child_user_id]" id="child_user_id" value="<?=$v['child_user_id']?>">
								<input type="hidden" name="child_info[child_id]" value="<?=$v['child_id']?>">

								<div class="col-content clearfix">

									<div class="form-group">
										<div class="col-sm-6">
											<input type="text" placeholder="First Name*" name="child_info[user_first_name]" class="form-control<?php if (isset($curChild) && $v['child_id'] == $curChild && isset($error_vars['cfirst'])) { echo ' error'; } ?>" id="child-firstname" value="<?= $cfirstname;?>">
										</div>		
										<div class="col-sm-6">
											<input type="text" placeholder="Last Name*" name="child_info[user_last_name]" class="form-control<?php if (isset($curChild) && $v['child_id'] == $curChild && isset($error_vars['clast'])) { echo ' error'; } ?>" id="child-lastname" value="<?= $clastname; ?>">
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-6">
											<input type="password" placeholder="Change Password" name="child_info[user_password]" class="form-control<?php if (isset($curChild) && $v['child_id'] == $curChild && isset($error_vars['cpassword'])) { echo ' error'; } ?>" id="child-password">
										</div>		
										<div class="col-sm-6">
											<input type="password" placeholder="Confirm Password" name="check_child_password" class="form-control<?php if (isset($curChild) && $v['child_id'] == $curChild && isset($error_vars['ccpassword'])) { echo ' error'; } ?>" id="child-password">
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-6">
											<input type="text" placeholder="Birthdate*" name="child_info[birthday]" class="form-control datepicker<?php if (isset($curChild) && $v['child_id'] == $curChild && isset($error_vars['birthday'])) { echo ' error'; } ?>" id="birth" value="<?= $cbirthday; ?>">
										</div>
										<div class="col-sm-6">
											<select class="form-control<?php if (isset($curChild) && $v['child_id'] == $curChild && isset($error_vars['gender'])) { echo ' error'; } ?>" name="child_info[gender]" id="gender">
												<option value="-">Gender*</option>
												<option value="Male" <?php if( $cgender == "Male" ){echo 'selected="selected"';}?>>Male</option>
												<option value="Female" <?php if( $cgender == "Female" ){echo 'selected="selected"';}?>>Female</option>
											</select>
										</div>
										
									</div>

									<div class="form-group">
										<div class="col-sm-4">
											<select class="form-control<?php if (isset($curChild) && $v['child_id'] == $curChild && isset($error_vars['freq'])) { echo ' error'; } ?>" id="allowance_frequency<?=$k?>" onchange="toggle_allowance_payday_multi('<?=$k?>')" name="child_info[allowance_frequency]" >
												<option value="-">Allowance Frequency*</option>
												<option <?php if( $cfreq == "WEEK" ): echo "selected='selected' "; endif; ?>value="WEEK">Weekly</option>
												<option <?php if( $cfreq == "MONTH" ): echo "selected='selected' "; endif; ?>value="MONTH">Monthly</option>
											</select>
										</div>
										<div class="col-sm-4">
											<input type="text" placeholder="Allowance*" name="child_info[allowance]" class="form-control<?php if (isset($curChild) && $v['child_id'] == $curChild && isset($error_vars['allowance'])) { echo ' error'; } ?>" id="allowance-amount" value="<?= $callowance; ?>">
										</div>
										<div class="paid">
											<div class="col-sm-4" id="paid-weekly<?=$k?>" style="display: block;">
												<select class="form-control<?php if (isset($curChild) && $v['child_id'] == $curChild && isset($error_vars['paidon'])) { echo ' error'; } ?>" name="child_info[allowance_payday]">
													<option value="-">Payment Date*</option>
													<option <?php if( $cpaidon == 1 && $cfreq == "WEEK"): echo "selected='selected' "; endif; ?>value=1>Monday</option>
													<option <?php if( $cpaidon == 2 && $cfreq == "WEEK"): echo "selected='selected' "; endif; ?>value=2>Tuesday</option>
													<option <?php if( $cpaidon == 3 && $cfreq == "WEEK"): echo "selected='selected' "; endif; ?>value=3>Wednesday</option>
													<option <?php if( $cpaidon == 4 && $cfreq == "WEEK"): echo "selected='selected' "; endif; ?>value=4>Thursday</option>
													<option <?php if( $cpaidon == 5 && $cfreq == "WEEK"): echo "selected='selected' "; endif; ?>value=5>Friday</option>
													<option <?php if( $cpaidon == 6 && $cfreq == "WEEK"): echo "selected='selected' "; endif; ?>value=6>Saturday</option>
													<option <?php if( $cpaidon == 0 && $cfreq == "WEEK"): echo "selected='selected' "; endif; ?>value=0>Sunday</option>
												</select>
											</div>
											<div class="col-sm-4" id="paid-monthly<?=$k?>" style="display: none;">
												<select class="form-control<?php if (isset($curChild) && $v['child_id'] == $curChild && isset($error_vars['paidon'])) { echo ' error'; } ?>" name="child_info[allowance_payday]">
													<option value="-">Payment Date*</option>
<?php 
		foreach (range(1, 31) as $key => $val)
		{
 ?>
													<option <?php if( $cpaidon == $val && $cfreq == "MONTH"): echo "selected='selected' "; endif; ?>value=<?=$val?>><?=$val?></option>
<?php 
		}
?>
												</select>
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-4">
											<input type="file" name="profile_image">
										</div>
									</div>

									<div class="row">
										<div class="col-sm-12">
											
											<table class="table table-condensed">
												<thead>
													<tr>
														<th style="width: 300px;"><h3 style="margin: 0;">Den Allocation</h3></th>
														<th>Spend</th>
														<th>Save</th>
														<th>Give</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>
															<div class="radio">
																<label>
																	<input type="radio" name="child_info[allocation_type]" id="den1" class="den" value=1 <?php if( $callocation == 1 ){ echo "checked='checked'";}?> > Default
																</label>
															</div>
														</td>
														<td><input type="hidden" name="child_info[spend][1]" value="80.00">80%</td>
														<td><input type="hidden" name="child_info[save][1]" value="10.00">10%</td>
														<td><input type="hidden" name="child_info[give][1]" value="10.00">10%</td>
													</tr>
													<tr>
														<td>
															<div class="radio">
																<label>
																	<input type="radio" name="child_info[allocation_type]" id="den2" class="den" value=2 <?php if( $callocation == 2 ){ echo "checked='checked'";}?> > The Dragon Saver
																</label>
															</div>
														</td>
														<td><input type="hidden" name="child_info[spend][2]" value="40.00">40%</td>
														<td><input type="hidden" name="child_info[save][2]" value="50.00">50%</td>
														<td><input type="hidden" name="child_info[give][2]" value="10.00">10%</td>
													</tr>
													<tr>
														<td>
															<div class="radio">
																<label>
																	<input type="radio" name="child_info[allocation_type]" id="den3" class="den" value=3 <?php if( $callocation == 3 ){ echo "checked='checked'";}?> > Across the Dens
																</label>
															</div>
														</td>
														<td><input type="hidden" name="child_info[spend][3]" value="33.40">33.4%</td>
														<td><input type="hidden" name="child_info[save][3]" value="33.30">33.3%</td>
														<td><input type="hidden" name="child_info[give][3]" value="33.30">33.3%</td>
													</tr>
													<tr>
														<td class="table-input">
															<div class="radio">
																<label>
																	<input type="radio" name="child_info[allocation_type]" id="den4" class="den" value=4 <?php if( $callocation == 4 ){ echo "checked='checked'";}?> > Custom
																</label>
															</div>
														</td>
														<td><input type="text" class="form-control den-form custom<?php if (isset($curChild) && $v['child_id'] == $curChild && isset($error_vars['spend'])) { echo ' error'; } ?>" id="spend" name="child_info[spend][4]" value=<?= $cspend; ?>></td>
														<td><input type="text" for="den4" class="form-control den-form custom<?php if (isset($curChild) && $v['child_id'] == $curChild && isset($error_vars['save'])) { echo ' error'; } ?>" id="save" name="child_info[save][4]" value=<?= $csave; ?>></td>
														<td><input type="text" for="den4" class="form-control den-form custom<?php if (isset($curChild) && $v['child_id'] == $curChild && isset($error_vars['give'])) { echo ' error'; } ?>" id="give" name="child_info[give][4]" value=<?= $cgive; ?>></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-12 text-center">
											<input type="submit" name="child_submit" id="child_submit<?= $k; ?>" class="btn btn-primary" value="UPDATE MY CHILD'S PROFILE">
										</div>
									</div>

								</div>
								</form>
							</div>
							</div>
<?php
	}

?>
						</div>

						<div class="col-sm-3 top-margin">
<?php 
	foreach ($child as $k => $v)
	{ 
?>							
							<div class="select-child-panel-div" id="child-panel<?=$k?>" style="<?php echo ( ($k == 0 && !isset($curChild)) || (isset($curChild) && $curChild == $v['child_id']) )? 'display:block' : 'display:none'; ?>">
								<div class="text-center">
									<a href="/profile/profile?child_id=<?= $v['child_id']; ?>" class="btn btn-warning" style="margin-bottom: 5px;">Manage Money</a><br>
									<img src="<?= ASS_PROFILE_PATH . $v['profile_image']; ?>" alt="profile" title="profile" width="104" height="136">
								</div>
<?php
	$from = new DateTime($v['birthday']);
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
	if (isset($v['supports']) && !empty($v['supports']))
	{
?>
								<div class="row">
									<div class="col-sm-4 text-right">
										<strong>Supports:</strong>
									</div>
									<div class="col-sm-8">
										<?= trim($v['supports']); ?>
									</div>
								</div>
<?php	
	}
?>

								<div id="achievements">
									<h4 class="ribbon"><div>ACHIEVEMENTS</div></h4>
<?php
	getAchievements($v['child_id']);
?>
								</div>
							</div>
<?php
	}
?>
						</div>
					</div>
				</div>
