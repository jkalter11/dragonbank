<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/blitzer/jquery-ui.css">
<div class="content-body">
	<div class="row">
		<div class="col-md-5">
			<p class="what-title"><img src="<?=ASS_IMG_PATH?>contactus.jpg" alt="Order Now" class="contact us" /></p>
			<div class="what-txt">
				<p>If you have any questions or require support with your Dragon Bank product, please contact us using the form to the right or call us at 1-800-892-9228.
				</p>
				<img src="<?=ASS_IMG_PATH?>order-dragon.png" alt="Dragon Bank" class="order-dragon" />
			</div>
		</div>
		<div class="col-md-7">
			<?php
			echo "<span style='color:red'>".validation_errors()."</span>";
			echo $flash;
			?>
			<form class="form-horizontal order-form" role="form" method="post" id="contact-form">
				<div class="form-group">
					<label for="fname" class="col-md-4 col-sm-4 control-label"><span class="red">*</span> Name</label>
					<div class="col-md-6 col-sm-6">
						<input type="text" name="name" class="form-control" id="name" value="<?php echo set_value('name'); ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="email" class="col-md-4 col-sm-4 control-label"><span class="red">*</span> Email Address</label>
					<div class="col-md-6 col-sm-6">
						<input type="email" name="email" class="form-control" id="email" value="<?php echo set_value('email'); ?>" >
					</div>
				</div>

				<div class="form-group">
					<label for="phone" class="col-md-4 col-sm-4 control-label">Phone</label>
					<div class="col-md-6 col-sm-6">
						<input type="text" name="phone" class="form-control" id="phone" value="<?php echo set_value('phone'); ?>" >
					</div>
				</div>
				<div class="form-group">
					<label for="message" class="col-md-4 col-sm-4 control-label"><span class="red">*</span> Message</label>
					<div class="col-md-6 col-sm-6">
						<textarea class="form-control" name="message" rows="4" id="message" ><?php echo set_value("message"); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="captcha" class="col-md-4 col-sm-4 control-label"></label>
					<div class="col-md-6 col-sm-6">
						<small>Please enter the text you see on the below for verification</small>
						<label style="margin-bottom: 10px" class="col-md-4 col-sm-4 control-label"><?= $this->session->userdata('image'); ?></label>
						<span><a style="position: relative; right: -41px; padding: 0; margin: 0;" href="#" id="refresh-captcha">refresh</a></span>
						<div class="form-group">
							<div class="col-md-8">
								<input type="text" name="captcha" class="form-control" id="captcha">
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 col-sm-4 control-label"></label>
					<div class="col-md-6 col-sm-6 text-center">
						<button type="submit" class="btn btn-order btn-order-xs">Submit<div class="glare"></div></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>