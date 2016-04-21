<div class="content-body">

	<img src="<?=ASS_IMG_PATH?>deposit-title.png" alt="Make a Deposit" class="singup-title" />

	<div class="row">
	
		<div class="col-sm-3">
			
			<a href="profile<?= $get; ?>" class="back-link">back to profile</a>
			
		</div>
		
		<div class="col-sm-6 border-blu center-content">
			
		<?php echo $this->session->flashdata("bank_transaction"); ?>
			
			<form class="form-horizontal order-form singup-form singup-form-4" role="form" method="POST">
			
			  <div class="form-group">
			    <label for="amount" class="col-md-8 col-sm-7 control-label">Amount to Deposit<span class="pull-right">$</span></label>
			    <div class="col-md-4 col-sm-5">
			      <input type="text" class="form-control" name="money" id="money">
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="lastname" class="col-md-8 col-sm-7 control-label">Deposit to</label>
			    <div class="col-md-4 col-sm-5">
			      <select class="singup-select" name="allocation" id="bank-allocations">
				    <option value=<?php echo json_encode($default)?>>Default</option>
					<option value=<?php echo json_encode($spending)?>>spending</option>
					<option value=<?php echo json_encode($saving)?>>saving</option>
					<option value=<?php echo json_encode($giving)?>>giving</option>
				  </select>
			    </div>
			  </div>
			  <div class="form-group">
				<div class="col-md-4 col-sm-12 text-center">
					<div class="xx">$0.00</div>
					<div class="perc-block"><span><?=$spend?></span>%<br/>spend</div>
					<input type="hidden" name="perc[]" value=<?=$spend?>>
				</div>
			    <div class="col-md-4 col-sm-12 text-center">
				  <div class="xx">$0.00</div>
				  <div class="perc-block"><span><?=$save?></span>%<br/>save</div>
				  <input type="hidden" name="perc[]" value=<?=$save?>>
			    </div>
			    <div class="col-md-4 col-sm-12 text-center">
			      <div class="xx">$0.00</div>
			      <div class="perc-block"><span><?=$give?></span>%<br/>give</div>
				  <input type="hidden" name="perc[]" value=<?=$give?>>
			    </div>

			  </div>
			  <div class="form-group">
			    <label for="reason" class="col-md-8 col-sm-7 control-label">Reason to Deposit</label>
			    <div class="col-md-4 col-sm-5">
			      <input type="text" class="form-control" name="desc" id="reason">
			    </div>
			  </div>
			  <div class="text-center">			
				<button type="submit" class="btn btn-order btn-order-xs"> done <div class="glare"></div> </button>
				</div>
			</form>

		</div>
		
		<div class="col-sm-3"></div>
	
	</div>
	
</div>