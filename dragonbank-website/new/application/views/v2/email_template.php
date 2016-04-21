<table width="100%" bgcolor="#88D0E9" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="center">
			<table width="600" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td><img src="http://dragonbank.com/assets/images/logo_v2.png" alt="Dragon Bank" title="Dragon Bank" style="display: block;"><br><img src="http://dragonbank.com/assets/images/bg_head_email.png" alt="Dragon Bank" title="Dragon Bank" style="display: block;">
					</td>
				</tr>
				<tr>
					<td>
						<table cellpadding="15" cellspacing="0" width="600" background="http://dragonbank.com/assets/images/bg_body_email.png">
							<tr>
<?php
	if (isset($advisor))
	{
?>
								<td width="130px" valign="bottom" style="font-size: 9px; border-right: 1px solid #AAA;">
<?php
		if (!empty($advisor['logo']))
		{
?>
									<img src="<?= COMPANY_PROFILE_PATH . $advisor['logo']; ?>" style="display: block; width: 100%"><br>
<?php
		}
		$fullname = $advisor['user_full_name'];

		$address = ((!empty($advisor['address2'])) ? $advisor['address2'] . ', ' : '') . $advisor['address1'];
?>
									<img src="<?= ADV_PROFILE_PATH . $advisor['photo']; ?>" style="display: block; width: 100%"><br>
									<strong><u><?= $advisor['company']; ?></u></strong><br>
									<strong><?= $advisor['user_full_name']; ?></strong><br>
									<?= $advisor['position']; ?><br>
									<?= $address; ?><br>
									<?= $advisor['city']; ?>, <?= $advisor['province_code']; ?> &nbsp; <?= $advisor['postalcode']; ?><br>
<?php
		if (!empty($advisor['user_phone']))
		{
?>
									p: <?= $advisor['user_phone']; ?><br>
<?php
		}

		if (!empty($advisor['cell']))
		{
?>
									c: <?= $advisor['cell']; ?><br>
<?php			
		}

		if (!empty($advisor['fax']))
		{
?>
									f: <?= $advisor['fax']; ?><br>
<?php			
		}
?>
									<a href="mailto:<?= $advisor['user_email']; ?>"><?= $advisor['user_email']; ?></a>
								</td>
<?php
	}
?>
								<td>
<?php 
	if (isset($name))
	{
?>
									<p style="font-size:12px;"><?= $name; ?></p>
<?php
	}




	if (isset($intro))
	{
?>
									<p style="font-size:12px; margin-bottom:10px; line-height:1.6em;"><?= $intro; ?></p>
<?php
	}
 
	if (isset($child_money))
	{
 ?>
									<p><?= $child_money; ?></p>
<?php 
	} 
?>
									<p style="font-size:12px;line-height:1.2em;">{content}</p>
									<br>

									<table cellpadding="0" cellspacing="0" border="0" width="100%">
										<tr>
											<td valign="middle"><?php if (isset($conclusion)) { echo $conclusion; } else { ?>Sincerely,<br><br>The Dragon Bank Team<br>
											Email: <a href="mailto:support@dragonbank.com">support@dragonbank.com</a><br>
											Web: <a href="www.dragonbank.com">www.dragonbank.com</a><?php } ?></td>
											<td width="130px"><img src="http://dragonbank.com/assets/images/img_mailfooter.png" alt="Dragon Bank" title="Dragon Bank" style="width: 130px; display: block;"></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td><img src="http://dragonbank.com/assets/images/bg_foot_email.png" alt="Dragon Bank" title="Dragon Bank" style="display: block;"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
