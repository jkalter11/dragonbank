				<div class="row">
					<div class="col-sm-12">
						<div class="col-content">
							<h1>Contact Us</h1>
							<div class="row">
								<div class="col-sm-7">
									<p>If you have any questions or require support with your Dragon Bank product, please contact us using the form to the right or call us at 1-800-892-9228.</p>
									<img src="<?=ASS_IMG_PATH?>order-dragon.png" alt="Dragon Bank" class="order-dragon" />
								</div>
								<div class="col-sm-4">
<?php
	display_message();
?>
									<form action="" method="post" class="form-horizontal default-form" role="form">
										<div class="form-group">	   
											<div class="col-sm-12">
												<input type="text" name="contact_name" class="form-control" id="contact_name" value="<?= $contact_name ?>">
												<label for="fname" class="col-sm-12 control-label"><span class="red">*</span> Your Name</label>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-12">
												<input type="text" name="contact_email" class="form-control" id="contact_email" value="<?= $contact_email ?>">
												<label for="lname" class="col-sm-12 control-label"><span class="red">*</span> Your Email</label>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-12">
												<input type="text" name="contact_number" class="form-control" id="contact_number" value="<?= $contact_number ?>">
												<label for="company" class="col-sm-12 control-label">Your Contact Number</label>
											</div>
										</div>

										<div class="form-group">	
											<div class="col-sm-12">
												<label class="control-label"><span class="red">*</span> Message</label>
												<textarea class="form-control" name="contact_message" id="contact_message" rows="3"><?= $contact_message; ?></textarea>
											</div>
										</div>

										<div class="form-group">	
											<div class="col-sm-12">
												<input type="submit" name="contactsend" value="SUBMIT" class="btn btn-primary btn-block">
											</div>
										</div>

									</form>
								</div>
							</div>
						</div>
					</div>
				</div>