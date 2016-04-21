<div class="content-body">

	<div class="row">
	
		<div class="col-md-4 col-sm-4">
		
			<img src="<?=ASS_IMG_PATH?>profile-title.png" alt="Parents Profile" class="singup-title" />
			
		</div>
		
		<div class="col-md-4 col-sm-4 text-center">
			
			<img src="<?=ASS_IMG_PATH?>logo.png" alt="Dragon Bank" class="singup-title" />
			
		</div>
		
		<?php if( $this->sud->user_group == 2 ): ?>
			<div class="col-md-4 col-sm-4 text-right">
				
				<a href="parentsprofile" class="small-link profile-link" style="font-size: 14px; letter-spacing: 2px;">Go Back To Parent's Dashboard</a>
				
			</div>
		<?php endif ?>
	</div><!-- .row -->
	
	<div class="profile-body">
	
		<div class="pull-left profile-box">
		
			<div style="font-size: 25px;" class="profile-name"><?= $user_full_name; ?></div>
			<div class="profile-pic"><img src="<?=ASS_PROFILE_PATH?><?=$profile_image?>" alt="kid profile" width="104" height="136" /></div>
			<?php if( (int)$this->sud->type_id > 0 && $this->sud->user_group == 3): ?>
				<a href="kidprofile" class="small-link">edit...</a>
			<?php endif; ?>
		</div><!-- .profile-box -->
		
		<div class="pull-right profile-btn">
		
			<a href="deposit<?=$get?>" class="btn btn-order btn-order-xs"> deposit <div class="glare"></div> </a>
			<a href="withdraw<?=$get?>" class="btn btn-order btn-order-xs"> withdraw <div class="glare"></div> </a>
			<a href="history<?=$get?>" class="btn btn-order btn-order-xs btn-red"> history <div class="glare"></div> </a>
			
		</div><!-- .profile-btn -->
		
		<div class="recap">
		<div class="row">
			
			<div class="col-sm-3">
				
				<span class="amount">$<?= $spend_amount; ?></span>
				<span class="percent"><?= $spend ?>%<br/>SPEND</span>
				<a href="history<?php echo ($get!="")? $get."&h=sp" : "?h=sp";?>" class="saving-history">Spending History</a>
				<span class="w-date"><?=$sp_trans?> Date<br/><?=$spend_date?></span>
				
			</div>
			
			<div class="col-sm-1"></div>
			
			<div class="col-sm-3">
			
				<span class="amount">$<?= $save_amount; ?></span>
				<span class="percent"><?= $save ?>%<br/>SAVE</span>
				<a href="history<?php echo ($get!="")? $get."&h=sa" : "?h=sa";?>" class="saving-history">Saving History</a>
				<span class="w-date"><?=$sa_trans?> Date<br/><?=$save_date?></span>
				
			</div>
			
			<div class="col-sm-1"></div>
			
			<div class="col-sm-3">
			
				<span class="amount">$<?= $give_amount; ?></span>
				<span class="percent"><?= $give ?>%<br/>GIVE</span>
				<a href="history<?php echo ($get!="")? $get."&h=gi" : "?h=gi";?>" class="saving-history">Giving History</a></span>
				<span class="w-date"><?=$gi_trans?> Date<br/><?=$give_date?></span>
				
			</div>
		
		</div><!-- .row -->
		</div><!-- .recap -->
	
	</div><!-- .profile-body -->
	
</div><!-- .content-body -->