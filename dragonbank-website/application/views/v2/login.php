				<div class="row">
					<div class="col-sm-6">
						<div class="col-content">
							<img src="<?=ASS_IMG_PATH?>owners.png" alt="owners" class="owners" >
							<p><em>“The </em><strong>Dragon Bank</strong><em> is a fantastic investment in your child’s financial future...<strong>start saving the Dragon Way TODAY!</strong>”</em></p>
							<img src="<?=ASS_IMG_PATH?>signature.png" alt="signature" class="sign" >
						</div>
					</div>
					<div class="col-sm-6">
						<div class="col-content">
							<form class="form-horizontal default-form" role="form" method="post" action="/new/login">
						
								<h1>Account login</h1>
							
								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-2">
							  			<input type="text" name="user" class="form-control" id="username" placeholder="Username or Email">
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-2">
										<input type="password" name="user_password" class="form-control" id="password" placeholder="Password">
									</div>
						  		</div>

						  		<div class="form-group">
									<div class="col-sm-8 col-sm-offset-2">
										<input type="submit" class="btn btn-primary" value="Login">
									</div>
								</div>

								<div class="row">
									<div class="col-sm-8 col-sm-offset-2">
										<p>Forgot Password? <a href="/passwordrecovery">Click Here</a> to reset it.</p>
										<p>Need a Bank? <a href="/order">Click here</a> to learn more.</p>
									</div>
								</div>

								
								<?php echo $this->session->flashdata("login_flash"); ?>
							</form>
						</div>
					</div>
				</div>
