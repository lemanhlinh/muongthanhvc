<?php
/*
 * Huy write
 */

// controller
class VouchersControllersVouchers extends FSControllers
{
    var $module;
    var $view;

    function display()
    {
        $fssecurity  = FSFactory::getClass('fssecurity');
        $fssecurity -> checkLogin();
        // call models
        $model = $this->model;
        // call views
        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';

    }

//		tao voucher
    function create()
    {
        $model = $this->model;
        $list_sample_pdf  = $model->getListSampleVoucher();
        include 'modules/' . $this->module . '/views/' . $this->view . '/form.php';
    }

//		luu voucher
    function save_voucher()
    {
        $model = $this->model;
        $id = $model->save_voucher();
        if ($id){
            $link = FSRoute::_('index.php?module=vouchers&view=vouchers&task=create');
            $msg = FSText :: _("Bạn đã tạo thành công đề xuất voucher");
            setRedirect($link,$msg,'suc');
        }else{
            $link = FSRoute::_('index.php?module=vouchers&view=vouchers&task=create');
            $msg = FSText :: _("Đã có lỗi, chưa tạo được voucher");
            setRedirect($link,$msg,'error');
        }
    }

//    xem chi tiet
    function detail(){

    }

//		da duyet
    function approve()
    {
        $model = $this->model;
        $list  = $model->getListVoucher();
        include 'modules/' . $this->module . '/views/' . $this->view . '/approve.php';
    }

    //		cho phe duyet
    function approve_waiting()
    {
        $model = $this->model;
        $status = 1;
        $list  = $model->getListVoucher($status);
        include 'modules/' . $this->module . '/views/' . $this->view . '/approve_waiting.php';
    }

//		hết hạn
    function expired()
    {
        $model = $this->model;
        $model = $this->model;
        $list  = $model->getListVoucher();
        include 'modules/' . $this->module . '/views/' . $this->view . '/expired.php';
    }

    //		trả về
    function return_voucher()
    {
        $model = $this->model;
        $model = $this->model;
        $list  = $model->getListVoucher();
        include 'modules/' . $this->module . '/views/' . $this->view . '/return_voucher.php';
    }

    //		khong duyet
    function no_approve()
    {
        $model = $this->model;
        $list  = $model->getListVoucher();
        include 'modules/' . $this->module . '/views/' . $this->view . '/no_approve.php';
    }

    function load_sample_voucher(){
        $model = $this->model;
        $type_voucher = FSInput::get('type_voucher');
        $list_sample_pdf  = $model->getListSampleVoucher($type_voucher);
        $data = array(
            'error' => true,
            'message' => '',
            'html' => ''
        );
        $html = '';
        if (!empty($list_sample_pdf)){
            foreach ($list_sample_pdf as $k => $item){
                $html .= '<div class="col-sm-3">';
                    $html .= '<div class="custom-control custom-radio">';
                        $html .= '<input class="custom-control-input custom-control-input-warning" type="radio" id="sample_pdf_id'.$k.'" value="'.$item->id.'" name="sample_pdf_id" '.(($k == 0)?'checked':'').'>';
                        $html .= '<label for="sample_pdf_id'.$k.'" class="custom-control-label">'.$item->name.'</label>';
                        $html .= '<img src="'.URL_ROOT.str_replace('original','resized',$item->image).'" class="img-fluid">';
                    $html .= '</div>';
                $html .= '</div>';
            }
        }
        $data['html'] = $html;
        $data['error'] = false;
        echo json_encode($data);
    }
}

?>
