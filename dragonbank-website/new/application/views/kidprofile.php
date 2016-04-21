<div class="content-body">

	<img src="<?=ASS_IMG_PATH?>kid-profile.png" alt="kid-profile" class="My Profile" />

	<div class="row">
	<?php foreach( $child as  $k => $v ): ?>
	<form enctype="multipart/form-data" role="form" method="POST" id="child-edit">
		<div class="col-sm-3">
			<p class="form-title"><br/><?=$v['user_full_name']?></p>
			
			<div class="profile-box" style="margin: 0;">
				
				<div class="profile-name">Profile Image</div>
				<img src="<?=ASS_PROFILE_PATH.$v['profile_image']?>" alt="profile-pic" width="104" height="136" class="profile-pic" />
				<input style="background: none; border: none; margin: 0; padding: 0; box-shadow: none; margin-bottom: 10px;" type="file" name="profile_image">
				<button type="submit" name="upload" id="upload" class="btn btn-order btn-order-xs">upload<div class="glare"></div></button>
			</div>
		</div>
		<?php echo $this->session->flashdata("flash_child"); ?>
        <div class="col-sm-7 center-content form-horizontal order-form singup-form">

            <div class="col-sm-7 center-content form-horizontal order-form singup-form">
                <p class="form-title">child's info</p>
                <div class="form-group">
                    <label for="child-firstname" class="col-md-5 col-sm-5 control-label">First Name</label>
                    <div class="col-md-7 col-sm-7">
                        <input type="text" name="child_info[user_first_name]" class="form-control" id="child-firstname" value="<?=reset(explode(" ", $v['user_full_name'] ) );?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="child-lastname" class="col-md-5 col-sm-5 control-label">Last Name</label>
                    <div class="col-md-7 col-sm-7">
                        <input type="text" name="child_info[user_last_name]" class="form-control" id="child-lastname" value="<?=end(explode(" ", $v['user_full_name'] ) );?>">
                    </div>
                </div>
				<div class="form-group">
					<label for="birth" class="col-md-5 col-sm-5 control-label">Birth Date</label>
					<div class="col-md-7 col-sm-7">
						<input type="text" name="child_info[birthday]" class="form-control datepicker" id="birth" value="<?=$v['birthday']?>">
					</div>
				</div>
				<div class="form-group">
					<label for="gender" class="col-md-5 col-sm-5 control-label">Gender</label>
					<div class="col-md-7 col-sm-7">
						<select class="singup-select" name="child_info[gender]" id="gender" value="<?=$v['gender']?>">
							<option value="Male" <?php if( $v['gender'] == "Male" ){echo 'selected="selected"';}?>>Male</option>
							<option value="Female" <?php if( $v['gender'] == "Female" ){echo 'selected="selected"';}?>>Female</option>
						</select>
					</div>
				</div>
				<?php /*
				<div class="form-group">
					<label for="child-username" class="col-md-5 col-sm-5 control-label">Username</label>
					<div class="col-md-7 col-sm-7">
						<input type="text" name="child_info[user_name]" class="form-control" id="username" value="<?=$v['user_name']?>">
					</div>
				</div>
				<p> Leave password blank to keep current password </p>
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
				</div>
				

				<div class="form-group">
					<label for="allowance-amount" class="col-md-8 col-sm-8 control-label">Enter allowance amount</label>
					<div class="col-md-4 col-sm-4">
						<input type="text" name="child_info[allowance]" class="form-control" id="allowance-amount" value="<?=$v['allowance']?>">
					</div>
				</div>
				<div class="form-group">
					<label for="deposit" class="col-md-8 col-sm-8 control-label">What frequency is allowance paid?</label>
					<div class="col-md-4 col-sm-4">
						<select class="singup-select" name="child_info[allowance_frequency]">
							<option <?php if( $v['allowance_frequency'] == "WEEKLY" ): echo "selected='selected'"; endif; ?>  value="WEEKLY" >Weekly</option>
							<option <?php if( $v['allowance_frequency'] == "MONTHLY" ): echo "selected='selected'"; endif; ?> value="MONTHLY" >Monthly</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="deposit" class="col-md-8 col-sm-8 control-label">When is allowance paid?</label>
					<div class="col-md-4 col-sm-4">
						<select class="singup-select" name="child_info[allowance_payday]">
							<option <?php if( $v['allowance_payday'] == 1 ): echo "selected='selected'"; endif; ?> value=1>Monday</option>
							<option <?php if( $v['allowance_payday'] == 2 ): echo "selected='selected'"; endif; ?> value=2>Tuesday</option>
							<option <?php if( $v['allowance_payday'] == 3 ): echo "selected='selected'"; endif; ?> value=3>Wednesday</option>
							<option <?php if( $v['allowance_payday'] == 4 ): echo "selected='selected'"; endif; ?> value=4>Thursday</option>
							<option <?php if( $v['allowance_payday'] == 5 ): echo "selected='selected'"; endif; ?> value=5>Friday</option>
							<option <?php if( $v['allowance_payday'] == 6 ): echo "selected='selected'"; endif; ?> value=6>Saturday</option>
							<option <?php if( $v['allowance_payday'] == 7 ): echo "selected='selected'"; endif; ?> value=7>Sunday</option>
						</select>
					</div>
				</div>
			*/ ?>
				<div class="table-responsive">
					
					<table class="table table-condensed table-dragon">
						<thead>
							<tr>
								<th>den allocation</th>
								<th>Spend</th>
								<th>Save</th>
								<th>Give</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="table-input"><label><input type="radio" name="child_info[allocation_type]" id="den1" class="den" value=1 <?php if( $v['allocation_type'] == 1 ){ echo "checked='checked'";}?> > Default</label></td>
								<td><input type="hidden" name="child_info[spend][1]" value=80.00>80%</td>
								<td><input type="hidden" name="child_info[save][1]" value=10.00>10%</td>
								<td><input type="hidden" name="child_info[give][1]" value=10.00>10%</td>
							</tr>
							<tr>
								<td class="table-input"><label><input type="radio" name="child_info[allocation_type]" id="den2" class="den" value=2 <?php if( $v['allocation_type'] == 2 ){ echo "checked='checked'";}?> > The Dragon Saver <small>what is it?</small></label></td>
								<td><input type="hidden" name="child_info[spend][2]" value=40.00>40%</td>
								<td><input type="hidden" name="child_info[save][2]" value=50.00>50%</td>
								<td><input type="hidden" name="child_info[give][2]" value=10.00>10%</td>
							</tr>
							<tr>
								<td class="table-input"><label><input type="radio" name="child_info[allocation_type]" id="den3" class="den" value=3 <?php if( $v['allocation_type'] == 3 ){ echo "checked='checked'";}?> > Across the Dens <small>what is it?</small></label></td>
								<td><input type="hidden" name="child_info[spend][3]" value=33.40>33.4%</td>
								<td><input type="hidden" name="child_info[save][3]" value=33.30>33.3%</td>
								<td><input type="hidden" name="child_info[give][3]" value=33.30>33.3%</td>
							</tr>
							<tr>
								<td class="table-input"><label><input type="radio" name="child_info[allocation_type]" id="den4" class="den" value=4 <?php if( $v['allocation_type'] == 4 ){ echo "checked='checked'";}?> > Custom</label></td>
								<td><input type="text" class="form-control den-form custom" id="spend" name="child_info[spend][4]" value=<?=$v['spend']?>></td>
								<td><input type="text" for="den4" class="form-control den-form custom" id="save" name="child_info[save][4]" value=<?=$v['save']?>></td>
								<td><input type="text" for="den4" class="form-control den-form custom" id="give" name="child_info[give][4]" value=<?=$v['give']?>></td>
							</tr>
							
						</tbody>
					</table>
				</div>
				<label class="red"></label>
				<div class="text-right">			
					<button type="submit" name="child_submit" id="child_submit" class="btn btn-order btn-order-xs"> UPDATE <div class="glare"></div> </button>
				</div>
				<input type="hidden" name="child_info[user_id]" value="<?=$v['child_user_id']?>" >
				<input type="hidden" name="child_info[child_user_id]" id="child_user_id" value="<?=$v['child_user_id']?>" >
				<input type="hidden" name="child_info[child_id]" value="<?=$v['child_id']?>" >
		    </div>
        </div>
	</form>
	<div class="col-sm-2"></div>
		
	<?php break; endforeach; ?>
	</div>
	
</div>