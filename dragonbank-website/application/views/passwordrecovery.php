<div class="content-body">

	<div class="singup-container">
	
		<img src="<?=ASS_IMG_PATH?>recovery-title.png" alt="Password Recovery" class="singup-title" />
		
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
					
					<form class="form-horizontal order-form singup-form" role="form" method="POST">
					
						<p class="form-title">Password recovery</p>
						
					  <div class="form-group">
					    <label for="email" class="col-md-4 col-sm-5 control-label">email address</label>
					    <div class="col-md-8 col-sm-5">
					      <input type="email" name="email" class="form-control" id="email">
					    </div>
					  </div>
					  
					  <div class="form-group">
					    <label class="col-md-5 col-sm-5"></label>
					    <div class="col-md-5 col-sm-5 text-right">
					      <button type="submit" class="btn btn-order btn-order-xs"> send mail <div class="glare"></div> </button>
					    </div>
					  </div>
					  <?php echo $this->session->flashdata("flash"); ?>
					</form>

					
				</div>
			
			</div><!-- .row -->
			
		</div><!-- .singup-box -->
		
	</div><!-- .singup-container -->

</div>