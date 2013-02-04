<div class="navbar navbar-fixed-top" class="theme-color theme-blue" title="theme-blue">
	<div class="navbar-inner">
		<div class="container-fluid">
			<div class="branding">
				<div class="logo">
					<a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>template/img/logo.png" width="168" height="40" alt="Logo"></a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="login-container">
<form method="POST" action="<?php echo base_url(); ?>admin/login/forgotpass_email_validate">
	<div class="well-login forgot-pass">
		<h3>Having trouble signing in?</h3>
		<p>
			Please enter email address. You will receive a link to create a new password via email.
		</p>
		<div class="control-group">
			<div class="controls">
				<div>
					<input type="text" placeholder="Email" name="email" class="login-input user-name">
				</div>
			</div>
		</div>
		<div class="clearfix">
			<button class="btn btn-primary login-btn" type="submit">Send Password</button>
		</div>
	</div>
</form>
</div>