
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
        <li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo $sessVar['sadmin_uname'];?> <i class="white-icons admin_user"></i><b class="caret"></b></a>
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
  <ul class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>/admin/dashboard">Home</a><span class="divider">&raquo;</span></li>
      <li>Inventory<span class="divider">&raquo;</span></li>
      <li><a href="<?php echo base_url(); ?>/admin/item">Manage Item</a><span class="divider">&raquo;</span></li>
      <?php foreach($item_info as $info):?>
      <li><a href="<?php echo base_url() . 'admin/item/edit_item/' . $info->mboos_product_id; ?>">Edit Item</a><span class="divider">&raquo;</span></li>
      
      <?php endforeach; ?>
       <li class="active">Change Item Image</li>
    </ul>
		<div class="row-fluid">
			<div class="span7">
				<div class="widget-block">
					<div class="widget-head">
						<h5> Item Image </h5>
					</div>
					<div class="widget-content">
						<div class="widget-box">
						
							<form class="form-horizontal well white-box" action="<?php echo base_url(); ?>admin/item/upload_image_validate" method="post" accept-charset="utf-8" enctype="multipart/form-data">
								<fieldset id="add_item_fieldset">
									<p id="add_required_msg">* Required </p>
									<div class="control-group">
										<label class="control-label" for="item_name">Item Name </label>
										<div class="controls">
											<?php foreach($item_info as $info):?>
												<span class="input-xlarge uneditable-input"><?php echo $info->mboos_product_name;  ?></span>
												<input type="hidden" name="item_id" value="<?php echo $info->mboos_product_id; ?>" />		
											<?php endforeach;?>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">File input *</label>
										<div class="controls">
											<input name="item_image" class="input-file" type="file">
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
