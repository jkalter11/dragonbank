<form action="" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
	<div class="row">
		<div class="col-sm-6 border-right">
			<div class="form-group<?php if (isset($error_vars['firstname'])) { echo ' has-error has-feedback'; }?>">
				<label class="col-sm-4 control-label">First Name*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="First Name" name="userdata[firstname]" id="firstname" value="<?= $firstname; ?>">
				</div>
			</div>

			<div class="form-group<?php if (isset($error_vars['lastname'])) { echo ' has-error has-feedback'; }?>">
				<label class="col-sm-4 control-label">Last Name*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="Last Name" name="userdata[lastname]" id="lastname" value="<?= $lastname; ?>">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label">Title / Position</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="Title / Position" name="advisordata[position]" id="position" value="<?= $position; ?>">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label">Company</label>
				<div class="col-sm-8">
					<p class="form-control-static"><?= $company; ?></p>
				</div>
			</div>

			<div class="form-group<?php if (isset($error_vars['address1'])) { echo ' has-error has-feedback'; }?>">
				<label class="col-sm-4 control-label">Address 1*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="Address 1" name="advisordata[address1]" id="address1" value="<?= $address1; ?>">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label">Address 2</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="e.g.: suite" name="advisordata[address2]" id="address2" value="<?= $address2; ?>">
				</div>
			</div>

			<div class="form-group<?php if (isset($error_vars['city'])) { echo ' has-error has-feedback'; }?>">
				<label class="col-sm-4 control-label">City*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="City" name="advisordata[city]" id="city" value="<?= $city; ?>">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label">Province*</label>
				<div class="col-sm-8">
					<select class="form-control" name="advisordata[province_id]" id="province_id">
<?php
	foreach ($provinces as $p)
	{
		$selected = '';
		if ($province_id == $p->id)
			$selected = ' selected';
?>
						<option value="<?= $p->id; ?>"<?= $selected; ?>><?= $p->name; ?></option>
<?php
	}
?>
						
					</select>
				</div>
			</div>

			<div class="form-group<?php if (isset($error_vars['postalcode'])) { echo ' has-error has-feedback'; }?>">
				<label class="col-sm-4 control-label">Postal Code*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="City" name="advisordata[postalcode]" id="postalcode" value="<?= $postalcode; ?>">
				</div>
			</div>

			<div class="form-group<?php if (isset($error_vars['user_phone'])) { echo ' has-error has-feedback'; }?>">
				<label class="col-sm-4 control-label">Office Number*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="Office Number" name="userdata[user_phone]" id="user_phone" value="<?= $user_phone; ?>">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label">Cell Number</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="Cell Number" name="advisordata[cell]" id="cell" value="<?= $cell; ?>">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label">Fax Number</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="Fax Number" name="advisordata[fax]" id="fax" value="<?= $fax; ?>">
				</div>
			</div>
		</div>

		<div class="col-sm-6">
<?php
	/*
			<div class="form-group">
				<label class="col-sm-4 control-label">Username</label>
				<div class="col-sm-8">
					<p class="form-control-static"><?= $user_name; ?></p>
				</div>
			</div>
			<hr>
	*/
?>
			<div class="form-group">
				<label class="col-sm-4 control-label">Photo</label>
				<div class="col-sm-8">
					<img src="<?= ADV_PROFILE_PATH . $photo; ?>" alt="" title="">
					<input type="file" name="photo" id="photo">
				</div>
			</div>
			<hr>

			<em>Fill both fields to change your email</em>
			<div class="form-group<?php if (isset($error_vars['user_email'])) { echo ' has-error has-feedback'; }?>">
				<label class="col-sm-4 control-label">Email*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="Email" name="userdata[user_email]" id="user_email" value="<?= $user_email; ?>">
				</div>
			</div>

			<div class="form-group<?php if (isset($error_vars['user_email'])) { echo ' has-error has-feedback'; }?>">
				<label class="col-sm-4 control-label">Confirm Email</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="Confirm Email" name="confirm_email" id="confirm_email">
				</div>
			</div>
			<hr>
			<em>Fill both fields to change your password</em>
			<div class="form-group<?php if (isset($error_vars['user_password'])) { echo ' has-error has-feedback'; }?>">
				<label class="col-sm-4 control-label">Password</label>
				<div class="col-sm-8">
					<input type="password" class="form-control" placeholder="Password" name="userdata[user_password]" id="user_password">
				</div>
			</div>

			<div class="form-group<?php if (isset($error_vars['user_password'])) { echo ' has-error has-feedback'; }?>">
				<label class="col-sm-4 control-label">Confirm Password</label>
				<div class="col-sm-8">
					<input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" id="confirm_password">
				</div>
			</div>
			

			<div class="form-group">
				<div class="col-sm-12">
					<input type="submit" name="save" id="save" class="btn btn-primary btn-block" value="SUBMIT">
				</div>
			</div>

		</div>
	</div>
	
</form>