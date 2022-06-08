<?php $link_now = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
    <li class="nav-item">
        <a href="<?php echo URL_ROOT; ?>" class="nav-link <?php echo ($link_now == URL_ROOT)?'active':''; ?>">
            <img src="<?php echo URL_ROOT.'images/icon/icon_menu_16.svg' ?>" alt="">
            <p class="ml-2">
                Dashboard
            </p>
        </a>
    </li>
    <?php if ($_COOKIE['group_company'] == 1){ ?>
        <?php if ($_COOKIE['position_group'] == 3 || $_COOKIE['position_group'] == 4 || $_COOKIE['position_group'] == 5){ ?>
            <?php $link_create = FSRoute::_('index.php?module=vouchers&view=vouchers&task=create'); ?>
            <li class="nav-item">
                <a href="<?php echo $link_create; ?>" class="nav-link <?php echo ($link_now == $link_create)?'active':''; ?>">
                    <img src="<?php echo URL_ROOT.'images/icon/icon_menu_16-1.svg' ?>" alt="">
                    <p class="ml-2">
                        Đề xuất phát hành
                    </p>
                </a>
            </li>
        <?php } ?>
        <?php if ($_COOKIE['position_group'] == 3 || $_COOKIE['position_group'] == 4 || $_COOKIE['position_group'] == 5){ ?>
            <?php $link_approve_waiting = FSRoute::_('index.php?module=vouchers&view=vouchers&task=approve_waiting'); ?>
            <li class="nav-item">
                <a href="<?php echo $link_approve_waiting; ?>" class="nav-link <?php echo ($link_now == $link_approve_waiting)?'active':''; ?>">
                    <img src="<?php echo URL_ROOT.'images/icon/icon_menu_16-2.svg' ?>" alt="">
                    <p class="ml-2">
                        Quản lý đề xuất
                    </p>
                </a>
            </li>
        <?php } ?>
        <?php if($_COOKIE['position_group'] == 2 || $_COOKIE['position_group'] == 3 || $_COOKIE['position_group'] == 4){ ?>
            <li class="nav-item">
                <a href="pages/widgets.html" class="nav-link">
                    <img src="<?php echo URL_ROOT.'images/icon/icon_menu_16-3.svg' ?>" alt="">
                    <p class="ml-2">
                        Phê duyệt Voucher
                    </p>
                </a>
            </li>
        <?php } ?>
        <?php if($_COOKIE['position_group'] == 1 || $_COOKIE['position_group'] == 4){ ?>
            <li class="nav-item">
                <a href="pages/widgets.html" class="nav-link">
                    <img src="<?php echo URL_ROOT.'images/icon/icon_menu_16-4.svg' ?>" alt="">
                    <p class="ml-2">
                        Phát hành voucher
                    </p>
                </a>
            </li>
        <?php } ?>
    <?php }else if ($_COOKIE['group_company'] == 2){ ?>
        <?php if ($_COOKIE['position_group'] == 4){ ?>
            <li class="nav-item">
                <a href="pages/widgets.html" class="nav-link">
                    <img src="<?php echo URL_ROOT.'images/icon/icon_menu_16-1.svg' ?>" alt="">
                    <p class="ml-2">
                        Đề xuất phát hành
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="pages/widgets.html" class="nav-link">
                    <img src="<?php echo URL_ROOT.'images/icon/icon_menu_16-2.svg' ?>" alt="">
                    <p class="ml-2">
                        Quản lý đề xuất
                    </p>
                </a>
            </li>
        <?php } ?>
        <?php if ($_COOKIE['position_group'] == 2 || $_COOKIE['position_group'] == 3){ ?>
            <li class="nav-item">
                <a href="pages/widgets.html" class="nav-link">
                    <img src="<?php echo URL_ROOT.'images/icon/icon_menu_16-3.svg' ?>" alt="">
                    <p class="ml-2">
                        Phê duyệt Voucher
                    </p>
                </a>
            </li>
        <?php } ?>
        <?php if ($_COOKIE['position_group'] == 1 || $_COOKIE['position_group'] == 4){ ?>
            <li class="nav-item">
                <a href="pages/widgets.html" class="nav-link">
                    <img src="<?php echo URL_ROOT.'images/icon/icon_menu_16-4.svg' ?>" alt="">
                    <p class="ml-2">
                        Phát hành voucher
                    </p>
                </a>
            </li>
        <?php } ?>
    <?php } ?>
    <li class="nav-item">
        <?php $link_status = FSRoute::_('index.php?module=vouchers&view=vouchers'); ?>
        <a href="<?php echo $link_status; ?>" class="nav-link <?php echo ($link_now == $link_status)?'active':''; ?>">
            <img src="<?php echo URL_ROOT.'images/icon/icon_menu_16-5.svg' ?>" alt="">
            <p class="ml-2">
                Thông báo
            </p>
        </a>
    </li>
</ul>