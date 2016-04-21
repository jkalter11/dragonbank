				<div class="row">
					<div class="col-content clearfix challenges">
						<div class="col-sm-9 border-right relative" id="challenges-left">
<?php
	display_message();
?>
							<div id="challenge-head" class="col-content relative">
								<div class="row">
									<div class="col-sm-12 text-center">
										<h1><?= trim($challenge->title); ?></h1>
									</div>
								</div>
								<div id="sub-nav">
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
	
	if ($achievementStatus == -1)
	{
?>
									<input type="hidden" name="challenge" value="<?= $challengeID; ?>">
									<input type="hidden" name="child_id" value="<?= $child_id; ?>">
									<input type="submit" name="complete" class="btn btn-primary btn-xs" value="Complete">
<?php
	}
	else if ($achievementStatus == 0)
	{
?>
									<input type="submit" disabled name="complete" class="btn btn-warning btn-xs" value="Awaitng Approval">
<?php
	}
?>
									</form>
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
						<div class="col-sm-3" id="challenges-right">						
							<div class="select-child-panel-div">
								<div class="text-center">
									<h3><?= $user_full_name; ?></h3>
									<img src="<?= ASS_PROFILE_PATH . $profile_image; ?>" alt="profile" title="profile" width="105" height="135"><br>
<?php 
	if ((int)$this->sud->type_id > 0 && $this->sud->user_group == 3)
	{
?>
									<a href="kidprofile" class="btn btn-danger btn-xs" style="position: relative; top: -5px;">Edit Profile</a>
<?php		
	}
?>
								</div>
<?php
	$from = new DateTime($birthday);
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
	if (isset($supports) && !empty($supports))
	{
?>
								<div class="row">
									<div class="col-sm-4 text-right no-h-padding">
										<strong>Supports:</strong>
									</div>
									<div class="col-sm-8">
										<?= trim($supports); ?>
									</div>
								</div>
<?php	
	}
?>

								<div id="achievements">
									<h4 class="ribbon"><div>ACHIEVEMENTS</div></h4>
<?php
	getAchievements($this->session->userdata('type_id'));
?>
								</div>
							</div>
						</div>
					</div>
				</div>