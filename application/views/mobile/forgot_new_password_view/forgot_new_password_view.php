<div id="emailSendPage" data-role="page">

	<div data-role="header" data-position="fixed" data-theme="b">
			<h1>Reset Password</h1>
	</div><!-- /header -->

	<div data-role="content">	
	<div class="msgBoxForgotPword">	
		<p>New Password</p>
	</div>
	<?php  echo validation_errors();  ?>
		<form class="password_validate" method="POST" action="<?php echo base_url(); ?>mobile_ajax/login/reset_password_validate">
			<input type="hidden" name="email" value="<?php echo $this->uri->segment(4); ?>"/>
			<p><label>New password: </label><input class="new_password" type="password" name="new_password" value=""/></p>
			<p><label>Retype password: </label><input class="confirm_password" type="password" name="confirm_password" value=""></p>
			<p><input class="resetBtn" type="submit" value="submit"></p>
		</form>
	</div>
	
	
	<div data-role="footer" data-id="foo1" data-position="fixed" data-theme="b">
	
	</div><!-- /footer -->	
</div><!-- /page -->
