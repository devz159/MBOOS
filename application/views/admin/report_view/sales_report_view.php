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
        <li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo $sessVar['sadmin_uname'];?><i class="white-icons admin_user"></i><b class="caret"></b></a>
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
       <li class="active">Sales Report</li>
    </ul>
		
		<div class="row-fluid">
			<div class="span12">
				<div class="nonboxy-widget">
					<div class="widget-head">
						<h5>SUMMARY</h5>
					</div>
					<table class="data-tbl-simple table table-bordered">
					<thead>
					<tr>
				    	<th>Item ID</th>
						<th>Item Name</th>	
						<th>Item Category</th>
						<th>Order Date</th>
						<th>Sales</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($sales as $list):?>
					<tr>
						<td><?php echo formatedpadding($list->mboos_product_id);?></td>
						<td><?php echo $list->mboos_product_name;?></td>
						<td><?php echo $list->mboos_product_category_name;?></td>
						<td><?php echo getDateArr($list->mboos_order_date);?></td>
						<td><?php echo $list->mboos_orders_total_price;?></td>
					</tr><?php endforeach;?>
					</tbody>
					</table>
				</div>
			
			</div>
</div>	
		
</div>
</div>