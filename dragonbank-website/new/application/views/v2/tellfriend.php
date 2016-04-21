				<div class="row">
					<div class="col-sm-12">
						<div class="col-content">
							<h1>Tell A Friend</h1>
							<div class="row">
								<div class="col-sm-6">
									<p>Thanks for sharing Dragon Bank with your friends! EVERYONE deserves financial awareness, and by sharing Dragon Bank with others, you are making a big difference in your friend's life.</p>
									<img src="<?=ASS_IMG_PATH?>order-dragon.png" alt="Dragon Bank" class="order-dragon" style="width: 100%;">
								</div>
								<div class="col-sm-4 col-sm-offset-1">
									<p>To invite your friends to learn about Dragon Bank and how it helps teach kids to Save, Spend and Give money wisely, simply fill out the form and click send.</p>
<?php
	display_message();
?>
									<form action="" method="post" class="form-horizontal default-form" role="form">
										<div class="form-group">
											<div class="col-sm-12">
												<input type="text" placeholder="Full Name*" name="full_name" class="form-control<?php if (isset($error_vars['full_name'])) { echo ' error'; } ?>" id="full_name" value="<?= $full_name;?>">
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-12">
												<input type="text" placeholder="Email Address*" name="email_address" class="form-control<?php if (isset($error_vars['email'])) { echo ' error'; } ?>" id="email" value="<?= $email;?>">
											</div>	
										</div>
										<div class="form-group">
											<div class="col-sm-12">
												<input type="text" placeholder="Confirm Email*" name="confirm_email" class="form-control<?php if (isset($error_vars['cemail'])) { echo ' error'; } ?>" id="cemail" value="<?= $cemail;?>">
											</div>	
										</div>
										<div class="form-group">
											<div class="col-sm-12">
												<input type="submit" name="tellfriend" id="tellfriend" class="btn btn-primary" value="Send">
											</div>
										</div>
									</form>	
								</div>
							</div>
						</div>
					</div>
				</div>