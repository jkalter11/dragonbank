				<div class="row">
					<div class="col-content clearfix">
						<div class="col-sm-12">
							<form class="form-horizontal default-form short" role="form" method="post">
								<h1>Profile Setup - Step 2</h1>
								<div class="row">
									<div class="col-sm-12">
										<div class="pull-right attached-right">
					
											<div class="btn-group btn-steps">
												<button type="button" class="btn btn-step btn-step-title">Activation Progress</button>
												<button type="button" class="btn btn-step btn-step-active">step 1</button>
												<button type="button" class="btn btn-step btn-step-active">step 2</button>
												<button type="button" class="btn btn-step">step 3</button>
												<button type="button" class="btn btn-step">done</button>
											</div>
										</div>
									</div>
								</div>
<?php
	display_message();

	if (!isLoggedIn())
	{
?>
								<h3>Your Profile</h3>				
								<div class="form-group">
									<div class="col-sm-6">
										<input type="text" placeholder="First Name*" name="user_info[user_first_name]" class="form-control<?php if (isset($error_vars['ufirst'])) { echo ' error'; } ?>" id="firstname" value="<?=$ufirst?>">
									</div>

									<div class="col-sm-6">
										<input type="text" placeholder="Last Name*" name="user_info[user_last_name]" class="form-control<?php if (isset($error_vars['ulast'])) { echo ' error'; } ?>" id="lastname" value="<?=$ulast?>">
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-6">
										<input type="text" placeholder="Email*" name="user_info[user_email]" class="form-control<?php if (isset($error_vars['uemail'])) { echo ' error'; } ?>" id="email" value="<?=$uemail?>">
									</div>

									<div class="col-sm-6">
										<input type="text" placeholder="Confirm Email*" name="check_parent_email" class="form-control<?php if (isset($error_vars['uemail'])) { echo ' error'; } ?>" id="check_parent_email" value="<?=$ucemail?>">
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-6">
										<input type="password" placeholder="New Password" name="user_info[user_password]" class="form-control<?php if (isset($error_vars['upassword'])) { echo ' error'; } ?>" id="password">
									</div>

									<div class="col-sm-6">
										<input type="password" placeholder="Confirm Password" name="check_parent_password" class="form-control<?php if (isset($error_vars['upassword'])) { echo ' error'; } ?>" id="check_parent_password">
									</div>
								</div>

								<div class="form-group">	
									<div class="col-sm-6">
										<input type="text" placeholder="Phone Number*" name="user_info[user_phone]" class="form-control<?php if (isset($error_vars['phone'])) { echo ' error'; } ?>" id="phone" value="<?=$phone?>">

									</div>
								</div>

								<div class="row">
									<div class="col-content">
										<div class="col-sm-3 short-padding">
											<div class="checkbox">
												<label for="newsletter">
													<input type="checkbox" name="comm_info[newsletter]" id="newsletter" value="1" <?php if( $newsletter ){ echo "checked='checked'"; } ?>> Dragon Bank Newsletter
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

								<p class="top-margin" style="font-size: 0.8em;"><strong>Please note:</strong> If you have purchased more than one Dragon Bank, we recommend setting up only one account. After that, you can login and add additional children’s profiles to your account simply and easily, this will allow you to view multiple children’s profiles with one login.  If however you would like to have separate logins for each child, you can create one account per child but must use different email addresses for each account setup.</p>
<?php
	}
	else
	{
?>

<?php
	}
