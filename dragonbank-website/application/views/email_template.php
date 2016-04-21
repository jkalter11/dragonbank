<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Dragon Bank</title>
    <style type="text/css">
body {font-family: helvetica, sans-serif;}
.mail-container {width: 600px;margin: 20px auto 0;background: url(https://i9.createsend1.com/ei/d/87/93A/385/093039/images/mail-gradient-bottom.png) repeat-x left bottom;}
.mail-header {padding-bottom: 9px;}
.mail-content {background: #fff;position: relative;}
.mail-text {padding: 70px 80px;color: #666666;background: url(https://i10.createsend1.com/ei/d/87/93A/385/093039/images/mail-gradient-top.png) repeat-x 0 0;}
.mail-text p{font-size: 12px;margin-bottom: 5px;line-height: 1.6em;}
.mail-text h3 {font-size: 12px; margin: 0 0 5px;}
.row {margin: 10px 0;}
.row p {line-height: 1em;}
.mail-pic {margin: 3px 6px;}
p.mail-contact {padding-left: 80px;font-size: 12px!important;}
.mail-copy {padding: 0 0 10px 26px;font-size: 12px;color: #666;}
</style>
  <meta name="robots" content="noindex,nofollow">
<meta property="og:title" content="dragonbank">
</head>
  <body style="font-family:Calibri, sans-serif;">
  
  <div class="container">
  
  <table cellpadding="0" cellspacing="0" class="mail-container" style="font-size:12px;font-family:Calibri;width:600px;margin-top:20px;margin-bottom:0;margin-right:auto;margin-left:auto;background-color:transparent;background-image:url(https://i9.createsend1.com/ei/d/87/93A/385/093039/images/mail-gradient-bottom.png);background-repeat:repeat-x;background-position:left bottom;background-attachment:scroll;">
  	<tbody>
    <tr>
        <td colspan="2" class="mail-header" style="padding-bottom:9px;"><img src="https://i4.createsend1.com/ei/d/87/93A/385/093039/images/mail-header.png" alt="mail-header" width="600" height="87">
        </td>
    </tr>
  	<tr>
        <td>
            <p style="font-size:12px;">
                <?php if( isset( $name ) ): ?>
			        <?=$name?>
		        <?php endif; ?>
            </p>
            <?php if( isset( $intro ) && strlen( $intro ) > 0 ):  ?>
                <p style="font-size:12px;margin-bottom:5px;line-height:1.6em;">test<?=$intro?></p>
            <?php endif; ?>
        </td>
    </tr>
    <?php /*$child money creates its own <tr><td> tags*/ ?>
    <?php if( isset( $child_money ) ): ?>
        <?=$child_money?>
    <?php endif; ?>
  	<tr>
        <td colspan="2">
            <p style="font-size:12px;line-height:1.2em;">{content}</p>
        </td>
    </tr>
    <tr>
        <td>
            <span style="font-size:12px;line-height:1.2em;">Sincerely,</span>
            <br /><br />
            <p style="font-size:12px;margin-bottom:5px;">The Dragon Bank Support Team <br/>
                Email: <a href="mailto:support@dragonbank.com">support@dragonbank.com</a><br />
                Web: <a href="www.dragonbank.com ">www.dragonbank.com </a>
            </p>
        </td>
        <td>
            <br />
            <img src="https://i6.createsend1.com/ei/d/87/93A/385/093039/images/dargon-mail.png" alt="dargon-mail" width="202" height="170">
        </td>
    </tr>
  	<tr>
		<td style="font-size:12px;color:#666;position: relative; top: 0;">www.DragonBank.com   |   ©&nbsp;2013 EnRICHed Academy
        </td>
	</tr>
  </tbody>
  </table>
  
  </div>

</body></html>