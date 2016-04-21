				<div class="row">
					<div class="col-content">
						<div class="col-sm-12">
							<h1>Profile Setup - Step 1</h1>

							<div class="row">
								<div class="col-sm-12">
									<div class="pull-right attached-right">
										<div class="btn-group btn-steps">
											<button type="button" class="btn btn-step btn-step-title">Activation Progress</button>
											<button type="button" class="btn btn-step btn-step-active">step 1</button>
											<button type="button" class="btn btn-step">step 2</button>
											<button type="button" class="btn btn-step">step 3</button>
											<button type="button" class="btn btn-step">done</button>
										</div>
									</div>
								</div>
							</div>
			
							<div class="row">
								<div class="col-sm-5">
									<img src="<?=ASS_IMG_PATH?>owners.png" alt="owners" class="owners" >
									<p><em>“The </em><strong>Dragon Bank</strong><em> is a fantastic investment in your child's financial future...<strong>start saving the Dragon Way TODAY!</strong>”</em></p>
									<img src="<?=ASS_IMG_PATH?>signature.png" alt="signature" class="sign" >
								</div>
								<div class="col-sm-5 col-sm-offset-2">
									<form class="form-horizontal order-form singup-form default-form" role="form" id="signup-edit" method="POST">
<?php 
	if (!isLoggedIn())
{
?>
									<h1>DON'T HAVE AN ACCOUNT? SIGN UP BELOW!</h1>
<?php 
	}
	else
	{
?>
									<h3>ADD ANOTHER CHILD</h3>
<?php 
	} 
?>
									<p>ENTER YOUR ACCESS CODE</p>
<?php
	display_message();
?>
									<div class="form-group">
										<div class="col-sm-12">
											<input type="text" class="form-control" name="code" id="code">
										</div>
										
									</div>
									<div class="form-group">
										<div class="text-right">
											<button type="submit" class="btn btn-order btn-order-xs btn-primary next-step"> Next Step <div class="glare"></div> </button>
										</div>
									</div>
									</form>
								</div>
							</div>
						</div>
						<div class="col-sm-12 text-center">
						</div>
					</div>
				</div>