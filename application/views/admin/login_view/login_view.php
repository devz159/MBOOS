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
    <div class="alert alert-error fade in">
    <?php echo validation_errors(); ?>
    </div>

<form id="admin_login" action="<?php echo base_url(); ?>admin/login/login_validate" method="POST">
	<div class="well-login">
	
		<div class="control-group">
			<div class="controls">
				<div>
					<input id="admin_email" type="text" placeholder="Email" name="login_username" class="login-input user-name">
				</div>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<div>
				
					<input id="admin_password" type="password" placeholder="Password" name="login_password" class="login-input user-pass">
				</div>
			</div>
		
		</div>
	
		<div class="clearfix">
			<button  id="admin_signin_button" class="btn btn-primary login-btn" title="theme-blue" type="submit">Login</button>
		</div>
		<div class="remember-me">
		 	<a class="rem_me" href = "<?php echo base_url(); ?>admin/login/forgot_password">Forgot Password?</a> 
 			<a class="rem_me" href="<?php echo base_url(); ?>admin/register/register">Sign up</a>
		</div>
	</div>
</form>
</div>