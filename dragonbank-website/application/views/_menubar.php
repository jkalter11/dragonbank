<?php
/*
 * This is an internal view fragment that builds the main menu bar
 */
?>  
	<div class="container">
	
		<div class="top-menu">
  		  <ul class="nav navbar-nav navbar-right navbar-social nav-show">
			<li><a href="https://www.facebook.com/thedragonbank" class="btn-fb"><img src="<?=ASS_IMG_PATH?>fb.png" alt="fb" width="22" height="21"></a></li>
			<li><a class="btn-tw"><img src="<?=ASS_IMG_PATH?>tw.png" alt="tw" width="22" height="21"></a></li>
		  </ul>
          <ul class="nav navbar-nav navbar-right navbar-log nav-show">
			<?php if( isLoggedIn() ): ?>
			    <li><a href="<?=BASE_URL();?>profile/profile" class="btn btn-warning btn-login"></span>Profile</a></li>
			    <li><a href="<?=BASE_URL()?>logout" class="btn btn-warning btn-login"></span>Logout</a></li>
			<?php else: ?>
			    <li><a href="<?=BASE_URL();?>signup" class="btn btn-danger btn-singup"><span class="glyphicon glyphicon-lock"></span>Sign-up</a></li>
			    <li><a href="login" class="btn btn-warning btn-login"><span class="glyphicon glyphicon-lock"></span>Login</a></li>
			<?php endif; ?>
		  </ul>
  		</div>

		<div class="row img-adapt">
			<div class="col-md-4 col-sm-4 col-xs-6 text-left"><img src="<?=ASS_IMG_PATH?>enriched_logo.png" alt="enRICHed ACADEMY"></div>
			<div class="col-md-4 col-sm-4 text-center row-logo"><img src="<?=ASS_IMG_PATH?>logo.png" alt="Dragon Bank"></div>
			<div class="col-md-4 col-sm-4 col-xs-6 text-right"><img src="<?=ASS_IMG_PATH?>dragon_small.png" alt="Dragon Bank Image"></div>
		</div>
	  
		<div class="navbar navbar-default navbar-static-top">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><img src="<?=ASS_IMG_PATH?>logo-small.png" alt="logo-small" width="140" height="33"></a>
			</div>
			<div class="navbar-collapse collapse">
				<?php 
					if( isset( $menu ) && is_array( $menu ) )
						echo createMenu( $menu ); 
				?>
				<ul class="nav navbar-nav navbar-right navbar-social nav-hide">
					<li><a href="https://www.facebook.com/thedragonbank" class="btn-fb"><img src="<?=ASS_IMG_PATH?>fb.png" alt="Facebook" width="22" height="21"></a></li>
					<li><a class="btn-tw"><img src="<?=ASS_IMG_PATH?>tw.png" alt="Twitter" width="22" height="21"></a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right navbar-log  nav-hide">
					<?php if( isLoggedIn() ): ?>
						<li><a href="<?=BASE_URL();?>profile/profile" class="btn btn-warning btn-login"></span>Profile</a></li>
						<?php if($this->sud->type_id > 0 && $this->sud->user_group == 2): ?><li><a href="<?=BASE_URL();?>signup" class="btn btn-danger btn-singup btn-add"></span>Add Child</a></li><?php endif; ?>
						<li><a href="<?=BASE_URL()?>logout" class="btn btn-warning btn-login"></span>Logout</a></li>
					<?php else: ?>
						<li><a href="<?=BASE_URL();?>signup" class="btn btn-danger btn-singup"><span class="glyphicon glyphicon-lock"></span>Sign-up</a></li>
						<li><a href="login" class="btn btn-warning btn-login"><span class="glyphicon glyphicon-lock"></span>Login</a></li>
					<?php endif; ?>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div><!-- /container -->