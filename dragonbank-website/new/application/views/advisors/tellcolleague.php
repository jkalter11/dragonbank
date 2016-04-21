<div class="row">
	<div class="col-sm-6 border-right">
		<p>Everyone needs a little help and encouragement from time to time.</p>
		<p>To invite your colleague to capitalize on the Dragon Bank Program, simply fill out the form and click send.</p>
	</div>

	<div class="col-sm-6">
		<form action="" method="post" class="form-horizontal" role="form">
			<div class="form-group<?php if (isset($error_vars['name'])) { echo ' has-error has-feedback'; }?>">
				<label for="name" class="col-sm-4 control-label">Full Name</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="name" id="name" placeholder="Full Name" value="<?= $name; ?>">
				</div>
			</div>

			<div class="form-group<?php if (isset($error_vars['email'])) { echo ' has-error has-feedback'; }?>">
				<label for="email" class="col-sm-4 control-label">Email</label>
				<div class="col-sm-8">
					<input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?= $email; ?>">
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-8">
					<input type="submit" name="colleaguesend" value="Submit" class="btn btn-primary">
				</div>
			</div>
		</form>
	</div>
</div>