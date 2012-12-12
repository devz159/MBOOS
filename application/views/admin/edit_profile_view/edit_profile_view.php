<div name="edit_profile">
<form action="<?php echo base_url(); ?>admin/profile_mboos/edit_validate" method="POST">
<h3>Edit Profile</h3>

<?php 
	foreach ($user_info as $rec) {
		$uemail = $rec->mboos_user_email;
		$uusername = $rec->mboos_user_username;
		$uid = $rec->mboos_user_id;
		} 
?>

<p><label>User E-mail</label><input name='user_email' type='text' value="<?php echo $uemail ?>" /></p>
<p><label>Username</label><input name='user_username' type='text' value="<?php echo $uusername ?>"  /></p>
<p><input name='user_id' type='hidden' value="<?php echo $uid ?>"  /></p>
<p><input name='submit' type='submit' value="Save"  /></p>
</form>
</div>
<div name="back_profile">
<form action="<?php echo base_url();?>admin/profile_mboos/back_profile" method"POST">
<p><input name='name' type='submit' value="Back" /></p>
</form>
</div>