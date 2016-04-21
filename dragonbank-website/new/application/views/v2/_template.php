<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>{pagetitle}</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" type="text/css" href="<?= CSS_PATH; ?>bootstrap/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?= CSS_PATH; ?>bootstrap/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="<?= CSS_PATH; ?>theme/smoothness/jquery-ui-1.10.3.custom.min.css">
		<link rel="stylesheet" type="text/css" href="<?= CSS_PATH; ?>main.css">
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Overlock:400,400italic,700,700italic,900,900italic">

		<script src="<?= JS_PATH; ?>vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	</head>

	<body>
<?php
	showToast();
?>
		<div class="container main">
			<header>
				<div class="row relative">
					<div class="col-sm-12">
						<a href="/?go=1"><img src="<?= ASS_IMG_PATH; ?>logo_v2.png" alt="Dragon Bank" title="Dragon Bank"></a>
						<div class="text-right" style="position: absolute; bottom: 0px; right: 15px">
<?php 
	if (isLoggedIn())
	{
?>
						<a href="/new/profile/tellafriend" class="btn btn-danger">Tell A Friend</a><br>
						<a href="/new/logout" class="btn btn-primary top-margin">Sign Out</a>
<?php
	}
	else
	{
?>
						<a href="/new/order" class="btn btn-primary">Need A Bank?</a><br>
						<a href="/new/login" class="btn btn-danger top-margin">Log In</a>
<?php
	}
?>
						</div>
					</div>
				</div>
			</header>

			<div id="body">
				<nav id="primary" class="row" role="navigation">
					<div class="col-sm-12" id="navpad">
						<div class="row">
							<div class="col-sm-12">
								<ul class="nav nav-pills navbar-right">
									<li><a href="/new/about">About Us</a></li>
									<li><a href="/new/how">How It Works</a></li>
<?php 
	/* <li><a href="/whowehelp">Who We Help</a></li> */ 
?>
									<li><a href="/new/privacy">Privacy Policy</a></li>
<?php 
	if (isLoggedIn())
	{
		// this is stupid
		$query = "SELECT id, title FROM activities_challenges WHERE type = 2 AND status = 1 ORDER BY `order` ASC";
		$results = $this->db->query($query);
		$results = $results->result();

	/*
									<li><a>Videos</a></li>
									<li><a>Activities</a></li>
									
									<li><a>Settings</a></li>
									<li><a>Activities</a></li>
	*/
?>
									<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Challenges <span class="caret"></span></a>
										<ul class="dropdown-menu" role="menu" aria-labelledby="challengesMenu">
<?php

		foreach ($results as $c)
		{
?>
										<li role="presentation"><a role="menuitem" href="/new/profile/challenges?id=<?= $c->id; ?>"><?= $c->title; ?></a></li>
<?php
		}
?>
										</ul>
									</li>					
<?php
		if ($this->session->userdata('user_group') == 2)
		{
?>
									<li><a href="/new/contact">Contact</a></li>
									<li><a href="/new/profile/parentsprofile">My Profile</a></li>
<?php
		}
		else if ($this->session->userdata('user_group') == 3)
		{
?>
									<li><a href="/new/profile/profile">My Money</a></li>
<?php
		}
	}
	else
	{
?>
									<li><a href="/new/contact">Contact</a></li>
<?php
	}
?>
								</ul>
							</div>
						</div>
					</div>
				</nav>
				{content}
				<footer>
					<div class="row">
						<div class="col-sm-12">
							<hr>
						</div>
