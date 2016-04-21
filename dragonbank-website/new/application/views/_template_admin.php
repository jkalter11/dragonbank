<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dragon Bank Admin</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=CSS_PATH?>bootstrap.min.css" rel="stylesheet">
    <link href="<?=CSS_PATH?>theme/smoothness/jquery-ui-1.10.3.custom.min.css">
    <link href="<?=CSS_PATH?>admin.css" rel="stylesheet">
	<?php if( isset( $addCSS ) ): add_css($addCSS); endif;?>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?=JS_PATH?>html5shiv.js"></script>
      <script src="<?=JS_PATH?>respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  
  <div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="dashboard"><img src="<?=ASS_IMG_PATH?>logo-small.png" alt="logo-small" width="140" height="33"></a>
        </div>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?php echo BASE_URL_NEW; ?>logout">Logout</a></li>
          </ul>
      </div><!-- /.container -->
    </div><!-- /.navbar -->

    <div class="container">

      <div class="row row-offcanvas row-offcanvas-left">
      
      	<div class="col-xs-6 col-sm-3 sidebar-offcanvas fixed" id="sidebar" role="navigation">
			<div class="list-group">
				<a href="<?php echo BASE_URL_NEW; ?>admin/dashboard" class="list-group-item<?php if(the_url() == 'dashboard' ) { echo " active"; } ?>">Dashboard</a>
        <a href="<?php echo BASE_URL_NEW; ?>admin/companies/pagin" class="list-group-item<?php if(the_url() == 'companies' ) { echo " active"; } ?>">Manage Companies</a>
        <a href="<?php echo BASE_URL_NEW; ?>admin/regionaldirectors/pagin" class="list-group-item<?php if(the_url() == 'regionaldirectors' ) { echo " active"; } ?>">Manage Regional Directors</a>
        <a href="<?php echo BASE_URL_NEW; ?>admin/advisors/pagin" class="list-group-item<?php if(the_url() == 'advisors' ) { echo " active"; } ?>">Manage Advisors</a>
				<a href="<?php echo BASE_URL_NEW; ?>admin/parenting/pagin" class="list-group-item<?php if(the_url() == 'parenting') { echo " active"; } ?>">Manage Parents</a>
				<a href="<?php echo BASE_URL_NEW; ?>admin/children/pagin" class="list-group-item<?php if(the_url() == 'children') { echo " active"; }?>">Manage Children</a>
				<a href="<?php echo BASE_URL_NEW; ?>admin/code" class="list-group-item<?php if(the_url() == 'code') { echo " active"; } ?>">Product Codes</a>
				<a href="<?php echo BASE_URL_NEW; ?>admin/settings" class="list-group-item<?php if(the_url() == 'settings') {echo " active";}?>">System Settings</a>
				<a href="<?php echo BASE_URL_NEW; ?>admin/statistics" class="list-group-item<?php if(the_url() == 'statistics') {echo " active";}?>">View Statistics</a>
			</div>
        </div><!--/span-->

        <div class="col-xs-12 col-sm-9 col-sm-offset-3">
		  <p class="pull-left visible-xs">
			<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
		  </p>
			<?=$this->session->flashdata('flash'); ?>
			{content}
          
        </div><!--/span-->

      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; <?php echo date("Y"); ?> <a href="<?=BASE_URL_NEW;?>admin/dashboard" >EnRICHed Academy</a></p>
      </footer>

    </div><!--/.container-->



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?=JS_PATH?>jquery.js"></script>
    <script src="<?=JS_PATH?>bootstrap.min.js"></script>
    <script src="<?=JS_PATH?>jquery-ui-1.10.3.custom.min.js"></script>
    <script src="<?=JS_PATH?>admin.js"></script>
	<?php if( isset( $addJS ) ): add_js($addJS); endif;?>

  </body>
</html>
