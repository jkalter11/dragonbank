				<div class="row">
					<div class="col-content clearfix">
						<div class="col-sm-9 border-right">
							<form class="form-horizontal default-form short" role="form" method="post">
<?php
	display_message();
?>						
							<div id="child-panel-head" class="top-margin">
								<div class="row">			
									<div class="col-content clearfix">
										<div class="form-group">

											<div class="col-sm-5">
												<h3>Your Profile</h3>
											</div>

										</div>
									</div>
									</form>
								</div>
							</div>

							<div class="child-panel-body">
							<div class="row select-child-div">
								<form action="" class="form-horizontal default-form short" role="form" method="post" enctype="multipart/form-data">	
								<input type="hidden" name="child_info[user_id]" value="<?= $this->session->userdata('user_id'); ?>">
								<input type="hidden" name="child_info[child_id]" value="<?=$this->session->userdata('type_id'); ?>">

								<div class="col-content clearfix">

									<div class="form-group">
										<div class="col-sm-6">
											<input type="text" placeholder="First Name*" name="child_info[user_first_name]" class="form-control<?php if (isset($error_vars['cfirst'])) { echo ' error'; } ?>" id="child-firstname" value="<?= $cfirst;?>">
										</div>		
										<div class="col-sm-6">
											<input type="text" placeholder="Last Name*" name="child_info[user_last_name]" class="form-control<?php if (isset($error_vars['clast'])) { echo ' error'; } ?>" id="child-lastname" value="<?= $clast; ?>">
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-6">
											<input type="password" placeholder="Change Password" name="child_info[user_password]" class="form-control<?php if (isset($error_vars['cpassword'])) { echo ' error'; } ?>" id="child-password">
										</div>		
										<div class="col-sm-6">
											<input type="password" placeholder="Confirm Password" name="check_child_password" class="form-control<?php if (isset($error_vars['ccpassword'])) { echo ' error'; } ?>" id="child-password">
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-6">
											<input type="text" placeholder="Birthdate*" name="child_info[birthday]" class="form-control datepicker<?php if (isset($error_vars['birthday'])) { echo ' error'; } ?>" id="birth" value="<?= $birthday; ?>">
										</div>
										<div class="col-sm-6">
											<select class="form-control<?php if (isset($error_vars['gender'])) { echo ' error'; } ?>" name="child_info[gender]" id="gender">
												<option value="-">Gender*</option>
												<option value="Male" <?php if( $gender == "Male" ){echo 'selected="selected"';}?>>Male</option>
												<option value="Female" <?php if( $gender == "Female" ){echo 'selected="selected"';}?>>Female</option>
											</select>
										</div>
										
									</div>

									<div class="form-group">
										<div class="col-sm-4">
											<select class="form-control<?php if (isset($error_vars['freq'])) { echo ' error'; } ?>" id="allowance_frequency" onchange="toggle_allowance_payday()" name="child_info[allowance_frequency]" >
												<option value="-">Allowance Frequency*</option>
												<option <?php if( $freq == "WEEK" ): echo "selected='selected' "; endif; ?>value="WEEK">Weekly</option>
												<option <?php if( $freq == "MONTH" ): echo "selected='selected' "; endif; ?>value="MONTH">Monthly</option>
											</select>
										</div>
										<div class="col-sm-4">
											<input type="text" placeholder="Allowance*" name="child_info[allowance]" class="form-control<?php if (isset($error_vars['allowance'])) { echo ' error'; } ?>" id="allowance-amount" value="<?= $allowance; ?>">
										</div>
										<div id="paid">
											<div class="col-sm-4" id="paid-weekly" style="display:<?php if ($freq == 'WEEK' || $freq == '' || $freq == '-') { echo ' block'; } else { echo ' none'; }?>;">
												<select class="form-control<?php if (isset($error_vars['paidon'])) { echo ' error'; } ?>" name="child_info[allowance_payday]">
													<option value="-">Payment Date*</option>
													<option <?php if( $paidon == 1 && $freq == "WEEK"): echo "selected='selected' "; endif; ?>value=1>Monday</option>
													<option <?php if( $paidon == 2 && $freq == "WEEK"): echo "selected='selected' "; endif; ?>value=2>Tuesday</option>
													<option <?php if( $paidon == 3 && $freq == "WEEK"): echo "selected='selected' "; endif; ?>value=3>Wednesday</option>
													<option <?php if( $paidon == 4 && $freq == "WEEK"): echo "selected='selected' "; endif; ?>value=4>Thursday</option>
													<option <?php if( $paidon == 5 && $freq == "WEEK"): echo "selected='selected' "; endif; ?>value=5>Friday</option>
													<option <?php if( $paidon == 6 && $freq == "WEEK"): echo "selected='selected' "; endif; ?>value=6>Saturday</option>
													<option <?php if( $paidon == 0 && $freq == "WEEK"): echo "selected='selected' "; endif; ?>value=0>Sunday</option>
												</select>
											</div>
											<div class="col-sm-4" id="paid-monthly" style="display:<?php if ($freq == 'MONTH') { echo ' block'; } else { echo ' none'; }?>;">
												<select class="form-control<?php if (isset($error_vars['paidon'])) { echo ' error'; } ?>" name="child_info[allowance_payday]">
													<option value="-">Payment Date*</option>
<?php 
		foreach (range(1, 31) as $key => $val)
		{
 ?>
													<option <?php if ($paidon == $val && $freq == "MONTH"): echo "selected='selected' "; endif; ?>value=<?=$val?>><?=$val?></option>
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
																	<input type="radio" name="child_info[allocation_type]" id="den1" class="den" value=1 <?php if( $allocation == 1 ){ echo "checked='checked'";}?> > Default
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
																	<input type="radio" name="child_info[allocation_type]" id="den2" class="den" value=2 <?php if( $allocation == 2 ){ echo "checked='checked'";}?> > The Dragon Saver
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
																	<input type="radio" name="child_info[allocation_type]" id="den3" class="den" value=3 <?php if( $allocation == 3 ){ echo "checked='checked'";}?> > Across the Dens
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
																	<input type="radio" name="child_info[allocation_type]" id="den4" class="den" value=4 <?php if( $allocation == 4 ){ echo "checked='checked'";}?> > Custom
																</label>
															</div>
														</td>
														<td><input type="text" class="form-control den-form custom<?php if (isset($error_vars['spend'])) { echo ' error'; } ?>" id="spend" name="child_info[spend][4]" value=<?= $spend; ?>></td>
														<td><input type="text" for="den4" class="form-control den-form custom<?php if (isset($error_vars['save'])) { echo ' error'; } ?>" id="save" name="child_info[save][4]" value=<?= $save; ?>></td>
														<td><input type="text" for="den4" class="form-control den-form custom<?php if (isset($error_vars['give'])) { echo ' error'; } ?>" id="give" name="child_info[give][4]" value=<?= $give; ?>></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-12 text-center">
											<input type="submit" name="child_submit" id="child_submit" class="btn btn-primary" value="UPDATE PROFILE">
										</div>
									</div>

								</div>
								</form>
							</div>
							</div>

						</div>

						<div class="col-sm-3 top-margin">
							<div class="text-center">
								<img src="<?= ASS_PROFILE_PATH . $profile_image; ?>" alt="profile" title="profile" width="104" height="136">
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
	getAchievements($this->session->userdata('type_id'));
?>
							</div>
						</div>
					</div>
				</div>