?>

								<div id="child-panel-head">
									<div class="row">			
										<div class="col-content clearfix">
											<div class="form-group">
												<div class="col-sm-6">
													<h3>Your Child's Profile</h3>
												</div>

												<div class="col-sm-6 top-margin">
													<input type="text" placeholder="Child's Username*" name="child_info[user_name]" class="form-control<?php if (isset($error_vars['cusername'])) { echo ' error'; } ?>" id="child-username" value="<?= $cusername; ?>">
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="child-panel-body">
									<div class="row select-child-div">
										<div class="col-content clearfix">


											<div class="form-group">
												<div class="col-sm-6">
													<input type="password" placeholder="New Password" name="child_info[user_password]" class="form-control<?php if (isset($error_vars['cpassword'])) { echo ' error'; } ?>" id="child-password">
												</div>		
												<div class="col-sm-6">
													<input type="password" placeholder="Confirm Password" name="check_child_password" class="form-control<?php if (isset($error_vars['cpassword'])) { echo ' error'; } ?>" id="check_child_password">
												</div>
											</div>

											<div class="form-group">
												<div class="col-sm-6">
													<input type="text" placeholder="First Name*" name="child_info[user_first_name]" class="form-control<?php if (isset($error_vars['cfirst'])) { echo ' error'; } ?>" id="child-firstname" value="<?= $cfirst; ?>">
												</div>		
												<div class="col-sm-6">
													<input type="text" placeholder="Last Name*" name="child_info[user_last_name]" class="form-control<?php if (isset($error_vars['clast'])) { echo ' error'; } ?>" id="child-lastname" value="<?= $clast; ?>">
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
													<select class="form-control<?php if (isset($error_vars['freq'])) { echo ' error'; } ?>" id="allowance_frequency" onchange="toggle_allowance_payday()" name="child_info[allowance_frequency]">
														<option value="-">Allowance Frequency*</option>
														<option <?php if( $freq == "WEEK" ): echo "selected='selected' "; endif; ?>value="WEEK">Weekly</option>
														<option <?php if( $freq == "MONTH" ): echo "selected='selected' "; endif; ?>value="MONTH">Monthly</option>
													</select>
												</div>
												<div class="col-sm-4">
													<input type="text" placeholder="Allowance Amount*" name="child_info[allowance]" class="form-control<?php if (isset($error_vars['allowance'])) { echo ' error'; } ?>" id="allowance-amount" value="<?=$allowance;?>">
												</div>
												<div id="paid">
													<div class="col-sm-4" id="paid-weekly" style="display:<?php if ($freq == 'WEEK' || $freq == '' || $freq == '-') { echo ' block'; } else { echo ' none'; }?>;">
														<select class="form-control<?php if (isset($error_vars['paidon'])) { echo ' error'; } ?>" name="child_info[allowance_payday]">
															<option value="-">Payment Date*</option>
															<option<?php if ($freq == 'WEEK' && $paidon == 1) { echo ' selected'; } ?> value="1">Monday</option>
															<option<?php if ($freq == 'WEEK' && $paidon == 2) { echo ' selected'; } ?> value="2">Tuesday</option>
															<option<?php if ($freq == 'WEEK' && $paidon == 3) { echo ' selected'; } ?> value="3">Wednesday</option>
															<option<?php if ($freq == 'WEEK' && $paidon == 4) { echo ' selected'; } ?> value="4">Thursday</option>
															<option<?php if ($freq == 'WEEK' && $paidon == 5) { echo ' selected'; } ?> value="5">Friday</option>
															<option<?php if ($freq == 'WEEK' && $paidon == 6) { echo ' selected'; } ?> value="6">Saturday</option>
															<option<?php if ($freq == 'WEEK' && $paidon == 0) { echo ' selected'; } ?> value="0">Sunday</option>
														</select>
													</div>
													<div class="col-sm-4" id="paid-monthly" style="display:<?php if ($freq == 'MONTH') { echo ' block'; } else { echo ' none'; }?>;">
														<select class="form-control<?php if (isset($error_vars['paidon'])) { echo ' error'; } ?>" name="child_info[allowance_payday]">
															<option value="-">Payment Date*</option>
<?php 
		foreach (range(1, 31) as $key => $val)
		{
			$selected = '';
			if ($freq == 'MONTH' && $val == $paidon)
			{
				$selected = ' selected';
			}
 ?>
															<option value="<?= $val; ?>"<?= $selected; ?>><?= $val; ?></option>
<?php 
		}
