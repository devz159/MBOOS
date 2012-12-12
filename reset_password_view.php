<p>Enter new password</p>

<form method="POST" action="<?php echo base_url(); ?>admin/login/reset_password_validate">
<p><label>New password: </label><input type="password" name="admin_password1" /></p>
<p><label>Retype password: </label><input type="password" name="admin_password2" /></p>
<p><input type="submit" value="submit"></p>
</form>