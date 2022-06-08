<?php
global $tmpl;
$tmpl->addStylesheet('plugin/tempusdominus-bootstrap-4.min');
$tmpl->addStylesheet('plugin/icheck-bootstrap.min');
$tmpl->addStylesheet('plugin/select2.min');
$tmpl->addScript('plugin/moment.min');
$tmpl->addScript('plugin/tempusdominus-bootstrap-4.min');
$tmpl->addScript('plugin/select2.full.min');
$tmpl->addScript('form','modules/vouchers/assets/js');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Đề xuất phát hành voucher</h1>
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
<div class="aaa"></div>
<section class="content">
    <!-- general form elements -->
    <div class="card card-primary">
        <!-- form start -->
        <form action="<?php echo FSRoute::_("index.php?module=vouchers&view=vouchers&task=save_voucher") ?>" method="post" name="create_voucher" id="create_form">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-2">
                        <b>Loại voucher:</b>
                    </div>
                    <div class="col-sm-10">
                        <div class="row">
                            <?php foreach (TYPE_VOUCHER as $k => $item){ ?>
                                <div class="col-sm-3">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input custom-control-input-warning" type="radio" value="<?php echo $k; ?>" id="type_voucher<?php echo $k; ?>" name="type_voucher" <?php echo ($k == 1)?'checked':'';?>>
                                        <label for="type_voucher<?php echo $k; ?>" class="custom-control-label"><?php echo $item; ?></label>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="content">
                    <h3>Nội dung thông tin hiển thị lên Voucher</h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Ngày phát hành:</label>
                                <div class="col-sm-10">
                                    <div class="input-group date" id="date_release" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" name="date_release" data-target="#date_release" required>
                                        <div class="input-group-append" data-target="#date_release" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Thông tin khách hàng:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name_customer" id="name_customer" placeholder="Họ và tên khách hàng" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Giá trị quà tặng:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="gift" id="gift" placeholder="Một đêm hạng phòng Deluxe dành cho tối đa 2 người lớn và..." required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Dịch vụ bao gồm:</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group clearfix">
                                                <div class="icheck-warning d-inline">
                                                    <input type="checkbox" id="type_service1" value="1" name="type_service[]" checked>
                                                    <label for="type_service1">
                                                        Ăn sáng
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group clearfix">
                                                <div class="icheck-warning d-inline">
                                                    <input type="checkbox" id="type_service2" value="2" name="type_service[]">
                                                    <label for="type_service2">
                                                        Dịch vụ khác
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="service_other" id="service_other" placeholder="Vui lòng điền dịch vụ khác" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tên Voucher:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Phiếu sử dụng dịch vụ phòng nghỉ" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Công ty:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name_company" class="form-control" id="name_company" placeholder="CÔNG TY CỔ PHẦN DU LỊCH VIETBOOKING" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Thời gian áp dụng:</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="input-group date col-sm-6" id="time_start" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" data-target="#time_start" name="time_start" id="time_start" placeholder="Từ ngày" required>
                                            <div class="input-group-append" data-target="#time_start" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        <div class="input-group date col-sm-6" id="time_end" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" data-target="#time_end" name="time_end" id="time_end" placeholder="Đến ngày" required>
                                            <div class="input-group-append" data-target="#time_end" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Áp dụng tại:</label>
                                <div class="col-sm-10">
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input custom-control-input-warning" type="radio" id="hotels_all" name="hotels_all" checked="">
                                                <label for="hotels_all" class="custom-control-label">Tất cả khách sạn </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input custom-control-input-warning" type="radio" id="hotels_choose" name="hotels_all">
                                                <label for="hotels_choose" class="custom-control-label">Chọn khách sạn</label>
                                            </div>
                                        </div>
                                    </div>
                                    <select class="select2" name="hotels_id[]" id="hotels_id" multiple="multiple" data-placeholder="Chọn khách sạn áp dụng" style="width: 100%;">
                                        <option value="1">Alabama</option>
                                        <option value="2">Alaska</option>
                                        <option value="3">California</option>
                                        <option value="4">Delaware</option>
                                        <option value="5">Tennessee</option>
                                        <option value="6">Texas</option>
                                        <option value="7">Washington</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="content">
                    <h3>Nội dung thông tin nội bộ và không hiển thị lên Voucher</h3>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tên Chiến dịch:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name_camp" name="name_camp" placeholder="Vui lòng nhập tên chiến dịch" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Giá trị hạch toán:</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="price_accounting" name="price_accounting" placeholder="2.000.000" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">VND</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Số lượng / Hình thức phát hành:</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <?php foreach (RELEASE_FORM as $k => $item){ ?>
                                        <div class="col-sm-4">
                                            <div class="form-group clearfix">
                                                <div class="icheck-warning d-inline">
                                                    <input type="radio" id="release_form<?php echo $k; ?>" value="<?php echo $k; ?>" name="release_form" <?php echo $k==1?'checked':''; ?>>
                                                    <label for="release_form<?php echo $k; ?>">
                                                        <?php echo $item; ?>
                                                    </label>
                                                </div>
                                                <input type="number" class="form-control mt-3" id="number_release<?php echo $k; ?>" name="number_release" placeholder="Số lượng" disabled>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Giá trị Voucher:</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="price_voucher" name="price_voucher" placeholder="2.000.000">
                                        <div class="input-group-append">
                                            <span class="input-group-text">VND</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Mục đích/ Lý do đề xuất phát hành Voucher:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="purpose" name="purpose" rows="3" placeholder="Vui lòng nhập mục đích/ Lí do đề xuất phát hành Voucher"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="content">
                    <h3>điều kiện áp dụng</h3>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">
                            Tiếng Việt
                            <span>
                                (Bạn có thể chỉnh sửa dựa trên những điệu kiện có sẵn cho đúng yêu cầu của voucher)
                            </span>
                        </label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="12" name="content_vi" id="content_vi" placeholder="Nhập nội dung ..."></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">
                            Tiếng Anh
                            <span>
                                (Bạn có thể chỉnh sửa dựa trên những điệu kiện có sẵn cho đúng yêu cầu của voucher)
                            </span>
                        </label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="12" name="content_en" id="content_en" placeholder="Nhập nội dung ..."></textarea>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="content">
                    <h3>Mẫu voucher</h3>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input custom-control-input-warning" type="radio" id="sample_pdf_id1" name="sample_pdf_id" checked>
                                <label for="sample_pdf_id1" class="custom-control-label">Mẫu voucher số 1</label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input custom-control-input-warning" type="radio" id="sample_pdf_id2" name="sample_pdf_id" >
                                <label for="sample_pdf_id2" class="custom-control-label">Mẫu voucher số 2</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer text-center">
                <button type="submit" class="btn btn-warning text-light" id="submitbt">Gửi đề xuất</button>
            </div>
            <input type="hidden" name = "module" value = "vouchers" />
            <input type="hidden" name = "view" value = "vouchers" />
            <input type="hidden" name = "task" value = "save_voucher" />
        </form>
    </div>
    <!-- /.card -->
</section>