?>
														</select>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-4">
									    			<input type="text" placeholder="Initial Deposit*" name="init_deposit" class="form-control<?php if (isset($error_vars['init_deposit'])) { echo ' error'; } ?>" id="deposit" value="<?= $init_deposit; ?>" >
												</div>
											</div>
											<p class="top-margin" style="font-size: 0.8em;"><strong>Please note:</strong> This is the amount of money being deposited into the Dragon Bank as the starting balance.</p>
										</div>
									</div>
								</div>

								<div class="form-group top-margin">
									<div class="col-sm-12 text-right">
										<input type="submit" name="activate_step2" id="activate_step2" class="btn btn-primary" value="Next Step">
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>

<?php /*
				<div class="row">
					<div class="col-content">
						<div class="col-sm-12">
							<h1>Profile Setup - Step 2</h1>

							<div class="row">
								<div class="col-sm-12">
									<div class="pull-right attached-right">
				
										<div class="btn-group btn-steps">
											<button type="button" class="btn btn-step btn-step-title">Setup progress</button>
											<button type="button" class="btn btn-step btn-step-active">step 1</button>
											<button type="button" class="btn btn-step btn-step-active">step 2</button>
											<button type="button" class="btn btn-step">step 3</button>
											<button type="button" class="btn btn-step">done</button>
										</div>
									</div>
								</div>
							</div>

							<?php $form_id = ( isLoggedIn() )? "signup2-edit-loggedin" : "signup2-edit"; ?>
							<form class="form-horizontal order-form singup-form singup-form-2 default-form" role="form" id="<?=$form_id;?>" method="POST">
								
							<div class="row">
								<div class="col-sm-5">
									<h3>Parent's Info</h3>
						
									  <div class="form-group">
										
										<div class="col-sm-12">
										  <input type="text" name="user_info[user_first_name]" class="form-control" id="firstname" value="<?=$ufirst?>">
										  <label for="firstname" class="col-md-4 col-sm-7 control-label">First Name</label>
										</div>
									  </div>
									<div class="form-group">
										
										<div class="col-sm-12">
											<input type="text" name="user_info[user_last_name]" class="form-control" id="lastname" value="<?=$ulast?>">
											<label for="lastname" class="col-md-4 col-sm-7 control-label">Last Name</label>
										</div>
									</div>
									 
									  <div class="form-group">
										
										<div class="col-sm-12">
										  <input type="text" name="user_info[user_phone]" class="form-control" id="phone" value="<?=$phone?>">
										  <label for="cell" class="col-md-4 col-sm-7 control-label">Cellphone Number</label>
										</div>
									  </div>
									  <div class="form-group">
										
										<div class="col-sm-12">
										  <input type="email" name="user_info[user_email]" class="form-control" id="email" value="<?=$uemail?>">
										  <label for="email" class="col-md-4 col-sm-7 control-label">Email <small>(username)</small></label>
										</div>
									  </div>
									  <div class="form-group">
										
										<div class="col-sm-12">
										  <input type="email" name="check_parent_email" class="form-control" id="check-email" value="<?=$ucemail?>">
										  <label for="vemail" class="col-md-4 col-sm-7 control-label">Verify Email</label>
										</div>
									  </div>
									  <?php if( isLoggedIn() ): ?>
										<p> Leave password blank to keep current password </p>
									  <?php endif; ?>
									  <div class="form-group">
										
										<div class="col-sm-12">
										  <input type="password" name="user_info[user_password]" class="form-control" id="password">
										  <label for="password" class="col-md-4 col-sm-7 control-label">Create Password</label>
										</div>
									  </div>
									  <div class="form-group">
										
										<div class="col-sm-12">
										  <input type="password" name="check_parent_password" class="form-control" id="check-password">
										  <label for="vpassword" class="col-md-4 col-sm-7 control-label">Verify Password</label>
										</div>
									  </div>
									  
									<?php echo $this->session->flashdata("flash"); ?>

									<p style="font-style:italic; font-size: 9px;"><span style="font-weight: bold; text-decoration: underline;">Please note:</span> If you have purchased more than one Dragon Bank, we recommend setting up only one account. After that, you can login and add additional children’s profiles to your account simply and easily, this will allow you to view multiple children’s profiles with one login.  If however you would like to have separate logins for each child, you can create one account per child but must use different email addresses for each account setup. </p>
								</div>


								<div class="col-sm-5 col-sm-offset-2">
									<h3>Child's Info</h3>
						
									  <div class="form-group">
									   
									    <div class="col-sm-12">
									      <input type="text" name="child_info[user_first_name]" class="form-control" id="child-firstname" value="<?=$cfirst?>">
									       <label for="child-firstname" class="col-md-5 col-sm-5 control-label">First Name</label>
									    </div>
									  </div>
				                        <div class="form-group">
				                            
				                            <div class="col-sm-12">
				                                <input type="text" name="child_info[user_last_name]" class="form-control" id="child-lastname" value="<?=$cfirst?>">
				                                <label for="child-lastname" class="col-md-5 col-sm-5 control-label">Last Name</label>
				                            </div>
				                        </div>
									  <div class="form-group">
									    
									    <div class="col-sm-12">
									      <input type="text" name="child_info[birthday]" class="form-control datepicker" id="birth" value="<?=$birth?>">
									      <label for="birth" class="col-md-5 col-sm-5 control-label">Birth Date</label>
									    </div>
									  </div>
									  <div class="form-group">
									   
									    <div class="col-sm-12">
									      <select class="singup-select" name="child_info[gender]" id="gender" value="<?=$gender?>">
											<option value="Male" <?php if( $gender == "Male" ){echo 'selected="selected"';}?>>Male</option>
											<option value="Female" <?php if( $gender == "Female" ){echo 'selected="selected"';}?>>Female</option>
										  </select>
										   <label for="gender" class="col-sm-12 control-label">Gender</label>
									    </div>
									  </div>
										<div class="form-group">
									  
									    <div class="col-md-7 col-sm-7">
									      <input type="text" name="child_info[user_name]" class="form-control" id="username" value="<?=$user?>">
									        <label for="child-username" class="col-md-5 col-sm-5 control-label">Username</label>
									    </div>
									  </div>
									  <div class="form-group">
									   
									    <div class="col-md-7 col-sm-7">
									      <input type="password" name="child_info[user_password]" class="form-control" id="child-password">
									       <label for="child-password" class="col-md-5 col-sm-5 control-label">Create Password</label>
									    </div>
									  </div>
									  <div class="form-group">
									   
									    <div class="col-md-7 col-sm-7">
									      <input type="password" name="check_child_password" class="form-control" id="child-vpassword">
									       <label for="child-vpassword" class="col-md-5 col-sm-5 control-label">Verify Password</label>
									    </div>
									  </div> 
									  <!--
									  <div class="form-group">
									    <label class="col-md-5 col-sm-5">Allowance</label>
									    <div class="col-md-3 col-sm-3">
									      <label class="checkbox-inline"><input type="radio" name="doallowance" <?php if( $doallowance == "yes" ): echo "checked='checked'"; endif; ?> id="allowance1" value="yes"> YES</label>
									    </div>
									    <div class="col-md-3 col-sm-3">
									      <label class="checkbox-inline"><input type="radio" name="doallowance" <?php if( $doallowance == "no" ): echo "checked='checked'"; endif; ?> id="allowance2" value="no"> NO</label>
									    </div>
									  </div>
									  --> 
									  
									  <div class="form-group">
									   
									    <div class="col-sm-12">
									      <input type="text" name="child_info[allowance]" class="form-control" id="allowance-amount" value="<?=$allowance?>">
									       <label for="allowance-amount" class="col-sm-12 control-label">Allowance Amount</label>
									    </div>
									  </div>
				                        <p style="font-style:italic; font-size: 9px;"><span style="font-weight: bold; text-decoration: underline;">Please note:</span> Leave the above field blank if no allowance is going to be paid.  However, we recommend paying your child an allowance for chores they complete around the house.  Please see the ‘Dragon Bank Parents Manual’ for ideas on age appropriate chores.  </p>
									  <div class="form-group">
									    
									    <div class="col-sm-12">
									      <select class="singup-select" id="allowance_frequency" name="child_info[allowance_frequency]" >
											<option <?php if( $freq == "WEEK" ): echo "selected='selected'"; endif; ?>  value="WEEK" >Weekly</option>
											<option <?php if( $freq == "MONTH" ): echo "selected='selected'"; endif; ?> value="MONTH" >Monthly</option>
										  </select>
										  <label for="deposit" class="col-sm-12 control-label">Allowance Frequency</label>
									    </div>
									  </div>
									  <div class="form-group" id="paid">
									   
									    <div class="col-sm-12" id="paid-weekly" style="display: block;">
									      <select class="singup-select" id="allowance_frequency" name="child_info[allowance_payday]">
											<option <?php if( $paidon == 1 ): echo "selected='selected'"; endif; ?> value=1>Monday</option>
											<option <?php if( $paidon == 2 ): echo "selected='selected'"; endif; ?> value=2>Tuesday</option>
											<option <?php if( $paidon == 3 ): echo "selected='selected'"; endif; ?> value=3>Wednesday</option>
											<option <?php if( $paidon == 4 ): echo "selected='selected'"; endif; ?> value=4>Thursday</option>
											<option <?php if( $paidon == 5 ): echo "selected='selected'"; endif; ?> value=5>Friday</option>
											<option <?php if( $paidon == 6 ): echo "selected='selected'"; endif; ?> value=6>Saturday</option>
											<option <?php if( $paidon == 0 ): echo "selected='selected'"; endif; ?> value=0>Sunday</option>
										  </select>
										   <label for="deposit" class="col-sm-12 control-label">When Allowance is Paid</label>
									    </div>
										<div class="col-sm-12" id="paid-monthly" style="display: none;" >
											<select class="singup-select" name="child_info[allowance_payday]" disabled="disabled" >
												<?php foreach( range(1, 31) as $k => $v ): ?>
													<option <?php if( $paidon == $v ): echo "selected='selected'"; endif; ?> value=<?=$v?>><?=$v?></option>
												<?php endforeach; ?>
											</select>
										</div>
									  </div>
									  <div class="form-group">
									   
									    <div class="col-sm-12">
									      <input type="text" name="init_deposit" class="form-control" id="deposit" value="<?= $init_deposit?>" >
									       <label for="deposit" class="col-md-8 col-sm-8 control-label">Initial Dragon Bank Deposit</label>
									    </div>
									  </div>
				                        <p style="font-style:italic; font-size: 9px;"><span style="font-weight: bold; text-decoration: underline;">Please note:</span> This is the amount of money being deposited into the Dragon Bank as the starting balance.</p>
				                        <?php if( ! isset( $this->sud->parent_id ) ): ?>
									  <div class="form-group">
										
										<div class="col-sm-12">
											<input type="checkbox" class="form-control blend check" name="child_info[drsub]" id="drsub" value="1" checked="checked">
											<label for="drsub" class="control-label newsletter">Dragon Bank Newsletter</label>
											
										</div>
									  </div>
				                            
										<?php endif; ?>
									  <input type="hidden" name="code" value="<?= $code ?>">
									  <div class="form-group">
									    <label class="col-sm-12"></label>
									    <div class="text-right">
									      <button type="submit" id="submit" class="btn btn-order btn-order-xs btn-primary next-step"> Next Step <div class="glare"></div> </button>
									    </div>
									  </div>
								</div>
							</div>

							</form>
						</div>
					</div>
				</div>
	*/