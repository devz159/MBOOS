<div id="actionsBox" class="actionsBox">
	<div id="actionsBoxMenu" class="menu">
		<span id="cntBoxMenu">0</span>
		<a class="button box_action">Archive</a>
		<a class="button box_action">Delete</a>
		<a id="toggleBoxMenu" class="open"></a>
		<a id="closeBoxMenu" class="button t_close">X</a>
	</div>
	<div class="submenu">
		<a class="first box_action">Move...</a>
		<a class="box_action">Mark as read</a>
		<a class="box_action">Mark as unread</a>
		<a class="last box_action">Spam</a>
	</div>
</div>
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
    <ul class="breadcrumb">
      <li><a href="#">Home</a><span class="divider">&raquo;</span></li>
       <li class="active">Manage Items</li>
    </ul>
		
		<div class="row-fluid">
			<div class="span12">
				<div class="nonboxy-widget">
					<div class="widget-head">
						<h5>Summary</h5>
					</div>
					<table class="data-tbl-simple table table-bordered">
					<thead>
					<tr>
				    	<th>Item ID</th>
						<th>Image</th>
						<th>Item Name</th>
						<th>Item Description</th>
						<th>Item Supplier</th>		
						<th>Item Category</th>
						<th>Item Price</th>
						<th>Item Availability</th>
						<th>Action</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($products as $list):?>
					<tr>
						<td><?php echo formatedpadding($list->mboos_product_id);?></td>
						<td><img src="<?php echo site_url() . 'uploads/product_images/' . $list->mboos_product_image; ?>" width="50" height="50" /></td>
						<td><?php echo $list->mboos_product_name;?></td>
						<td><?php echo $list->mboos_product_desc;?></td>
						<td><?php echo $list->mboos_product_supplier;?></td>
						<td><?php echo $list->mboos_product_category_name;?></td>
						<td><?php echo $list->mboos_product_price;?></td>
						<td><?php echo $list->mboos_inStocks_quantity; ?></td>
						<td><a href = "<?php echo base_url() . 'admin/stocks/add_stock/' . $list->mboos_product_id; ?> "> Edit Stock |</a><a href = "<?php echo base_url() . 'admin/item/edit_item/' . $list->mboos_product_id; ?> "> Edit |</a><a href = "<?php echo base_url() . 'admin/item/delete_item/' . $list->mboos_product_id; ?> "> Delete </a> </td>
					
					</tr><?php endforeach;?>
					</tbody>
					</table>
				</div>
			
			</div>
</div>	
		
</div>
</div>