<?php
global $config, $tmpl, $module;
$Itemid = FSInput::get('Itemid');
$logo = URL_ROOT . $config['logo'];
$tmpl->addStylesheet('plugin/all.min');
$tmpl->addStylesheet('plugin/adminlte.min');
$tmpl->addStylesheet('style');
$tmpl->addStylesheet('login');
$tmpl->addScript('plugin/adminlte.min');
$tmpl->addScript('main');
?>
<div class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?php echo URL_ROOT; ?>"><img src="<?php echo URL_ROOT.'images/logo_muongthanh.png' ?>" alt=""></a>
            <div class="title-voucher">Hệ thống quản lý Voucher</div>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <form action="<?php echo FSRoute::_("index.php?module=users") ?>" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="_log_username" id="_log_username" placeholder="Tên đăng nhập" required>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="_log_password" id="_log_password" placeholder="Mật khẩu" required>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-login btn-block">Đăng Nhập</button>
                        </div>
                    </div>
                    <input type="hidden" name = "module" value = "users" />
                    <input type="hidden" name = "view" value = "users" />
                    <input type="hidden" name = "task" value = "login_save" />
                </form>
            </div>

        </div>
    </div>
</div>
<?php // echo $main_content; ?>