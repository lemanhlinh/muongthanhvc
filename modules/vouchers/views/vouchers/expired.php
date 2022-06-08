<?php
global $tmpl;
//$tmpl->addStylesheet('plugin/tempusdominus-bootstrap-4.min');
$tmpl->addScript('approve','modules/vouchers/assets/js');
?>
<?php $link_now = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quản lý đề xuất</h1>
            </div><!-- /.col -->
            <div class="col-sm-6 d-none">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard v1</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<section class="content">
    <div class="container-fluid mb-5">
        <div class="bg-white p-4 rounded">
            <div class="mb-4">
                <?php foreach (STATUS_VOUCHER as $k => $item ){ ?>
                    <?php $link = FSRoute::_('index.php?module=vouchers&view=vouchers&task='.$item['function']); ?>
                    <a class="btn <?php echo ($link_now == $link)?'btn-warning text-white':'btn-light'; ?> mr-2" href="<?php echo $link; ?>"><?php echo $item['name']; ?></a>
                <?php } ?>
            </div>
            <table id="list_approve" class="display table table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th class="text-center align-middle" rowspan="2">STT</th>
                    <th class="align-middle" rowspan="2">Tên chiến dịch</th>
                    <th class="text-center align-middle" rowspan="2">Loại Voucher</th>
                    <th class="text-center align-middle" rowspan="2">Giá trị Voucher</th>
                    <th class="text-center align-middle" rowspan="2">Giá trị phát hành</th>
                    <th class="text-center align-middle" colspan="3">Số lượng</th>
                    <th class="text-center align-middle" rowspan="2">Lịch sử</th>
                </tr>
                <tr>
                    <th class="text-center align-middle">Tổng</th>
                    <th class="text-center align-middle">Đã dùng</th>
                    <th class="text-center align-middle">Còn lại</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($list as $k => $item){ ?>
                    <tr>
                        <td class="text-center"><?php echo $k; ?></td>
                        <td><?php echo $item->name_camp; ?></td>
                        <td class="text-center"><?php echo TYPE_VOUCHER[$item->type_voucher]; ?></td>
                        <td class="text-center"><?php echo format_money($item->price_accounting,''); ?></td>
                        <td class="text-center"><?php echo format_money($item->price_voucher,''); ?></td>
                        <td class="text-center"><?php echo $item->number_release; ?></td>
                        <td class="text-center"><?php echo $item->number_release; ?></td>
                        <td class="text-center"><?php echo $item->number_release; ?></td>
                        <td class="text-center"><a href="" class="text-warning">Xem</a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div><!-- /.container-fluid -->
</section>