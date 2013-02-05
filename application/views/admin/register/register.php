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
<div id="reg_main-content">
<div class="container-fluid">
		<div class="row-fluid">
			<div class="span7">
				<div class="widget-block">
					<div class="widget-head">
						<h5> Registration </h5>
					</div>
					<div class="widget-content">
						<div class="widget-box">
						<div id="register_msg_error">
							<?php  echo validation_errors();  ?>
						</div>
						
							<form class="form-horizontal well white-box" id="admin_login_validation" action="<?php echo base_url(); ?>admin/register" method="POST">
								<fieldset id="registration_fieldset">
									<p id="reg_required_msg">* Required </p>
									<div class="control-group">
										<label class="control-label" for="register_username">Username *</label>
										<div class="controls">
											<input type="text" class="input-xlarge text-tip" id="register_username" name="register_username" title="first tooltip">
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="register_password">Password *</label>
										<div class="controls">
											<input type="password" class="input-xlarge" name="register_password" id="register_password"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="register_confirm">Confirm Password *</label>
										<div class="controls">
											<input type="password" class="input-xlarge" name="register_confirm" id="register_confirm"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="register_email">Email Address *</label>
										<div class="controls">
											<input type="text" class="input-xlarge" name="register_email" id="register_email"/>
										</div>
									</div>
								<div class="control-group">
										<label class="control-label">Secret Quesstion *</label>
										<div class="controls">
											<select>
												<option value="empty"> Please Select</option>
												<option value="What is your oldest cousin's first and last name?">What is your oldest cousin's first and last name?</option>
												<option value="What is the name of your favorite childhood friend? ">What is the name of your favorite childhood friend? </option>
												<option value="What street did you live on in third grade?">What street did you live on in third grade?</option>
												<option value="What is your oldest sibling's birthday month and year?">What is your oldest sibling's birthday month and year?</option>
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="register_answer">Answer *</label>
										<div class="controls">
											<input type="text" class="input-xlarge" name="register_answer" id="register_answer"/>
										</div>
									</div>
									<div class="clearfix">
										<button  id="reg_button" class="btn btn-primary login-btn" title="theme-blue" type="submit">Login</button>
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>