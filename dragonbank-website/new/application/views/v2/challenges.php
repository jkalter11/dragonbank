				<div class="row">
					<div class="col-content clearfix challenges">
						<div class="col-sm-9 border-right" id="challenges-left">
<?php
	display_message();
?>
							<div id="challenge-head" class="col-content relative">
								<div class="row">
									<div class="col-sm-12 text-center">
										<h1><?= trim($challenge->title); ?><img src="<?= ACH_IMG_PATH . $challenge->icon; ?>" alt="<?= trim($challenge->title); ?>" title="<?= trim($challenge->title); ?>"></h1>
									</div>
								</div>

								<div id="sub-nav">
<?php
	foreach ($child as $k => $v)
	{
?>
									<div class="select-child-panel-div" id="sub-nav<?=$k?>" style="<?php echo ( $k == 0 )? 'display:block' : 'display:none'; ?>">
										<form action="/profile/challenges?id=<?= $challengeID; ?>" method="post">
<?php
		if (isset($challenge->file) && !empty($challenge->file))
		{
?>
										<a href="/profile/challenges/print?id=<?= $challengeID; ?>" class="btn btn-primary btn-xs">Print</a>
<?php
		}
		else
		{
?>
										<a href="#" class="btn btn-primary btn-xs" onClick="window.print();">Print</a>
<?php
		}
		
		if ($v['achievementStatus'] == 0)
		{
?>
										<input type="hidden" name="challenge" value="<?= $challengeID; ?>">
										<input type="hidden" name="child_id" value="<?= $v['child_id']; ?>">
										<input type="submit" name="confirm_complete" class="btn btn-success btn-xs" value="Confirm Completion">
<?php
		}
?>
									
										</form>
									</div>
<?php
	}
?>
								</div>

								<div class="row top-margin">
									<div class="col-sm-12">
										<p><?= trim($challenge->description); ?></p>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-12">
										<h4><u class="red">The Challenge</u>: <?= trim($challenge->content1); ?></h4>
									</div>
								</div>
							</div>

							<div id="challenge-steps">
								<div class="col-content clearfix">

								
<?php
	$i = 1;
	foreach ($steps as $s)
	{
?>
									<div class="row">
										<div class="step-col">
											<span>STEP <?= $i; ?>:</span>
										</div>
										<div class="text-col">
											<?= trim($s->text) . "\n"; ?>
										</div>
									</div>
<?php
		$i++;
	}
?>
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-12">
									<h4 class="text-center">Don't forget to Click COMPLETE in the Dragon Bank to earn your Badge!</h4>
								</div>
							</div>

							<div id="challenge-lessons">
								<div class="col-content clearfix">
									<div class="row text-center">
										<h4>Lessons Learned</h4>
									</div>
<?php

	foreach ($lessons as $l)
	{
?>
									<div class="row lesson">
										<div class="col-sm-3 text-right no-h-padding">
											<strong><?= trim($l->heading); ?>:</strong>
										</div>
										<div class="col-sm-9">
											<?= trim($l->text) . "\n"; ?>
										</div>
									</div>
<?php
	}
?>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-8 col-sm-offset-2" id="facebook">
									<p class="text-center">HELP US <span>GROW.</span> <iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fthedragonbank&amp;width&amp;layout=button&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=35" scrolling="no" frameborder="0" allowTransparency="true"></iframe> US ON <a href="https://www.facebook.com/thedragonbank" target="_blank"><img src="<?= ASS_IMG_PATH . 'logo_facebook.jpg'; ?>" alt="Facebook" title="Facebook"></a></p>
									<p class="text-right">...because EVERYONE deserves financial <span>AWARENESS</span></p>
								</div>
							</div>
							
							
						</div>
						<div class="col-sm-3 top-margin" id="challenges-right">
							<form class="form-horizontal default-form" role="form" method="post">
								<div class="col-content clearfix">
									<div class="form-group">
										<div class="col-sm-12">
											
											<select class="form-control" name="child" id="select-child-select" onchange="showChildDiv(this.value)">
<?php 
	foreach ($child as $k => $v)
	{
?>
												<option value="<?= $k; ?>"><?= $v['user_full_name']; ?></option>
<?php 
	}
?>
											</select>
										</div>
									</div>
								</div>
								</form>
<?php 
	foreach ($child as $k => $v)
	{ 
?>							
							<div class="select-child-panel-div" id="child-panel<?=$k?>" style="<?php echo ( $k == 0 )? 'display:block' : 'display:none'; ?>">
								<div class="text-center">
									<img src="<?= ASS_PROFILE_PATH . $v['profile_image']; ?>" alt="profile" title="profile" width="104" height="136">
								</div>
<?php
		$from = new DateTime($v['birthday']);
		$to = new DateTime('today');

		$age = $from->diff($to)->y;
?>

								<div class="row">
									<div class="col-sm-4 text-right no-h-padding">
										<strong>Age:</strong>
									</div>
									<div class="col-sm-8">
										<?= $age; ?>
									</div>
								</div>
<?php
		if (isset($v['supports']) && !empty($v['supports']))
		{
?>
								<div class="row">
									<div class="col-sm-4 text-right no-h-padding">
										<strong>Supports:</strong>
									</div>
									<div class="col-sm-8">
										<?= trim($v['supports']); ?>
									</div>
								</div>
<?php	
		}
?>

								<div id="achievements">
									<h4 class="ribbon"><div>ACHIEVEMENTS</div></h4>
<?php
		getAchievements($v['child_id']);
?>
								</div>
							</div>
<?php
	}
?>
						</div>
					</div>
				</div>