<div class="content-body">

	<div class="singup-container">
	
		<img src="<?=ASS_IMG_PATH?>singup2.png" alt="profile setup 2" class="singup-title" />
		
		<div class="pull-right attached-right">
		
			<div class="btn-group btn-steps">
				<button type="button" class="btn btn-step btn-step-title">Setup progress</button>
				<button type="button" class="btn btn-step btn-step-active">step 1</button>
				<button type="button" class="btn btn-step btn-step-active">step 2</button>
				<button type="button" class="btn btn-step">step 3</button>
				<button type="button" class="btn btn-step">done</button>
			</div>
			
		</div>
		
	</div><!-- .singup-container -->

	<div class="singup-container">
		
		<div class="singup-box">
			
			<div class="row">
			<?php $form_id = ( isLoggedIn() )? "signup2-edit-loggedin" : "signup2-edit"; ?>
			<form class="form-horizontal order-form singup-form singup-form-2" role="form" id="<?=$form_id;?>" method="POST">
			
				<div class="col-md-6">

						<p class="form-title">parent's info</p>
						
					  <div class="form-group">
					    <label for="firstname" class="col-md-4 col-sm-7 control-label">First Name</label>
					    <div class="col-md-8 col-sm-5">
					      <input type="text" name="user_info[user_first_name]" class="form-control" id="firstname" value="<?=$ufirst?>">
					    </div>
					  </div>
                    <div class="form-group">
                        <label for="lastname" class="col-md-4 col-sm-7 control-label">Last Name</label>
                        <div class="col-md-8 col-sm-5">
                            <input type="text" name="user_info[user_last_name]" class="form-control" id="lastname" value="<?=$ulast?>">
                        </div>
                    </div>
					 <?php /* <div class="form-group">
					    <label for="kids" class="col-md-4 col-sm-7 control-label">Number of kids</label>
					    <div class="col-md-8 col-sm-5">
					      <input type="text" name="user_info[kids]" class="form-control" id="kids" value="<?=$kids?>">
					    </div>
					  </div> */ ?>
					  <div class="form-group">
					    <label for="cell" class="col-md-4 col-sm-7 control-label">Cellphone Number</label>
					    <div class="col-md-8 col-sm-5">
					      <input type="text" name="user_info[user_phone]" class="form-control" id="phone" value="<?=$phone?>">
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="email" class="col-md-4 col-sm-7 control-label">Email <small>(username)</small></label>
					    <div class="col-md-8 col-sm-5">
					      <input type="email" name="user_info[user_email]" class="form-control" id="email" value="<?=$uemail?>">
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="vemail" class="col-md-4 col-sm-7 control-label">Verify Email</label>
					    <div class="col-md-8 col-sm-5">
					      <input type="email" name="check_parent_email" class="form-control" id="check-email" value="<?=$ucemail?>">
					    </div>
					  </div>
					  <?php if( isLoggedIn() ): ?>
						<p> Leave password blank to keep current password </p>
					  <?php endif; ?>
					  <div class="form-group">
					    <label for="password" class="col-md-4 col-sm-7 control-label">Create Password</label>
					    <div class="col-md-8 col-sm-5">
					      <input type="password" name="user_info[user_password]" class="form-control" id="password">
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="vpassword" class="col-md-4 col-sm-7 control-label">Verify Password</label>
					    <div class="col-md-8 col-sm-5">
					      <input type="password" name="check_parent_password" class="form-control" id="check-password">
					    </div>
					  </div>
					  
					<?php echo $this->session->flashdata("flash"); ?>

                    <p style="font-style:italic; font-size: 9px;"><span style="font-weight: bold; text-decoration: underline;">Please note:</span> If you have purchased more than one Dragon Bank, we recommend setting up only one account. After that, you can login and add additional children’s profiles to your account simply and easily, this will allow you to view multiple children’s profiles with one login.  If however you would like to have separate logins for each child, you can create one account per child but must use different email addresses for each account setup. </p>
				</div>
				
				<div class="col-md-6 border-left">
					
					<div class="form-horizontal order-form singup-form singup-form-2 no-top">
					
						<p class="form-title">child's info</p>
						
					  <div class="form-group">
					    <label for="child-firstname" class="col-md-5 col-sm-5 control-label">First Name</label>
					    <div class="col-md-7 col-sm-7">
					      <input type="text" name="child_info[user_first_name]" class="form-control" id="child-firstname" value="<?=$cfirst?>">
					    </div>
					  </div>
                        <div class="form-group">
                            <label for="child-lastname" class="col-md-5 col-sm-5 control-label">Last Name</label>
                            <div class="col-md-7 col-sm-7">
                                <input type="text" name="child_info[user_last_name]" class="form-control" id="child-lastname" value="<?=$cfirst?>">
                            </div>
                        </div>
					  <div class="form-group">
					    <label for="birth" class="col-md-5 col-sm-5 control-label">Birth Date</label>
					    <div class="col-md-7 col-sm-7">
					      <input type="text" name="child_info[birthday]" class="form-control datepicker" id="birth" value="<?=$birth?>">
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="gender" class="col-md-5 col-sm-5 control-label">Gender</label>
					    <div class="col-md-7 col-sm-7">
					      <select class="singup-select" name="child_info[gender]" id="gender" value="<?=$gender?>">
							<option value="Male" <?php if( $gender == "Male" ){echo 'selected="selected"';}?>>Male</option>
							<option value="Female" <?php if( $gender == "Female" ){echo 'selected="selected"';}?>>Female</option>
						  </select>
					    </div>
					  </div>
					  <?php /*<div class="form-group">
					    <label for="child-username" class="col-md-5 col-sm-5 control-label">Username</label>
					    <div class="col-md-7 col-sm-7">
					      <input type="text" name="child_info[user_name]" class="form-control" id="username" value="<?=$user?>">
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="child-password" class="col-md-5 col-sm-5 control-label">Create Password</label>
					    <div class="col-md-7 col-sm-7">
					      <input type="password" name="child_info[user_password]" class="form-control" id="child-password">
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="child-vpassword" class="col-md-5 col-sm-5 control-label">Verify Password</label>
					    <div class="col-md-7 col-sm-7">
					      <input type="password" name="check_child_password" class="form-control" id="child-vpassword">
					    </div>
					  </div> */ ?>
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
					    <label for="allowance-amount" class="col-md-8 col-sm-8 control-label">Allowance Amount</label>
					    <div class="col-md-4 col-sm-4">
					      <input type="text" name="child_info[allowance]" class="form-control" id="allowance-amount" value="<?=$allowance?>">
					    </div>
					  </div>
                        <p style="font-style:italic; font-size: 9px;"><span style="font-weight: bold; text-decoration: underline;">Please note:</span> Leave the above field blank if no allowance is going to be paid.  However, we recommend paying your child an allowance for chores they complete around the house.  Please see the ‘Dragon Bank Parents Manual’ for ideas on age appropriate chores.  </p>
					  <div class="form-group">
					    <label for="deposit" class="col-md-8 col-sm-8 control-label">Allowance Frequency</label>
					    <div class="col-md-4 col-sm-4">
					      <select class="singup-select" id="allowance_frequency" name="child_info[allowance_frequency]" >
							<option <?php if( $freq == "WEEK" ): echo "selected='selected'"; endif; ?>  value="WEEK" >Weekly</option>
							<option <?php if( $freq == "MONTH" ): echo "selected='selected'"; endif; ?> value="MONTH" >Monthly</option>
						  </select>
					    </div>
					  </div>
					  <div class="form-group" id="paid">
					    <label for="deposit" class="col-md-8 col-sm-8 control-label">When Allowance is Paid</label>
					    <div class="col-md-4 col-sm-4" id="paid-weekly" style="display: block;">
					      <select class="singup-select" id="allowance_frequency" name="child_info[allowance_payday]">
							<option <?php if( $paidon == 1 ): echo "selected='selected'"; endif; ?> value=1>Monday</option>
							<option <?php if( $paidon == 2 ): echo "selected='selected'"; endif; ?> value=2>Tuesday</option>
							<option <?php if( $paidon == 3 ): echo "selected='selected'"; endif; ?> value=3>Wednesday</option>
							<option <?php if( $paidon == 4 ): echo "selected='selected'"; endif; ?> value=4>Thursday</option>
							<option <?php if( $paidon == 5 ): echo "selected='selected'"; endif; ?> value=5>Friday</option>
							<option <?php if( $paidon == 6 ): echo "selected='selected'"; endif; ?> value=6>Saturday</option>
							<option <?php if( $paidon == 0 ): echo "selected='selected'"; endif; ?> value=0>Sunday</option>
						  </select>
					    </div>
						<div class="col-md-4 col-sm-4" id="paid-monthly" style="display: none;" >
							<select class="singup-select" name="child_info[allowance_payday]" disabled="disabled" >
								<?php foreach( range(1, 31) as $k => $v ): ?>
									<option <?php if( $paidon == $v ): echo "selected='selected'"; endif; ?> value=<?=$v?>><?=$v?></option>
								<?php endforeach; ?>
							</select>
						</div>
					  </div>
					  <div class="form-group">
					    <label for="deposit" class="col-md-8 col-sm-8 control-label">Initial Dragon Bank Deposit</label>
					    <div class="col-md-4 col-sm-4">
					      <input type="text" name="init_deposit" class="form-control" id="deposit" value="<?= $init_deposit?>" >
					    </div>
					  </div>
                        <p style="font-style:italic; font-size: 9px;"><span style="font-weight: bold; text-decoration: underline;">Please note:</span> This is the amount of money being deposited into the Dragon Bank as the starting balance.</p>
                        <?php if( ! isset( $this->sud->parent_id ) ): ?>
					  <div class="form-group">
						<label for="drsub" class="col-md-8 col-sm-8 control-label">Dragon Bank Newsletter</label>
						<div class="col-md-4 col-sm-4">
							<input type="checkbox" class="form-control blend" name="child_info[drsub]" id="drsub" value="1" checked="checked">
						</div>
					  </div>
                            <?php /*
						<div class="form-group">
							<label for="pasub" class="col-md-8 col-sm-8 control-label">Partner Network Newsletter</label>
							<div class="col-md-4 col-sm-4">
								<input type="checkbox" class="form-control blend" name="pasub" id="drsub" value="1" checked="checked">
							</div>
						</div> */ ?>
						<?php endif; ?>
					  <input type="hidden" name="code" value="<?= $code ?>">
					  <div class="form-group">
					    <label class="col-md-5 col-sm-5"></label>
					    <div class="col-md-5 col-sm-5 text-right">
					      <button type="submit" id="submit" class="btn btn-order btn-order-xs"> next step <div class="glare"></div> </button>
					    </div>
					  </div>
					</div>
					
				</div>
			</form>
			</div><!-- .row -->
			
		</div><!-- .singup-box -->
		
	</div><!-- .singup-container -->

</div>