				<div class="row">
					<div class="col-content">
						<div class="col-sm-12">
							<h1>Order Now</h1>
							<div class="row">
								<div class="col-sm-7">
									<p>The Dragon Banks are a very unique resource for parents and kids and a great way to help teach and inspire money management in your children. If you would like a Dragon Bank, or are interested in placing a larger order to distribute to clients, schools or other groups, simply fill out the information on the right and we will contact you immediately.</p>
									<img src="<?=ASS_IMG_PATH?>order-dragon.png" alt="Dragon Bank" class="order-dragon" width="100%">
								</div>
								<div class="col-sm-4">
									<?php echo $this->session->flashdata("flash"); ?>
									<form class="form-horizontal default-form" role="form" method="post" id="order-form">
										<div class="form-group">
									   
											<div class="col-sm-12">
												<input type="text" name="fname" class="form-control" id="fname" value="<?= $fname ?>">
												<label for="fname" class="col-sm-12 control-label"><span class="red">*</span> First Name</label>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-12">
												<input type="text" name="lname" class="form-control" id="lname" value="<?= $lname ?>">
												<label for="lname" class="col-sm-12 control-label"><span class="red">*</span> Last Name</label>
											</div>
										</div>
										<div class="form-group">
										
											<div class="col-sm-12">
												<input type="text" name="company" class="form-control" id="company" value="<?= $company ?>">
												<label for="company" class="col-sm-12 control-label">Company</label>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-12">
												<input type="text" name="address" class="form-control" id="address" value="<?= $address ?>" >
												<label for="address" class="col-sm-12 control-label">Address</label>
											</div>
										</div>
										<div class="form-group">
										
											<div class="col-sm-12">
												<input type="text" name="city" class="form-control" id="city" value="<?= $city ?>" >
												<label for="city" class="col-sm-12 control-label">City</label>
											</div>
										</div>
										<div class="form-group">
											
											<div class="col-sm-12">
												<input type="text" name="prov" class="form-control" id="prov" value="<?= $prov ?>" >
												<label for="prov" class="col-sm-12 control-label">Prov/State</label>
											</div>
										</div>
										<div class="form-group">
											
											<div class="col-sm-12">
												<input type="text" name="postal" class="form-control" id="postal" value="<?= $postal ?>" >
												<label for="postal" class="col-sm-12 control-label">Postal/Zip</label>
											</div>
										</div>
										<div class="form-group">
										
											<div class="col-sm-12">
												<input type="email" name="email" class="form-control" id="email" value="<?= $email ?>" >
												<label for="email" class="col-sm-12 control-label"><span class="red">*</span> Email Address</label>
											</div>
										</div>
										<div class="form-group">
										
											<div class="col-sm-12">
												<input type="email" name="check-email" class="form-control" id="verifyemail" value="<?= $cemail ?>">
												<label for="verifyemail" class="col-sm-12 control-label"><span class="red">*</span> Verify Email Address</label>
											</div>
										</div>
										<div class="form-group">
										
											<div class="col-sm-12">
												<input type="text" name="phone" class="form-control" id="phone" value="<?= $phone ?>" >
												<label for="phone" class="col-sm-12 control-label">Cellphone</label>
											</div>
										</div>
										<div class="form-group">
										
											<div class="col-sm-12">
												<textarea class="form-control" name="message" rows="4" id="message" ><?= $message ?></textarea>
												<label for="message" class="col-sm-12 control-label">Message</label>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-12">
												<small>Please enter the text you see on the below for verification</small>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-5 control-label"><?= $this->session->userdata('image'); ?></label>
											<div class="col-sm-7">
												<input type="text" name="captcha" class="form-control" id="captcha">
												<a href="#" id="refresh-captcha">Refresh</a>
											</div>
										</div>

										<div class="form-group">
											<div class="col-sm-12 text-center">
												<button type="submit" class="btn btn-primary">Send Info</button>
											</div>
										</div>
									  
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>