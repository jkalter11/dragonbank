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

		<link rel="stylesheet" href="<?= CSS_PATH; ?>/bootstrap/bootstrap.min.css">
		<link rel="stylesheet" href="<?= CSS_PATH; ?>/bootstrap/bootstrap-theme.min.css">
		<link rel="stylesheet" href="<?= CSS_PATH; ?>advisors.css">

		<script src="<?= JS_PATH; ?>vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	</head>

	<body>
		<div class="container main">
			<header>
			
				<div class="left-header">
					<a class="enriched" href="https://enrichedacademy.com/" target="_blank"></a>
					<h2>Advisor Dashboard</h2>
				</div>
<?php
	$companyData = $this->session->userdata('companyData');
	if (!empty($companyData['logo']))
	{
?>
				<img src="<?= COMPANY_PROFILE_PATH . $companyData['logo']; ?>" alt="<?= $companyData['name']; ?>" title="<?= $companyData['name']; ?>">
<?php
	}
	else
	{
?>
				<h3><?= $companyData['name']; ?></h3>
<?php
	}	
?>	
			</header>
			
			<div id="header-nav" class="row width-padding">
				<div class="col-sm-12">
					<div class="nav-bg clearfix">
						<nav id="secondary" class="navbar navbar-default navbar-right" role="navigation">
							<ul class="nav navbar-nav">
								<li<?= (the_url() == 'howitworks') ? ' class="active"' : ''; ?>><a href="/advisors/howitworks">How It Works</a></li>
<?php
	/*
								<li<?= (the_url() == 'getstarted') ? ' class="active"' : ''; ?>><a href="/advisors/getstarted">Get Started</a></li>
	*/
?>
								<li<?= (the_url() == 'faq') ? ' class="active"' : ''; ?>><a href="/advisors/faq">FAQ</a></li>
								<li<?= (the_url() == 'contact') ? ' class="active"' : ''; ?>><a href="/advisors/contact">Contact Us /Help</a></li>
								<li<?= (the_url() == 'settings') ? ' class="active"' : ''; ?>><a href="/advisors/settings">Settings</a></li>
								<li><a href="/logout">LOGOUT</a></li>
							</ul>
						</nav>
					</div>
				</div>
			</div>


			<div id="body" class="row">
				<div id="content-left" class="col-sm-9">
					<nav id="body-nav" role="navigation">
						<ul class="nav nav-pills nav-justified">
							<li<?= (the_url() == 'dashboard') ? ' class="active"' : ''; ?>><a href="/advisors/dashboard">My Dashboard</a></li>
							<li<?= (the_url() == 'clients') ? ' class="active"' : ''; ?>><a href="/advisors/clients">My Clients</a></li>
							<li<?= (the_url() == 'growmyprogram') ? ' class="active"' : ''; ?>><a href="/advisors/growmyprogram">Grow My Program</a></li>
							<li<?= (the_url() == 'tellcolleague') ? ' class="active"' : ''; ?>><a href="/advisors/tellcolleague">Tell My Colleague</a></li>
						</ul>
					</nav>
<?php
	if (the_url() == 'clients' || the_url() == 'growmyprogram')
	{
		load_advisor_stats();
	}
?>
					<h2>{pageheading}</h2>
<?php
	display_message();
?>
					{content}
				</div>

				<div id="content-right" class="col-sm-3">
<?php
	load_advisor_panel();

	load_code_usage();
?>

					<div id="order-questions" class="row">
						<div class="text-center">
							<a href="/advisors/order" class="btn btn-primary btn-lg">ORDER MORE BANKS</a>

							<form action="" method="post" class="form-horizontal" role="form" style="margin-top: 30px">
								<h4>Questions or Ideas?</h4>

								<div class="row">
									<div class="form-group">
										<div class="col-sm-offset-1 col-sm-10">
											<textarea class="form-control" name="questions-ideas" id="questions-ideas" rows="3"></textarea>
										</div>
									</div>
									<div class="form-group">
										<input type="submit" class="btn btn-primary" name="sendquestionsideas" id="sendquestionsideas" value="SUBMIT">
									</div>
								</div>
							</form>
						</div>
					</div>
					
				</div>

			</div>
			<footer>
				<div class="row">
					<div class="col-sm-12">
						Copyright &copy;2014 - enrichedacademy.com
					</div>
				</div>
			</footer>
		</div>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="<?= JS_PATH; ?>vendor/jquery-1.11.1.min.js"><\/script>')</script>

		<script src="<?= JS_PATH; ?>vendor/bootstrap.min.js"></script>

		<script src="<?= JS_PATH; ?>advisors.js"></script>

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