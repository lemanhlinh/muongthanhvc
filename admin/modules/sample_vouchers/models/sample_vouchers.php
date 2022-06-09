<?php 
	class Sample_vouchersModelsSample_vouchers extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'sample_vouchers';
			$this -> table_name = 'fs_sample_pdf';
            $this->arr_img_paths = array(
                array('resized', 300, 300, 'resize_image'),
            );
            $this->img_folder = 'images/file/image';
            $this->check_alias = 1;
            $this->field_img = 'image';
			parent::__construct();
		}
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			$where = "  ";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}	
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.name LIKE '%".$keysearch."%' ";
				}
			}

            if (isset ( $_SESSION [$this->prefix . 'filter0'] )) {
                $filter = $_SESSION [$this->prefix . 'filter0'];
                if ($filter) {
                    $where .= ' AND a.type_voucher_id = ' . $filter . ' ';
                }
            }
			
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_name." AS a
						  	WHERE 1=1 ".
						 $where.
						 $ordering. " ";
			return $query;
		}

        function  save($row = array(),$use_mysql_real_escape_string = 0){
            $cyear = date('Y');
            $cmonth = date('m');
            $cday = date('d');
            $path = PATH_BASE.'images'.DS.'file'.DS.$cyear.DS.$cmonth.DS.$cday.DS;
            require_once(PATH_BASE.'libraries'.DS.'upload.php');
            $upload = new  Upload();
            $upload->create_folder ( $path );
            $file_upload = $_FILES["file"]["name"];
            if($file_upload){
                $type_file = explode('.', $file_upload);
                $type_file = end($type_file);
                $tmp = $_FILES['file']['tmp_name'];
                move_uploaded_file($tmp,$path.$file_upload);
                $row['file'] = 'images/file/'.$cyear.'/'.$cmonth.'/'.$cday.'/'.$file_upload;
            }
            $id = parent::save($row);
            return $id;
        }
}
?>