<?php
	if (isLoggedIn())
	{
?>
						<div class="col-sm-9">
							<div class="footer-box">
								<span>WORDS OF WISDOM FOR PARENTS &AMP; CHILDREN</span>
								<div class="row quicktips-content">
<?php
		$hasAdvisor = load_advisor_panel();
?>
									<div class="col-sm-<?php echo (($hasAdvisor) ? '8' : '12'); ?>" id="quicktip">
<?php
		getTip();
?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="footer-box">
								<span>KIDS 10 &amp; UP</span>
								<a href="#enriched-video" id="enriched-video-btn" data-toggle="modal" data-target="#enriched-video"><img src="<?= ASS_IMG_PATH;?>smartstart_foot.jpg" alt="Enriched Start" title="Enriched Start"></a>
								<div class="modal" id="enriched-video">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
												<h4 class="modal-title">Enriched Academy</h4>
											</div>
											<div class="modal-body">
												<div class="text-center"><iframe width="560" height="315" src="//www.youtube.com/embed/KVcgOHUtkiI" frameborder="0" allowfullscreen></iframe></div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
										</div><!-- /.modal-content -->
									</div><!-- /.modal-dialog -->
								</div><!-- /.modal -->
							</div>
						</div>
<?php
	}
	else
	{
?>
						<div class="col-sm-3">
							<div class="footer-box">
								<span>FOR SCHOOLS</span>
								<a href="#" tabindex="0" id="for-schools-btn" data-toggle="popover" data-container="body" data-trigger="focus" data-placement="top" title="FOR SCHOOLS" data-content"For schools text"><img src="<?= ASS_IMG_PATH;?>schools_foot.jpg" alt="For Schools" title="For Schools"></a>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="footer-box">
								<span>FOR FAMILIES</span>
								<a href="#" tabindex="0" id="for-families-btn" data-toggle="popover" data-container="body" data-trigger="focus" data-placement="top" title="FOR FAMILIES" data-content"For families text"><img src="<?= ASS_IMG_PATH;?>families_foot.jpg" alt="For Families" title="For Families"></a>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="footer-box">
								<span>FOR ADVISORS &amp; AGENTS</span>
								<a href="#" tabindex="0" id="for-advisors-btn" data-toggle="popover" data-container="body" data-trigger="focus" data-placement="top" title="FOR ADVISORS &amp; AGENTS" data-content"For advisors and agents text"><img src="<?= ASS_IMG_PATH;?>advisor_foot.jpg" alt="For Advisors &amp; Agents" title="For Advisors &amp; Agents"></a>
							</div>
						</div>
						<div class="col-sm-3">
							<a class="activate-db" href="/new/signup"><span>Activate My Dragon Bank</span></a>
						</div>
<?php
	}
?>
					</div>
					<div class="row">
						<div class="col-sm-12" id="copyright">
							Copyright &copy; 2014 - enrichedacademy.com
						</div>
					</div>
				</footer>
			</div>
		</div>


		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="<?= JS_PATH; ?>vendor/jquery-1.11.1.min.js"><\/script>')</script>

		<script src="<?= JS_PATH; ?>vendor/bootstrap.min.js"></script>
<!--[if IE 8]>
<script src="<?= JS_PATH; ?>Placeholder/simple.js"></script>
<script src="<?= JS_PATH; ?>Placeholder/ie-behavior.js"></script>
<script src="<?= JS_PATH; ?>Placeholder/ie-behavior-span.js"></script>
<![endif]-->

<!--[if IE 9]>
<script src="<?= JS_PATH; ?>Placeholder/simple.js"></script>
<script src="<?= JS_PATH; ?>Placeholder/ie-behavior.js"></script>
<script src="<?= JS_PATH; ?>Placeholder/ie-behavior-span.js"></script>
<![endif]-->

		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<script src="<?= JS_PATH; ?>main.js"></script>
		<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<?php
	/*
		<script>
			(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
			function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
			e=o.createElement(i);r=o.getElementsByTagName(i)[0];
			e.src='//www.google-analytics.com/analytics.js';
			r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
			ga('create','UA-XXXXX-X');ga('send','pageview');
		</script>
	*/

	if (isset($addJS))
	{ 
		add_js($addJS); 
	}
?>
	</body>
</html>
