<div class="page-header">
  <h1>Product Codes <small>View and export all the product codes</small>
  <div class="pull-right">
	  <div class="btn-group">
		<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Add <span class="caret"></span></button>
		<ul class="dropdown-menu" role="menu">
		  <li><a href="#code" data-toggle="modal" data-target="#code">Add Code</a></li>
		  <li><a href="#entity" data-toggle="modal" data-target="#entity">Add Entity</a></li>
		</ul>
	  </div>
  </div>
</h1>
</div>
<div class="well well-sm">
	<div class="row">
		<div class="col-md-2">
			<select class="form-control" name="entity-search" id="entity-search">
				<?php foreach( $codelist as $k => $v ): ?>
					<option value="<?=$v['codelistname']?>"><?=$v['codelistname']?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="col-md-2"><input type="text" class="form-control datepicker" id="start" placeholder="From" onchange="searchDate();"></div>
		<div class="col-md-2"><input type="text" class="form-control datepicker" id="end" placeholder="To" onchange="searchDate();"></div>
		<div class="col-md-2 pull-right text-right"><a href="export_codes" id="exportCodes" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-floppy-save"></span> Export List</a></div>	
	</div>  
</div>

<table class="table table-striped">
  <thead>
	<tr>
	  <th>Code Number</th>
	  <th>Date</th>
	  <th>Export Date</th>
	</tr>
  </thead>
  <tbody id="table-striped-body">
	<!--tr and td added by jQuery-->
  </tbody>
</table>
<div id="pagination_wrapper">
<!-- Pagination inserted via jQuery -->
</div>
<div class="modal fade" id="entity" tabindex="-1" role="dialog" aria-labelledby="entityLabel" aria-hidden="true">
<form class="form-horizontal" role="form" method="POST" id="new-entity">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="myModalLabel">Add new Entity</h4>
	  </div>
	  <div class="modal-body">
		  <div class="form-group">
			<label for="name" class="col-sm-4 control-label">Name</label>
			<div class="col-sm-8">
			  <input type="text" class="form-control" name="codelistname" id="name" placeholder="Name">
			</div>
		  </div>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Save</button>
	  </div>
	</div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</form>
</div><!-- /.modal -->

<div class="modal fade" id="code" tabindex="-1" role="dialog" aria-labelledby="codeLabel" aria-hidden="true">
<form class="form-horizontal" role="form" method="POST">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Add new Code</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="gender" class="col-sm-4 control-label">Select Entity</label>
					<div class="col-sm-8">
						<select class="form-control" name="entity">
							<?php foreach( $codelist as $k => $v ): ?>
								<option value="<?=$v['codelistname']?>"><?=$v['codelistname']?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="codes" class="col-sm-4 control-label">Number of Product Codes to Generate</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="amount" id="codes" placeholder="Number of Product Codes to Generate">
					</div>
				</div>
				<div class="form-group">
					<hr>
					<label for="codes" class="col-sm-4 control-label">Company</label>
					<div class="col-sm-8">
						<select class="form-control" name="company" id="company">
							<option value="0">None</option>
<?php
	foreach ($companies as $c)
	{
?>
							<option value="<?= $c->id?>"><?= $c->name; ?></option>
<?php
	}
?>
						</select>
					</div>
				</div>
				<div id="regionaldirector-control" class="form-group collapse">
					<label for="codes" class="col-sm-4 control-label">Regional Director</label>
					<div class="col-sm-8">
						<select class="form-control" name="regionaldirector" id="regionaldirector">
							<option value="0">---</option>

						</select>
					</div>
				</div>
				<div id="advisor-control" class="form-group collapse">
					<label for="codes" class="col-sm-4 control-label">Advisor</label>
					<div class="col-sm-8">
						<select class="form-control" name="advisor" id="advisor">
							<option value="0">---</option>
						</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Generate Codes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</form>
</div><!-- /.modal -->
