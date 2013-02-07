<div class="navbar navbar-fixed-top">
  <div class="navbar-inner top-nav">
    <div class="container-fluid">
      <div class="branding">
        <div class="logo"> <a href="<?php echo base_url(); ?>admin/dashboard"><img src="<?php echo base_url(); ?>template/img/logo.png" width="168" height="40" alt="Logo"></a> </div>
      </div>
      <ul class="nav pull-right">
        <li class="dropdown search-responsive"><a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="nav-icon magnifying_glass"></i><b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li class="top-search">
              <form action="#" method="get">
                <div class="input-prepend"> <span class="add-on"><i class="icon-search"></i></span>
                  <input type="text" id="searchIcon">
                </div>
              </form>
            </li>
          </ul>
        </li>
        <li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo $sessVar['sadmin_uname'];?> <span class="alert-noty">25</span><i class="white-icons admin_user"></i><b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url();?>admin/profile_mboos/edit_profile/<?php echo $sessVar['sadmin_uid'] ?>"><i class="icon-pencil"></i> Edit Profile</a></li>
            <li><a href="#"><i class="icon-cog"></i> Account Settings</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url();?>admin/login/logout"><i class="icon-off"></i><strong> Logout</strong></a></li>
          </ul>
        </li>
      </ul>
      <button data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar" type="button"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>

    </div>
  </div>
</div>
<div id="main-content">
<div class="container-fluid">
		<div class="row-fluid">
			<div class="span7">
				<div class="widget-block">
					<div class="widget-head">
						<h5> Add Stock </h5>
					</div>
					<div class="widget-content">
						<div class="widget-box">
						<div id="register_msg_error">
							<?php  echo validation_errors();  ?>
						</div>
						
							<form class="form-horizontal well white-box" action="<?php echo base_url(); ?>admin/stocks/add_stock_validate" method="post" accept-charset="utf-8" enctype="multipart/form-data">
								<fieldset id="add_item_fieldset">
									<p id="add_required_msg">* Required </p>
									
									<div class="control-group">
										<label class="control-label">Item Name</label>
										<div class="controls">
											<?php foreach ($stock_number as $list):?>
											<input type="hidden" name="item_id" value="<?php echo $list->mboos_product_id; ?>"/>
											<span class="input-xlarge uneditable-input"><?php echo $list->mboos_product_name; ?></span>
											<?php endforeach; ?>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="quantity_number">Item Quantity *</label>
										<div class="controls">
											<input type="text" class="input-xlarge text-tip" name="quantity_number" title="Item Quantity" value="<?php echo set_value('quantity_number'); ?>" />
										</div>
									</div>
								
									<div class="clearfix">
										<button  id="add_button" class="btn btn-primary login-btn" title="theme-blue" type="submit">Add</button>
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
