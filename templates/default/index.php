<?php
global $config, $tmpl, $module;
$Itemid = FSInput::get('Itemid');
$logo = URL_ROOT . $config['logo'];
$tmpl->addStylesheet('plugin/all.min');
//$tmpl->addStylesheet('plugin/tempusdominus-bootstrap-4.min');
//$tmpl->addStylesheet('plugin/icheck-bootstrap.min');
$tmpl->addStylesheet('plugin/adminlte.min');
$tmpl->addStylesheet('plugin/datatables.min');
//$tmpl->addStylesheet('plugin/dataTables.bootstrap4.min');
//$tmpl->addStylesheet('plugin/OverlayScrollbars.min');
//$tmpl->addStylesheet('plugin/daterangepicker');
//$tmpl->addStylesheet('plugin/summernote-bs4.min');
$tmpl->addStylesheet('style');
//$tmpl->addScript('plugin/Chart.min');
//$tmpl->addScript('plugin/sparkline');
//$tmpl->addScript('plugin/jquery.vmap.min');
//$tmpl->addScript('plugin/jquery.vmap.usa');
//$tmpl->addScript('plugin/jquery.knob.min');
//$tmpl->addScript('plugin/moment.min');
//$tmpl->addScript('plugin/daterangepicker');
//$tmpl->addScript('plugin/tempusdominus-bootstrap-4.min');
//$tmpl->addScript('plugin/summernote-bs4.min');
//$tmpl->addScript('plugin/jquery.overlayScrollbars.min');
$tmpl->addScript('plugin/adminlte.min');
//$tmpl->addScript('plugin/demo');
//$tmpl->addScript('plugin/dashboard');
$tmpl->addScript('main');
?>
<div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="<?php echo URL_ROOT ?>images/logo-head.png" alt="Mường Thanh Voucher" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light justify-content-md-between">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-align-left"></i></a>
            </li>
        </ul>
        <div class="title-group-company">
            <?php echo GROUP_COMPANY[$_COOKIE['group_company']]; ?> /
            <?php
                if ($_COOKIE['group_company'] == 1){
                    echo POSITION_GROUP_1[$_COOKIE['position_group']];
                }else if ($_COOKIE['group_company'] == 2){
                    echo POSITION_GROUP_2[$_COOKIE['position_group']];
                }
            ?>
        </div>

        <!-- Right navbar links -->
        <ul class="navbar-nav">
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link rounded dropdown-toggle" href="#" id="navbarVersionDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $_COOKIE['username']; ?>
                </a>
                <div class="dropdown-menu py-0" aria-labelledby="navbarVersionDropdown">
                    <a class="dropdown-item bg-info disabled" href="#"><?php echo $_COOKIE['username']; ?></a>
                    <a class="dropdown-item" href="<?php echo FSRoute::_('index.php?module=users&view=users&task=logout'); ?>">Thoát</a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="" class="brand-link border-0">
            <img src="<?php echo URL_ROOT ?>images/logo-head.png" alt="Mường Thanh Voucher" class="img-responsive d-block" style="opacity: .8">
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group d-none" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <?php include 'navbar.php'; ?>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <?php echo $main_content; ?>
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2014-2021 <a href="https://finalstyle.com">Finalstyle.com</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.2.0
        </div>
    </footer>
</div>
<!-- ./wrapper -->