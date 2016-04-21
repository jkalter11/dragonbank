<div class="jumbotron">
  <h1>Hello, Admin!</h1>
  <p>Welcome to the Dragon Bank dashboard! The Dragon Bank team designed this website with a goal in mind to help all aspiring children develop into the next generation's Dragons.</p>
</div>
<h2>Quick Stats</h2>
<div class="row">
  <div class="col-6 col-sm-6 col-lg-4">
    <h5 class="text-center">Total Amount of Money in the Site</h5>
    <ul>
		<?php foreach( $amount as $k => $v ): ?>
			<li>Spend Amount <span class="label label-danger pull-right">$ <?= $v['spend'] ?></span></li>
			<li>Save Amount <span class="label label-success pull-right">$ <?= $v['save'] ?></span></li>
			<li>Give Amount <span class="label label-primary pull-right">$ <?= $v['give'] ?></span></li>
		<?php endforeach; ?>
    </ul>
  </div><!--/span-->
  <div class="col-6 col-sm-6 col-lg-4">
    <h5 class="text-center">Number of Registrations this Month</h5>
    <p class="h1 text-muted text-center"><?= $month ?></p>
  </div><!--/span-->
  <div class="col-6 col-sm-6 col-lg-4">
    <h5 class="text-center">Number of Registrations Today</h5>
    <p class="h1 text-muted text-center"><?= $today ?></p>
  </div><!--/span-->
</div><!--/row-->
<h2>Links</h2>
<div class="row">
  <div class="col-6 col-sm-6 col-lg-4">
    <p><a class="btn btn-primary btn-block" href="parenting" role="button">Manage Parents</a></p>
  </div><!--/span-->
  <div class="col-6 col-sm-6 col-lg-4">
    <p><a class="btn btn-primary btn-block" href="code" role="button">Product Codes</a></p>
  </div><!--/span-->
  <div class="col-6 col-sm-6 col-lg-4">
    <p><a class="btn btn-primary btn-block" href="settings" role="button">System Settings</a></p>
  </div><!--/span-->
</div><!--/row-->