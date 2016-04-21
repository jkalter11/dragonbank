<div class="content-body">

	<img src="<?=ASS_IMG_PATH?>spending-title.png" alt="My History" class="singup-title" />

	<div class="row">
	
		<div class="col-md-3">
			
			<a href="profile<?=$get?>" class="back-link">back to profile</a>
			
		</div>
		
		<div class="col-md-6 border-blu center-content">
			
			<p><span class="text-success text-big">Total Dens Balance: $<?=$balance?></span> <strong>as of today <?=date("F d, Y");?></strong></p>
			<p>
				<?php 
				if( (float)$allowance > 0.00 && isset( $allowance_paydate ) && $allowance_paydate !== NULL ):
					echo "$". $allowance . " will be added on ". date("F jS, Y", strtotime($allowance_paydate)); 
				endif; 
				?></a></p>
			<p><?=date("F", $start)?> 01 - <?=date("F d", $end)?>, <?=date("Y", $start)?></p>
			
			<form method="get" id="date-search">
			
				<?php if( isset( $_GET['child_id'] ) ): ?>
				
					<input type="hidden" name="child_id" value="<?=(int)$_GET['child_id']?>">
					
				<?php endif; ?>
				
				<?php if( isset( $_GET['h'] ) ): ?>
				
					<input type="hidden" name="h" value="<?=$_GET['h']?>">
					
				<?php endif; ?>
				
				<p class="select-month"><strong>See Den Activity</strong> 
					<select class="den-select" name="year" id="year">
						<option value="0000">All</option>
						
						<?php foreach($years as $k => $v): ?>
						
							<?php if( $v == ( (int)date("Y") ) && ! isset( $sy ) ): ?>
							
								<option value="<?=$v?>" selected="selected"><?=$v?></option>
								
							<?php elseif( isset( $sy ) && $sy == $v ): ?>
							
								<option value="<?=$v?>" selected="selected"><?=$v?></option>
								
							<?php else: ?>
							
								<option value="<?=$v?>" ><?=$v?></option>
								
							<?php endif; ?>
							
						<?php endforeach; ?>
					</select>
					<select class="den-select" name="month" id="month">
						<option value="00" <?php if( ( isset($sm) && $sm == 0 ) || !isset( $sm ) ){ echo "selected='selected'"; } ?> >All</option>
						<option value="01" <?php if( isset($sm) && $sm == 1 ){ echo "selected='selected'"; } ?> >January</option>
						<option value="02" <?php if( isset($sm) && $sm == 2 ){ echo "selected='selected'"; } ?> >February</option>
						<option value="03" <?php if( isset($sm) && $sm == 3 ){ echo "selected='selected'"; } ?> >March</option>
						<option value="04" <?php if( isset($sm) && $sm == 4 ){ echo "selected='selected'"; } ?> >April</option>
						<option value="05" <?php if( isset($sm) && $sm == 5 ){ echo "selected='selected'"; } ?> >May</option>
						<option value="06" <?php if( isset($sm) && $sm == 6 ){ echo "selected='selected'"; } ?> >June</option>
						<option value="07" <?php if( isset($sm) && $sm == 7 ){ echo "selected='selected'"; } ?> >July</option>
						<option value="08" <?php if( isset($sm) && $sm == 8 ){ echo "selected='selected'"; } ?> >August</option>
						<option value="09" <?php if( isset($sm) && $sm == 9 ){ echo "selected='selected'"; } ?> >September</option>
						<option value="10" <?php if( isset($sm) && $sm == 10 ){ echo "selected='selected'"; } ?> >October</option>
						<option value="11" <?php if( isset($sm) && $sm == 11 ){ echo "selected='selected'"; } ?> >November</option>
						<option value="12" <?php if( isset($sm) && $sm == 12 ){ echo "selected='selected'"; } ?> >December</option>
					</select>
					<button type="submit" class="btn btn-default" id="search-date">Search</button>
				</p>
			</form>
			<!--<p>
				Money In: <span class="text-success text-big">$XX.XX</span> <span class="sep">	
				</span> Money Out: <span class="text-danger text-big">$XX.XX</span>
			</p>-->
			
			<div class="table-responsive">
				<table class="table table-striped history-table">
		          <thead>
		            <tr>
		              <th>Date</th>
		              <th>Den</th>
		              <th>Money In/Out</th>
		              <th>Balance</th>
		              <th>Description</th>
		            </tr>
		          </thead>
		          <tbody>
					<?php foreach( $history as $k => $v ): ?>
						<tr>
						  <td><?=$v['date']?></td>
						  <td><?=$v['transaction']?></td>
						  <td <?php echo ($v['minus'])?'class="text-danger"' : ""; ?> >$<?=$v['money']?></td>
						  <td>$<?=$v['balance']?></td>
						  <td><?=$v['desc']?></td>
						</tr>
					<?php endforeach; ?>
		          </tbody>
		        </table>
			</div>
			
			<div class="spending-bottom">
				<a href="deposit<?=$get?>" class="btn btn-order btn-order-xxs btn-green"> Make a deposit <div class="glare"></div> </a> 
				<a href="withdraw<?=$get?>" class="btn btn-order btn-order-xxs btn-orange"> make a withdrawal <div class="glare"></div> </a> 
				<!--<a href="#" class="small-text">Print</a>--> <a href="history/export<?=$export?>" class="small-text">Export</a>
			</div>
						
			<a href="profile<?=$get?>" class="btn btn-order btn-order-xs"> done <div class="glare"></div> </a>

		</div>
		
		<div class="col-md-3"></div>
	
	</div>
	
</div>