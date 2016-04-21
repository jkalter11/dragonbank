<div class="content-body">

<img src="<?=ASS_IMG_PATH?>parent-title.png" alt="parent dashboard" class="singup-title" />

<!--<a href="profile" class="back-link">back to profile</a> -->

<div class="row border-bottom space-top">

	<form class="form-horizontal order-form singup-form singup-form-5" method="POST" role="form" id="parent-edit">

		<div class="col-sm-7">

			<p class="form-title">parent's info</p>

			<div class="form-group">
				<label for="firstname" class="col-md-4 col-sm-7 control-label">First Name</label>
				<div class="col-md-8 col-sm-5">
					<input type="text" name="user_info[user_first_name]" class="form-control" id="firstname" value="<?=$ufname?>">
				</div>
			</div>
			<div class="form-group">
				<label for="lastname" class="col-md-4 col-sm-7 control-label">Last Name</label>
				<div class="col-md-8 col-sm-5">
					<input type="text" name="user_info[user_last_name]" class="form-control" id="lastname" value="<?=$ulname?>">
				</div>
			</div>
			<?php /*
				<div class="form-group">
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
				<label for="email" class="col-md-4 col-sm-7 control-label">Email</label>
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
			<p> Leave password blank to keep current password </p>
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
			<div class="text-right">
				<button type="submit" name="parent_submit" id="parent_submit" class="btn btn-order btn-order-xs"> UPDATE <div class="glare"></div> </button>
			</div>

		</div>

		<div class="col-sm-5">

			<p class="form-title">COMMUNICATION SETTINGS</p>

			<div class="form-group">
				<label for="dragon_newsletter" class="col-md-9 col-sm-7 control-label">Dragon Bank Wealth Building Newsletter</label>
				<div class="col-md-2 col-sm-5">
					<input type="checkbox" name="comm_info[dragon]" class="form-control blend" id="newsletter" value="1" <?php if( $drnews ){ echo "checked='checked'"; } ?> >
				</div>
			</div>

			<div class="form-group">
				<label for="reminder" class="col-md-9 col-sm-7 control-label">Allowance Reminder</label>
				<div class="col-md-2 col-sm-5">
					<input type="checkbox" name="comm_info[allowance_reminder]" class="form-control blend" id="reminder" value="1" <?php if( $alnews ){ echo "checked='checked'"; } ?> >
				</div>
			</div>

			<div class="form-group">
				<label for="quarterly_reminder" class="col-md-9 col-sm-7 control-label">Quarterly Saving &amp; Giving Reminder</label>
				<div class="col-md-2 col-sm-5">
					<input type="checkbox" name="comm_info[quarterly_reminder]" class="form-control blend" id="partner" value="1" <?php if( $qunews ){ echo "checked='checked'"; } ?> >
				</div>
			</div>

			<br />

			<p class="form-title">AUTOMATIONS</p>

			<div class="form-group">
				<label for="allowance_status" class="col-md-9 col-sm-7 control-label">Automate Allowance</label>
				<div class="col-md-2 col-sm-5">
					<input type="checkbox" name="user_info[allowance_status]" class="form-control blend" id="allowance_status" value="1" <?php if( $alstatus ){ echo "checked='checked'"; } ?> >
				</div>
			</div>

		</div>
	</form>
	<div style="float: left;"><?php echo $this->session->flashdata("flash_parent"); ?></div>
</div><!-- .row -->


<div class="row">

	<div class="col-sm-3" style="margin-top: 0;">
		<p class="form-title">your child's info</p>
	</div>

	<div class="col-sm-6">

		<form class="form-horizontal order-form singup-form singup-form-5" method="POST" id="select-child" role="form">

			<div class="form-group">
				<label for="select-child" class="col-md-5 col-sm-5 control-label">SELECT A CHILD</label>
				<div class="col-md-7 col-sm-7">
					<select class="singup-select" name="child" id="select-child-select" onchange="showChildDiv(this.value)">
						<?php foreach( $child as $k => $v ): ?>
							<option value=<?=$k?> ><?=$v['user_full_name']?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

		</form>

	</div>

	<div>
		<a href="<?=BASE_URL();?>signup" class="btn btn-order btn-order-xxs btn-orange"> add a child's profile <div class="glare"></div> </a>
	</div>

</div><!-- .row -->

<?php foreach( $child as  $k => $v ): ?>
	<?php $the_child = "child #".($k+1); ?>
	<div class="row space-top select-child-div" id="child<?=$k?>" style="<?php echo ( $k == 0 )? 'display:block' : 'display:none'; ?>" >
		<a href="profile?child_id=<?=$v['child_id'];?>" class="btn btn-order btn-order-xxs btn-orange" style="font-size: 20px; padding-bottom: 35px;">Manage Money<div class="glare" style="margin-top: -22px"></div></a>
		<form enctype="multipart/form-data" role="form" method="POST" id="child-edit">
			<div class="col-sm-3">
				<p class="form-title"><?=$the_child?><br/><?=$v['user_full_name']?></p>

				<div class="profile-box" style="margin: 0;">

					<div class="profile-name">Profile Image</div>
					<img src="<?=ASS_PROFILE_PATH.$v['profile_image']?>" alt="profile" width="104" height="136" class="profile-pic" />
					<input style="background: none; border: none; margin: 0; padding: 0; box-shadow: none;" type="file" name="profile_image">
					<button type="submit" name="upload" id="upload" class="btn btn-order btn-order-xs" style="margin-top: 5px;">upload<div class="glare"></div></button>
				</div>
			</div>

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
				 */ ?>
				<div class="form-group">
					<label for="allowance-amount" class="col-md-8 col-sm-8 control-label">Enter allowance amount</label>
					<div class="col-md-4 col-sm-4">
						<input type="text" name="child_info[allowance]" class="form-control" id="allowance-amount" value="<?=$v['allowance']?>">
					</div>
				</div>
				<div class="form-group">
					<label for="deposit" class="col-md-8 col-sm-8 control-label">Allowance Frequency</label>
					<div class="col-md-4 col-sm-4">
						<select class="singup-select" id="allowance_frequency<?=$k?>" onchange="toggle_allowance_payday_multi('<?=$k?>')" name="child_info[allowance_frequency]" >
							<option <?php if( $v['allowance_frequency'] == "WEEK" ): echo "selected='selected'"; endif; ?>  value="WEEK" >Weekly</option>
							<option <?php if( $v['allowance_frequency'] == "MONTH" ): echo "selected='selected'"; endif; ?> value="MONTH" >Monthly</option>
						</select>
					</div>
				</div>
				<div class="form-group paid">
					<label for="deposit" class="col-md-8 col-sm-8 control-label">When Allowance is Paid</label>
					<div class="col-md-4 col-sm-4" id="paid-weekly<?=$k?>" style="display: block;">
						<select class="singup-select" name="child_info[allowance_payday]">
							<option <?php if( $v['allowance_payday'] == 1 ): echo "selected='selected'"; endif; ?> value=1>Monday</option>
							<option <?php if( $v['allowance_payday'] == 2 ): echo "selected='selected'"; endif; ?> value=2>Tuesday</option>
							<option <?php if( $v['allowance_payday'] == 3 ): echo "selected='selected'"; endif; ?> value=3>Wednesday</option>
							<option <?php if( $v['allowance_payday'] == 4 ): echo "selected='selected'"; endif; ?> value=4>Thursday</option>
							<option <?php if( $v['allowance_payday'] == 5 ): echo "selected='selected'"; endif; ?> value=5>Friday</option>
							<option <?php if( $v['allowance_payday'] == 6 ): echo "selected='selected'"; endif; ?> value=6>Saturday</option>
							<option <?php if( $v['allowance_payday'] == 0 ): echo "selected='selected'"; endif; ?> value=0>Sunday</option>
						</select>
					</div>
					<div class="col-md-4 col-sm-4" id="paid-monthly<?=$k?>" style="display: none;" >
						<select class="singup-select" name="child_info[allowance_payday]">
							<?php foreach( range(1, 31) as $key => $val ): ?>
								<option <?php if( $v['allowance_payday'] == $val ): echo "selected='selected'"; endif; ?> value=<?=$val?>><?=$val?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>

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
					<label class="red"><?php echo $this->session->flashdata("flash_child"); ?></label>
				</div>
				<div class="text-right">
					<button type="submit" name="child_submit" id="child_submit" class="btn btn-order btn-order-xs"> UPDATE <div class="glare"></div> </button>
				</div>
				<input type="hidden" name="child_info[user_id]" value="<?=$v['child_user_id']?>" >
				<input type="hidden" name="child_info[child_user_id]" id="child_user_id" value="<?=$v['child_user_id']?>" >
				<input type="hidden" name="child_info[child_id]" value="<?=$v['child_id']?>" >
			</div>
		</form>
		<div class="col-sm-2"></div>

	</div>
<?php endforeach; ?>
</div>