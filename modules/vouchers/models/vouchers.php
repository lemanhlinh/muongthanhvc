<?php 
	class VouchersModelsVouchers extends FSModels
	{
		function __construct()
		{
		}

		function save_voucher(){
		    $row = array();
            // SAVE HISTORY
            $time = date("Y-m-d H:i:s");
            $row['date_release'] = format_date2(FSInput::get('date_release'));
            $row['type_voucher'] = FSInput::get('type_voucher');
            $row['name_customer'] = FSInput::get('name_customer');
            $row['gift'] = FSInput::get('gift');
            $row['time_start'] = format_date2(FSInput::get('time_start'));
            $row['time_end'] = format_date2(FSInput::get('time_end'));

            $type_service = FSInput::get('type_service',null,'array');
            $type_service = implode(',',$type_service);
            $row['type_service'] = $type_service;
            $row['service_other'] = FSInput::get('service_other');
            $row['name'] = FSInput::get('name');
            $row['name_company'] = FSInput::get('name_company');
            //
//            $row['hotels_all'] = FSInput::get('hotels_all');
            $hotels_id = FSInput::get('hotels_id',null,'array');
            $hotels_id = implode(',',$hotels_id);
            $row['hotels_id'] = $hotels_id;
            //
            $row['name_camp'] = FSInput::get('name_camp');
            $row['price_accounting'] = FSInput::get('price_accounting');

            $release_form = FSInput::get('release_form',null,'array');
            $release_form = implode(',',$release_form);
            $row['release_form'] = $release_form;

            $row['price_voucher'] = FSInput::get('price_voucher');
            $row['purpose'] = FSInput::get('purpose');
            $row['content_vi'] = FSInput::get('content_vi');
            $row['content_en'] = FSInput::get('content_en');
            $row['sample_pdf_id'] = FSInput::get('sample_pdf_id');
            $row['group_company_id'] = $_COOKIE['group_company'];
            $row['position_group_id'] = $_COOKIE['position_group'];
            $row['sample_pdf_id'] = FSInput::get('sample_pdf_id');
            $row['created_time'] = $time;
            $row['edited_time'] = $time;
            $id = $this -> _add($row, 'fs_vouchers');
            if(!$id)
                return false;
            return $id;
        }

        function getListVoucher($status = 1)
        {
            $fs_table = FSFactory::getClass('fstable');
            $where = '';
            $where .= " AND group_company_id = '".$_COOKIE['group_company']."' ";
            $where .= " AND position_group_id = '".$_COOKIE['position_group']."' ";
            $query = " SELECT id,name_camp,number_release,type_voucher,price_accounting,price_voucher,created_time
						FROM ".$fs_table -> getTable('fs_vouchers')." 
						WHERE id != 0 ".$where." ORDER BY id DESC";
            global $db;
            $sql = $db->query($query);
            $result = $db->getObjectList();
            return $result;
        }

        function getListSampleVoucher($type_voucher = 1)
        {
            $fs_table = FSFactory::getClass('fstable');
            $where = '';
            $query = " SELECT id,name,file,image,type_voucher_id
						FROM ".$fs_table -> getTable('fs_sample_pdf')." 
						WHERE type_voucher_id = ".$type_voucher." ORDER BY id ASC";
            global $db;
            $sql = $db->query($query);
            $result = $db->getObjectList();
            return $result;
        }
	}
	
?>