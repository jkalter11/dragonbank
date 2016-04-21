<?php echo $this->session->flashdata("flash"); ?>

<div class="content-body">

	<div class="singup-container">
	
		<img src="<?=ASS_IMG_PATH?>singup1.png" alt="profile setup 1" class="singup-title" />
		
		<div class="pull-right attached-right">
		
			<div class="btn-group btn-steps">
				<button type="button" class="btn btn-step btn-step-title">Setup progress</button>
				<button type="button" class="btn btn-step btn-step-active">step 1</button>
				<button type="button" class="btn btn-step">step 2</button>
				<button type="button" class="btn btn-step">step 3</button>
				<button type="button" class="btn btn-step">done</button>
			</div>
			
		</div>
		
	</div><!-- .singup-container -->

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
					<?php/* if( ! isLoggedIn() ): ?>
					<form class="form-horizontal order-form singup-form" role="form" method="post" action="login">
					
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
					    <label class=""></label>
					    <div class="text-right">
					      <button type="submit" class="btn btn-order btn-order-xs"> login <div class="glare"></div> </button>
					    </div>
					  </div>
					  
					</form>
					<?php endif;
					<div class="blu-line"><!--<div class="blu-dot">or</div>--></div>*/?>
					
					<form class="form-horizontal order-form singup-form" role="form" id="signup-edit" method="POST">
						
						<?php if( ! isLoggedIn() ): ?>
							<p class="form-title">SIGN UP!</p>
						<?php else: ?>
							<p class="form-title">ADD ANOTHER CHILD</p>
						<?php endif; ?>
						<p class="form-title">ENTER YOUR VIP CARD ACCESS CODE</p>
					  <div class="form-group">
					    <label for="code" class="col-md-4 col-sm-5 control-label">Access code</label>
					    <div class="col-md-8 col-sm-5">
					      <input type="text" class="form-control" name="code" id="code">
					    </div>
					  </div>
					  <div class="form-group">
					    <label class=""></label>
					    <div class="text-right">
					      <button type="submit" class="btn btn-order btn-order-xs"> next step <div class="glare"></div> </button>
					    </div>
					  </div>
					  
					</form>
					
				</div>
			
			</div><!-- .row -->
			
		</div><!-- .singup-box -->
		
	</div><!-- .singup-container -->

</div>