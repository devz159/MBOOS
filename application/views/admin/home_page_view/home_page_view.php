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
<div class="container-fluid">
<div id="main-content">
  <div class="container-fluid">
    <ul class="breadcrumb">
      <li><a href="#">Home</a><span class="divider">&raquo;</span></li>
      <li class="active">Dashboard</li>
    </ul>
    <div class="dashboard-widget">
      <div class="row-fluid">
        <div class="span2">
          <div class="dashboard-wid-wrap">
            <div class="dashboard-wid-content"> <a href="#"> <i class="dashboard-icons computer_imac_blk"></i> <span class="dasboard-icon-title">Dashboard</span> </a> </div>
          </div>
        </div>
        <div class="span2">
          <div class="dashboard-wid-wrap">
            <div class="dashboard-wid-content"> <a href="#"> <i class="dashboard-icons cog_2_blk"></i> <span class="dasboard-icon-title">Settings</span> </a> </div>
          </div>
        </div>
        <div class="span2">
          <div class="dashboard-wid-wrap">
            <div class="dashboard-wid-content"> <a href="#"> <i class="dashboard-icons users_blk"></i> <span class="dasboard-icon-title">Users Lits</span> </a> </div>
          </div>
        </div>
        <div class="span2">
          <div class="dashboard-wid-wrap">
            <div class="dashboard-wid-content"> <a href="#"> <i class="dashboard-icons graph_blk"></i> <span class="dasboard-icon-title">Statistics</span> </a> </div>
          </div>
        </div>
        <div class="span2">
          <div class="dashboard-wid-wrap">
            <div class="dashboard-wid-content"> <a href="#"> <i class="dashboard-icons documents_blk"></i> <span class="dasboard-icon-title">Content</span> </a> </div>
          </div>
        </div>
        <div class="span2">
          <div class="dashboard-wid-wrap">
            <div class="dashboard-wid-content"> <a href="#"> <i class="dashboard-icons help_blk"></i> <span class="dasboard-icon-title">Suport</span> </a> </div>
          </div>
        </div>
      </div>
    </div>
    <div class="dashboard-widget">
      <div class="row-fluid">
        <div class="span2">
          <div class="dashboard-wid-wrap">
            <div class="dashboard-wid-content"> <a href="#"> <i class="dashboard-icons-colors graphic_design_sl"></i> <span class="dasboard-icon-title">Dashboard</span> </a> </div>
          </div>
        </div>
        <div class="span2">
          <div class="dashboard-wid-wrap">
            <div class="dashboard-wid-content"> <a href="#"> <i class="dashboard-icons-colors settings_sl"></i> <span class="dasboard-icon-title">Settings</span> </a> </div>
          </div>
        </div>
        <div class="span2">
          <div class="dashboard-wid-wrap">
            <div class="dashboard-wid-content"> <a href="#"> <i class="dashboard-icons-colors customers_sl"></i> <span class="dasboard-icon-title">Users Lits</span> </a> </div>
          </div>
        </div>
        <div class="span2">
          <div class="dashboard-wid-wrap">
            <div class="dashboard-wid-content"> <a href="#"> <i class="dashboard-icons-colors current_work_sl"></i> <span class="dasboard-icon-title">Statistics</span> </a> </div>
          </div>
        </div>
        <div class="span2">
          <div class="dashboard-wid-wrap">
            <div class="dashboard-wid-content"> <a href="#"> <i class="dashboard-icons-colors archives_sl"></i> <span class="dasboard-icon-title">Content</span> </a> </div>
          </div>
        </div>
        <div class="span2">
          <div class="dashboard-wid-wrap">
            <div class="dashboard-wid-content"> <a href="#"> <i class="dashboard-icons-colors lightbulb_sl"></i> <span class="dasboard-icon-title">Suport</span> </a> </div>
          </div>
        </div>
      </div>
    </div>

</div>
</div>