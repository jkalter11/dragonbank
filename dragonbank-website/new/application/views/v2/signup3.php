				<div class="row">
					<div class="col-content">
						<div class="col-sm-12">
							<h1>Profile Setup - Step 3</h1>

							<div class="row">
								<div class="col-sm-12">
									<div class="pull-right attached-right">
										<div class="btn-group btn-steps">
											<button type="button" class="btn btn-step btn-step-title">Activation Progress</button>
											<button type="button" class="btn btn-step btn-step-active">step 1</button>
											<button type="button" class="btn btn-step btn-step-active">step 2</button>
											<button type="button" class="btn btn-step btn-step-active">step 3</button>
											<button type="button" class="btn btn-step">done</button>
										</div>
									</div>
								</div>
							</div>
<?php
	display_message();
?>

							<form class="form-horizontal default-form" role="form" id="signup3-edit" method="post">
							<div class="row">
<?php
	if (isset($init_deposit))
	{
?>
								<input type="hidden" name="init_deposit" id="init_deposit" value="<?= $init_deposit; ?>">
<?php
	}

?>
								<div class="col-sm-12">
									<table class="table table-condensed table-dragon">
										<thead>
											<tr>
												<th>Den Allocation</th>
												<th>Spend</th>
												<th>Save</th>
												<th>Give</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="table-input">
													<label>
														<input type="radio" name="allocation" id="den1" value="1" onclick="getAllocation();"<?php if ($allocation == 1) { echo ' checked'; }?>> Default
													</label>
												</td>
												<td><input type="hidden" name="spend1" value="80.00">80%</td>
												<td><input type="hidden" name="save1" value="10.00">10%</td>
												<td><input type="hidden" name="give1" value="10.00">10%</td>
											</tr>
											<tr>
												<td class="table-input">
													<label>
														<input type="radio" name="allocation" id="den2" value="2"<?php if ($allocation == 2) { echo ' checked'; }?>> The Dragon Saver 
													</label>
												</td>
												<td><input type="hidden" name="spend2" value="40.00">40%</td>
												<td><input type="hidden" name="save2" value="50.00">50%</td>
												<td><input type="hidden" name="give2" value="10.00">10%</td>
											</tr>
											<tr>
												<td class="table-input">
													<label>
														<input type="radio" name="allocation" id="den3" value="3"<?php if ($allocation == 3) { echo ' checked'; }?>> Across the Dens 
													</label>
													</td>
												<td><input type="hidden" name="spend3" value="33.40">33.4%</td>
												<td><input type="hidden" name="save3" value="33.30">33.3%</td>
												<td><input type="hidden" name="give3" value="33.30">33.3%</td>
											</tr>
											<tr>
												<td class="table-input">
													<label>
														<input type="radio" name="allocation" id="den4" value="4"<?php if ($allocation == 4) { echo ' checked'; }?>> Custom
													</label>
												</td>
												<td><input type="text" class="form-control den-form custom<?php if (isset($error_vars['spend']) || isset($error_vars['total'])) { echo ' error'; } ?>" id="spend" name="spend4" value="<?= $spend; ?>"></td>
												<td><input type="text" class="form-control den-form custom<?php if (isset($error_vars['save']) || isset($error_vars['total'])) { echo ' error'; } ?>" id="save" name="save4" value="<?= $save; ?>"></td>
												<td><input type="text" class="form-control den-form custom<?php if (isset($error_vars['give']) || isset($error_vars['total'])) { echo ' error'; } ?>" id="give" name="give4" value="<?= $give; ?>"></td>
											</tr>				 
<?php
	if (isset($init_deposit))
	{
?>
											<tr>
												<td class="td-white">Current Dens Balance</td>
												<td class="td-white init_deposit"></td>
												<td class="td-white init_deposit"></td>
												<td class="td-white init_deposit"></td>
											</tr>							
<?php
	}
?>
										</tbody>
									</table>

									<div class="form-group">
										<div class="col-sm-12 top-margin text-right">
											<input type="submit" name="activate_step3" id="submit" class="btn btn-lg btn-primary" value="I'm Done!">
										</div>
									</div>
								</div>
	
							</div>


							</form>
						</div>
					</div>
				</div>
				<div>{name}</div>
				<div>{nameg}</div>
