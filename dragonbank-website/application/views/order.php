<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/blitzer/jquery-ui.css">
<div class="content-body">
	<div class="row">
		<div class="col-md-5">
			<p class="what-title"><img src="<?=ASS_IMG_PATH?>order-title.png" alt="Order Now" class="order-title1" /></p>
			<div class="what-txt">
				<p>The Dragon Banks are individually available for sale at select Staples stores across Canada and at Mastermind Toys. Call the Staples or Mastermind Toy store nearest you to make sure they have them in stock.</p>

				<p>If you wish to place an order for 12 or more Dragon Banks, please fill out the form on the right. We will contact you within 2 business days.
				</p>
			<img src="<?=ASS_IMG_PATH?>order-dragon.png" alt="Dragon Bank" class="order-dragon" />
			</div>
			<img src="<?=ASS_IMG_PATH?>order-form-btm.png" alt="order-form" class="order-form-btm" />
		</div>
		
		<div class="col-md-7">
			<?php echo $this->session->flashdata("flash"); ?>
			<form class="form-horizontal order-form" role="form" method="post" id="order-form">
			  <div class="form-group">
			    <label for="fname" class="col-md-4 col-sm-4 control-label"><span class="red">*</span> First Name</label>
			    <div class="col-md-6 col-sm-6">
			      <input type="text" name="fname" class="form-control" id="fname" value="<?= $fname ?>">
			    </div>
			  </div>
				<div class="form-group">
					<label for="lname" class="col-md-4 col-sm-4 control-label"><span class="red">*</span> Last Name</label>
					<div class="col-md-6 col-sm-6">
						<input type="text" name="lname" class="form-control" id="lname" value="<?= $lname ?>">
					</div>
				</div>
			  <div class="form-group">
			    <label for="company" class="col-md-4 col-sm-4 control-label">Company</label>
			    <div class="col-md-6 col-sm-6">
			      <input type="text" name="company" class="form-control" id="company" value="<?= $company ?>">
			    </div>
			  </div>
				<div class="form-group">
					<label for="address" class="col-md-4 col-sm-4 control-label">Address</label>
					<div class="col-md-6 col-sm-6">
						<input type="text" name="address" class="form-control" id="address" value="<?= $address ?>" >
					</div>
				</div>
			  <div class="form-group">
			    <label for="city" class="col-md-4 col-sm-4 control-label">City</label>
			    <div class="col-md-6 col-sm-6">
			      <input type="text" name="city" class="form-control" id="city" value="<?= $city ?>" >
			    </div>
			  </div>
				<div class="form-group">
					<label for="prov" class="col-md-4 col-sm-4 control-label">Prov/State</label>
					<div class="col-md-6 col-sm-6">
						<input type="text" name="prov" class="form-control" id="prov" value="<?= $prov ?>" >
					</div>
				</div>
				<div class="form-group">
					<label for="postal" class="col-md-4 col-sm-4 control-label">Postal/Zip</label>
					<div class="col-md-6 col-sm-6">
						<input type="text" name="postal" class="form-control" id="postal" value="<?= $postal ?>" >
					</div>
				</div>
			  <div class="form-group">
			    <label for="email" class="col-md-4 col-sm-4 control-label"><span class="red">*</span> Email Address</label>
			    <div class="col-md-6 col-sm-6">
			      <input type="email" name="email" class="form-control" id="email" value="<?= $email ?>" >
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="verifyemail" class="col-md-4 col-sm-4 control-label"><span class="red">*</span> Verify Email Address</label>
			    <div class="col-md-6 col-sm-6">
			      <input type="email" name="check-email" class="form-control" id="verifyemail" value="<?= $cemail ?>">
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="phone" class="col-md-4 col-sm-4 control-label">Cellphone</label>
			    <div class="col-md-6 col-sm-6">
			      <input type="text" name="phone" class="form-control" id="phone" value="<?= $phone ?>" >
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="message" class="col-md-4 col-sm-4 control-label">Message</label>
			    <div class="col-md-6 col-sm-6">
			      <textarea class="form-control" name="message" rows="4" id="message" ><?= $message ?></textarea>
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="captcha" class="col-md-4 col-sm-4 control-label"></label>
			    <div class="col-md-6 col-sm-6">
			    	<small>Please enter the text you see on the below for verification</small>
			      <div class="form-group">
				    <label class="col-md-4 col-sm-4 control-label"><?= $this->session->userdata('image'); ?></label>
					
				    <div class="col-md-8">
				      <input type="text" name="captcha" class="form-control" id="captcha">
				    </div>
					<p><a href="#" id="refresh-captcha">refresh</a></p>
				  </div>
			    </div>
			  </div>
			  <div class="form-group">
			    <label class="col-md-4 col-sm-4 control-label"></label>
			    <div class="col-md-6 col-sm-6 text-center">
					<button type="submit" class="btn btn-order btn-order-xs">send info<div class="glare"></div></button>
			    </div>
			  </div>
			  
			</form>

		</div><!-- .col-md-7 -->
	</div><!-- .row -->

</div>
