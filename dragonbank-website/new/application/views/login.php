<div class="content-body">

	<div class="singup-container">
		
		<div class="singup-box">
			
			<div class="row">
			
				<div class="col-md-5">
					
					<div class="singup-about">
						<img src="<?=ASS_IMG_PATH?>owners.png" alt="owners" class="owners" >
						<p><em>“The </em><strong>Dragon Bank</strong><em> is a fantastic investment in your child’s financial future...<strong>start saving the Dragon Way TODAY!</strong>”</em></p>
						<img src="<?=ASS_IMG_PATH?>signature.png" alt="signature" class="sign" >
					</div>
					
				</div>
				
				<div class="col-md-7">
					
					<form class="form-horizontal order-form singup-form" role="form" method="post" action="/new/login">
					
						<p class="form-title">account login</p>
						
					  <div class="form-group">
					    <label for="username" class="col-md-4 col-sm-5 control-label">Username</label>
					    <div class="col-md-8 col-sm-5">
					      <input type="text" name="user" class="form-control" id="username">
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="password" class="col-md-4 col-sm-5 control-label">Password</label>
					    <div class="col-md-8 col-sm-5">
					      <input type="password" name="user_password" class="form-control" id="password">
					    </div>
					  </div>
					  <p class="recovery">Forgot Password? <a href="passwordrecovery">Click Here</a> to reset it.</p>
					  <div class="form-group">
					    <label class="col-md-4 col-sm-5"></label>
					    <div class="col-md-8 col-sm-5 text-right">
					      <button type="submit" class="btn btn-order btn-order-xs"> login <div class="glare"></div> </button>
					    </div>
					  </div>
					  <?php echo $this->session->flashdata("login_flash"); ?>
					</form>

				</div>
			
			</div><!-- .row -->
			
		</div><!-- .singup-box -->
		
	</div><!-- .singup-container -->

</div>
