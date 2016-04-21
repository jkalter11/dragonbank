<div class="page-header">
  <h1>System Settings <small>manage the system</small></h1>
</div>
<h3>General Settings</h3>
<form class="form-horizontal" role="form" method="POST" id="settings-edit" name="settings">
  <div class="form-group">
    <label for="state" class="col-sm-3 control-label">Site State</label>
    <div class="col-sm-9">
      <select class="form-control" name="set_info[site_status]">
    	<option <?php if( $sta == 1 ): echo "selected='selected'"; endif; ?> value=1>Production</option>
		<option <?php if( $sta == 2 ): echo "selected='selected'"; endif; ?> value=2>Development</option>
		<option <?php if( $sta == 0 ): echo "selected='selected'"; endif; ?> value=0>Maintenance</option>
	  </select>
    </div>
  </div>
  <div class="form-group">
    <label for="devemail" class="col-sm-3 control-label">Development Email</label>
    <div class="col-sm-9">
      <input type="email" class="form-control" name="set_info[dev_email]" value="<?= $dev; ?>" id="devemail" placeholder="Development Email">
    </div>
  </div>
  <div class="form-group">
    <label for="prodemail" class="col-sm-3 control-label">Production Site Email</label>
    <div class="col-sm-9">
      <input type="email" class="form-control" name="set_info[pro_email]" value="<?= $pro; ?>" id="prodemail" placeholder="Production Site Email">
      <p class="help-block">Where order emails are sent</p>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Update</button>
    </div>
  </div>
  <input type="hidden" name="set_info[settings_id]" value=1 >
</form>

<h3>Admin Password</h3>
<form class="form-horizontal" role="form" method="POST" id="user-edit" name="admin">
  <div class="form-group">
    <label for="password" class="col-sm-3 control-label">New Admin Password</label>
    <div class="col-sm-9">
      <input type="password" class="form-control" name="user_info[password]" id="password" placeholder="New Admin Password">
    </div>
  </div>
  <div class="form-group">
    <label for="check-password" class="col-sm-3 control-label">Verify Password</label>
    <div class="col-sm-9">
      <input type="password" class="form-control" name="user_info[check-password]" id="check-password" placeholder="Verify Password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Update</button>
    </div>
  </div>
  <input type="hidden" name="admin" value=1>
</form>