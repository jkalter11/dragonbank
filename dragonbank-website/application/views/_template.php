<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="{keys}">
    <meta name="description" content="{desc}">
    <meta name="author" content="604media">

    <title>{pagetitle}</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=CSS_PATH?>bootstrap.min.css" rel="stylesheet">
    <link href="<?=CSS_PATH?>theme/smoothness/jquery-ui-1.10.3.custom.min.css">
    <link href="<?=CSS_PATH?>dragon.css" rel="stylesheet">
	<?php if( isset( $addCSS ) ): add_css($addCSS); endif;?>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	  <!--[if lt IE 9]>
	  <script src="<?=JS_PATH?>html5shiv.js"></script>
	  <script src="<?=JS_PATH?>respond.min.js"></script>
	  <![endif]-->

	  <!--[if lt IE 10]>
	  <link href="<?=CSS_PATH?>ie.css" rel="stylesheet">
	  <![endif]-->
  </head>

  <body>
	{main_menu}

	<div class="container">
	
      <div class="dragon-body">
		
      	{content}
      
      </div>
      
      <div class="footer">
      	<p class="pull-right"> &copy; <?php echo date("Y"); ?> <a href="https://enrichedacademy.com/" target="_blank">enRICHed Academy</a></p>
      	<p class="foot-nav"><a href="<?=BASE_URL?>./">home</a> | <a href="<?=BASE_URL?>contact">contact us</a> | <a href="<?=BASE_URL?>what">what it is</a> | <a href="<?=BASE_URL?>how">how it works</a> | <a href="<?=BASE_URL?>order">order now </a> | <a href="<?=BASE_URL?>legal">legal</a></p>
      </div>

	</div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?=JS_PATH?>jquery.js"></script>
    <script src="<?=JS_PATH?>bootstrap.min.js"></script>
    <script src="<?=JS_PATH?>jquery-ui-1.10.3.custom.min.js"></script>
    <script src="<?=JS_PATH?>dragon.js"></script>
	<?php if( isset( $addJS ) ): add_js($addJS); endif;?>
  </body>
</html>
