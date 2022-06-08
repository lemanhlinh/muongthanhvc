<?php
global $tmpl;
//$tmpl->addStylesheet('plugin/tempusdominus-bootstrap-4.min');
$tmpl->addScript('default','modules/vouchers/assets/js');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Thông báo</h1>
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
            <table id="list_approve" class="display table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">STT</th>
                        <th>Thông báo</th>
                        <th class="text-center">Thời gian</th>
                        <th class="text-center">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td>Đề xuất phát hành - Voucher có mệnh giá - “Đại hội Mường Thanh năm 2022”</td>
                        <td class="text-center">10/05/2022 - 10:29:32</td>
                        <td class="text-center">Đề xuất</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div><!-- /.container-fluid -->
</section>