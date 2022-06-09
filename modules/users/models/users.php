<?php 
	class UsersModelsUsers extends FSModels
	{
		function __construct()
		{
		}
		function getConfig($name)
		{
			global $db;
			$sql = " SELECT value FROM fs_config 
				WHERE name = '$name' ";
			// $db->query($sql);
			return $db->getResult($sql);
		}
		
		
		/********** REGISTER ***********/
		/*
		 * save register
		 */
		function save()
		{
			global $db;
			$row = array();
			$reg_email = FSInput::get("_reg_email");
			$arr_email = explode( '@', $reg_email);
			if($this -> check_exist($arr_email[0], '', 'username', 'fs_members')){
				$row['username'] = $this -> genarate_username_news($arr_email[0],'','fs_members');
			}else{
				$row['username'] = $arr_email[0];
			}
			$password_de = FSInput::get("_reg_password");
			if(!$row['username'] && !$password_de)
				return;	
			$row['password'] = md5($password_de);
			$row['full_name'] =  $arr_email[0];
			$row['email'] =  $reg_email;
			$row['block'] =  0;
			$row['published'] =  1;
			$fstring = FSFactory::getClass('FSString','','../');
			$row['activated_code'] =  $fstring->generateRandomString(32);
			$row['type'] =  'guest';
		
			$time = date("Y-m-d H:i:s");	
			$row['created_time']  = $time;
			$row['edited_time']  = $time;


			$id = $this -> _add($row, 'fs_members');
			return $id;	
		}

		
		function update_account($username,$user_id,$address_book_id){
			$row = array('user_id' => $user_id, 'username' => $username);
			$this -> _update($row, 'fs_address_book', 'WHERE id = '.$address_book_id);
		}
		
		/*
		 * Register addressbook
		 */
		function register_address_book(){
			$time = date("Y-m-d H:i:s");	
			$data_address = array(
				'category_id'=>FSInput::get('cat_code'),
				'name'=>FSInput::get('name_address'),
				'business_license'=>FSInput::get('business_license'),
				'activity_filed'=>FSInput::get('activity_filed'),
				'main_areas'=>FSInput::get('main_areas'),
				'partner'=>FSInput::get('partner'),
				'partner_country_id'=>FSInput::get('partner_country_id'),
				'revenue'=>FSInput::get('revenue'),
				'quantity_staff'=>FSInput::get('quantity_staff'),
				'working_time_from'=>FSInput::get('working_time_from'),
				'working_time_to'=>FSInput::get('working_time_to'),
				'lunch_break_from'=>FSInput::get('lunch_break_from'),
				'lunch_break_to'=>FSInput::get('lunch_break_to'),
				'holiday_week'=>FSInput::get('holiday_week'),
				'country_id'=>FSInput::get('address_country_id'),
				'city_id'=>FSInput::get('address_city_id'),
				'district_id'=>FSInput::get('address_district_id'),
				'commune_id'=>FSInput::get('address_commune_id'),
				'street'=>FSInput::get('address_street'),
				'house'=>FSInput::get('address_house'),
				'region_phone'=>FSInput::get('address_region_phone'),
				'phone'=>FSInput::get('address_phone'),
				'region_fax'=>FSInput::get('address_region_fax'),
				'fax'=>FSInput::get('address_fax'),
				'hotline'=>FSInput::get('address_hotline'),
				'email_baokim'=>FSInput::get('email_baokim'),
				'website'=>FSInput::get('address_website'),
				'published'=>1,
				'created_time'=>$time,
				'edited_time'=>$time,
			);
			$certificate = FSInput::get('certificate',array(),'array');
			$object_service = FSInput::get('object_service',array(),'array');
			if(!empty($certificate) && is_array($certificate)){
				$data_address['certificate'] = ','.implode(',',$certificate).',';
			}
			if(!empty($object_service) && is_array($object_service)){
				$data_address['object_service'] = ','.implode(',',$object_service).',';
			}
			// Lấy thông tin bổ sung về danh mục (loại hình hoạt động)
			$categories = $this->get_record_by_id(FSInput::get('cat_code'),'fs_address_book_categories');
			$category_name = $categories->name;
			$data_address['category_name'] = $categories->name;
			$data_address['category_alias'] = $categories->alias;
			$data_address['category_alias_wrapper'] = $categories->alias_wrapper;
			$data_address['category_id_wrapper'] = $categories->list_parents;
			
			// partner country
			$detail = $this->get_record_by_id(FSInput::get('partner_country_id',0,'int'),'fs_countries');
			$data_address['partner_country_name'] = $detail->name;
			$data_address['partner_country_flag'] = $detail->flag;
			
			// country for address book
			if($detail = $this->get_record_by_id(FSInput::get('address_country_id'),'fs_countries')){
				$country_name = $detail->name;
				$data_address['country_name'] = $country_name;
				$data_address['country_flag'] = $detail->flag;
			}
			//	city for address book
			if($detail = $this->get_record_by_id(FSInput::get('address_city_id',0,'int'),'fs_cities')){
				$city_name = $detail->name;
				$data_address['city_name'] = $city_name;
			}
			//	district for address book			
			if($detail = $this->get_record_by_id(FSInput::get('address_district_id',0,'int'),'fs_districts')){
				$district_name = $detail->name;
				$data_address['district_name'] = $district_name;
			}
			//	commune for address book	
			if($detail = $this->get_record_by_id(FSInput::get('address_commune_id',0,'int'),'fs_commune')){
				$commune_name = $detail->name;
				$data_address['commune_name'] = $commune_name;
			}
			// Kiểm tra xem đăng ký mới hay sửa danh bạ
			$address_book_id = FSInput::get('address_book_id');
			if(!empty($address_book_id)){ 
				return $address_book_id;
			}else{
				//update content_search
				$fsstring = FSFactory::getClass('FSString','');	
				$content_search = $fsstring -> removeHTML($category_name.' '.FSInput::get('name_address').' '.FSInput::get('main_areas').' '.FSInput::get('activity_filed').' '.$country_name.' '.$city_name.' '.$district_name.' '.$commune_name);	
				
				$data_address['content_search'] =  $fsstring ->convert_utf8_to_telex($content_search).' '.$fsstring ->remove_viet_sign($content_search);
				$address_book_id = $this->_add($data_address,'fs_address_book');
				return $address_book_id;
			}
		}
		
		function upload_avatar(){
			$avatar = $_FILES["avatar"]["name"];
			if(!$avatar)
				return ;	
			$fsFile = FSFactory::getClass('FsFiles');
			$img_folder = 'images/avatar/original/';
			$path = str_replace('/', DS, $img_folder);
			$path = PATH_BASE.$path;
			
			$avatar = $fsFile -> uploadImage('avatar', $path ,2000000, '_'.time());
			if(!$avatar)
				return;
			// resize avatar : 50x50
			$path_resize = str_replace(DS.'original'.DS, DS.'resized'.DS, $path);
			if(!$fsFile ->resized_not_crop($path.$avatar, $path_resize.$avatar,130, 140))
				return false;
			return	$img_folder.$avatar;
		}
		
		
		
		function edit_save()
		{
			global $db;
			$update="";	
			$password = FSInput::get("password");
			if($password)
			{
				$password = md5($password);
				$sql_pwd  = "password = '$password'";
			}
			else
				$sql_pwd = "";
				
			
			$full_name      =  FSInput::get("full_name");
			$full_name=( !empty($full_name))?"full_name = '$full_name'":"";
			$update=$full_name;
			
			$birth_day      =  FSInput::get("birth_day");
			$birth_month      =  FSInput::get("birth_month");
			$birth_year      =  FSInput::get("birth_year");
			if(!empty($birth_day) && !empty($birth_month) && !empty($birth_year)){
				$birthday = date("Y-m-d",mktime(0, 0, 0, $birth_month, $birth_day, $birth_year));
			}
			$birthday=( !empty($birthday))?"birthday = '$birthday'":"";
			$update=(!empty($birthday) && !empty($update))?"$update,$birthday":$update.$birthday;
			

			
			$email      =  FSInput::get("email");
			$email=( !empty($email))?"email = '$email'":"";
			$update=(!empty($email) && !empty($update))?"$update,$email":$update.$email;
			
			$avatar = $this->upload_avatar();
			$avatar=( !empty($avatar))?"avatar = '$avatar'":"";
			$update=(!empty($avatar) && !empty($update))?"$update,$avatar":$update.$avatar;
			$sex       =  FSInput::get("sex");
			$sex =( !empty($sex ))?"sex  = '$sex '":"";
			$update=(!empty($sex ) && !empty($update))?"$update,$sex ":$update.$sex ;
			
			echo $sql_pwd;
			$update=(!empty($sql_pwd ) && !empty($update))?"$update,$sql_pwd ":$update.$sql_pwd ;
			
//			$phone      =  FSInput::get("mobilephone");
//			$phone=( !empty($phone))?"mobilephone = '$phone'":"";
//			$update=(!empty($phone) && !empty($update))?"$update,$phone":$update.$phone;
			
			if(!empty($update)){
				$sql = " UPDATE  fs_members SET 
								".$update."
								
							WHERE id = 	'".$_COOKIE['user_id']."' 
					";
				// $db->query($sql);
				$rows = $db->affected_rows($sql);
				if($rows)
				{
					return $rows;
				}
			}
			else{
				return false;
			}
		}

				/*
		 * save register
		 */
		function save_dd_care()
		{

			global $db;
			$row = array();
			$user_id = $_COOKIE['user_id'];
			
			$row['dd_care_id']  	 	  = FSInput::get('dd_care_item');	

			$id = $this -> _update($row, 'fs_members','id='.$user_id);
			return $id;	
		}

		/*
		 * check exist username
		 * Sim must active
		 * published == 1: OK.  not use
		 * published != 1: not OK
		 */
		function checkUsername($username)
		{
			global $db ;
			$username = FSInput::get("username");
			if(!$username )
			{
				Errors::setError("H&#227;y nh&#7853;p s&#7889; username");
				return false;
			}
			$sql = " SELECT count(*)
					FROM fs_members
					WHERE 
						username = '$username'
					";
			$db -> query($sql);
			$count =  $db->getResult();
			if(!$count)
			{
				Errors::setError("Username Ãƒâ€žÃ¢â‚¬ËœÃƒÆ’Ã‚Â£ tÃƒÂ¡Ã‚Â»Ã¢â‚¬Å“n tÃƒÂ¡Ã‚ÂºÃ‚Â¡i");
				return false;
			}
			return true;
			
		}
		
		/*
		 * function login 
		 */
		function login()
		{
			global $db;
			$user_name = FSInput::get('_log_username');
			$password = md5(FSInput::get3('_log_password'));
			$sql = " SELECT id, username, full_name, published,email,image,group_company,position_group,position_group_name
					FROM fs_users
					WHERE username = '$user_name'
					 AND password = '$password' 
					 AND published = 1
					 AND group_company <> 0
					 ";
//			 echo $sql; die();
			$db -> query($sql);
			return $db -> getObject();
		}
		/*
		/*
		 * function forget
		 */
		function forget()
		{
			global $db;
			$email = FSInput::get('email');	
			if(!$email)
				return false;
			$sql = " SELECT email, username, id ,full_name
					FROM fs_members
					WHERE email = '$email'
					 ";
			$db -> query($sql);
			return $db -> getObject();
		}
		
		function resetPass($userid)
		{
			$fstring = FSFactory::getClass('FSString','','../');
			$newpass =  $fstring->generateRandomString(8);
			$newpass_encode = md5($newpass);
			global $db;
			$sql = " UPDATE  fs_members SET 
						password = '$newpass_encode'
						WHERE 
						id = $userid
				";
			// $db->query($sql);
			$rows = $db->affected_rows($sql);
			if(!$rows)
			{
				return false;
			}
			return $newpass;
		}
		
	 /* save building */
        function save_changepass()
		{
			global $db;
            $text_pass_new = FSInput::get("text_pass_new");
            if(!$text_pass_new)
                return false;
                
            $username = $_SESSION['username'];
            
            $password_old_buid = md5(FSInput::get("text_pass_old"));
            $password_new_buid = md5(FSInput::get("text_pass_new"));
  	       
            $sql= "UPDATE fs_members SET password='".$password_new_buid."'  WHERE `username`='".$username."' and password='".$password_old_buid."'";
            
            $db->query($sql);
			$rows = $db->affected_rows($sql);
			return $rows;
		
        }
        
        /*
         * check duplicate email
         */
		function check_change_pass(){
			global $db ;
			$password_old_buid = FSInput::get("text_pass_old");
			if(!$password_old_buid)
				return false;
			$password_old_buid = md5($password_old_buid);
			
			$username = $_SESSION['username'];
			$sql = "SELECT count(*) as count FROM fs_members
				WHERE `username` = '".$username."'
						ANd `password` = '$password_old_buid' ";
			
			// $db->query($sql);
			$rs =  $db->getResult($sql);
			return $rs;
		}
		
		/*
		 * check old pass
		 * 
		 */
		function checkOldpass($old_pass)
		{
			global $db ;
			$user_id = $_COOKIE['user_id'];
			$old_pass = md5($old_pass);
			$sql = " SELECT count(*) 
					FROM fs_members 
					WHERE 
						id = '$user_id'
						AND password   = '$old_pass'
					";
			$db -> query($sql);
			$count =  $db->getResult();
			if(!$count)
			{
				return false;
			}
			return true;
		}
		/*
		 * check exist email and identify card.
		 */
		function checkExistUsers()
		{
			global $db ;
			$email      =  FSInput::get("email");
			$username      =  FSInput::get("username");
			if(!$email ||  !$username)
			{
				Errors::setError("BÃƒÂ¡Ã‚ÂºÃ‚Â¡n phÃƒÂ¡Ã‚ÂºÃ‚Â£i nhÃƒÂ¡Ã‚ÂºÃ‚Â­p Ãƒâ€žÃ¢â‚¬ËœÃƒÂ¡Ã‚ÂºÃ‚Â§y Ãƒâ€žÃ¢â‚¬ËœÃƒÂ¡Ã‚Â»Ã‚Â§ thÃƒÆ’Ã‚Â´ng tin vÃƒÆ’Ã‚Â o trÃƒâ€ Ã‚Â°ÃƒÂ¡Ã‚Â»Ã¯Â¿Â½ng email vÃƒÆ’Ã‚Â  username");
				return false;
			}
			$sql = " SELECT count(*) 
					FROM fs_members 
					WHERE 
						email = '$email'
						OR username = '$username'
					";
			$db -> query($sql);
			$count = $db->getResult();
			if($count)
			{
				Errors::setError("Email hoÃƒÂ¡Ã‚ÂºÃ‚Â·c Username Ãƒâ€žÃ¢â‚¬ËœÃƒÆ’Ã‚Â£ Ãƒâ€žÃ¢â‚¬ËœÃƒâ€ Ã‚Â°ÃƒÂ¡Ã‚Â»Ã‚Â£c sÃƒÂ¡Ã‚Â»Ã‚Â­ dÃƒÂ¡Ã‚Â»Ã‚Â¥ng");
				return false;
			}
			return true;
			
		}
		
		/*
		 * check exist email .
		 */
		function check_exits_email()
		{
			global $db ;
			$email      =  FSInput::get("_reg_email");
			if(!$email){
				return false;
			}
			$sql = " SELECT count(*) 
					FROM fs_members 
					WHERE 
						email = '$email'
						 AND type ='guest'
					";
			$db -> query($sql);
			$count = $db->getResult();
			if($count){
				$this -> alert_error('Email này đã có người sử dụng');
				return false;
			}
			return true;
		}
		/*
		 * check exist username .
		 */
		function check_exits_username()
		{
			global $db ;
			$username      =  FSInput::get("username");
			if(!$username){
				return false;
			}
			$sql = " SELECT count(*) 
					FROM fs_members 
					WHERE 
						username = '$username'
					";
			$db -> query($sql);
			$count = $db->getResult();
			if($count){
				$this -> alert_error('Username này đã có người sử dụng');
				return false;
			}
			return true;
		}
		
		function ajax_check_exits_username()
		{
			global $db ;
//			$username      =  FSInput::get("username");
			$username = $_POST['username_register'];
			if(!$username){
				return false;
			}
			$sql = " SELECT count(*) 
					FROM fs_members 
					WHERE 
						username = '$username'
					";
			$db -> query($sql);
			$count = $db->getResult();
			if($count){
				return false;
			}
			return true;
		}
		
		function ajax_check_exits_email()
		{
			global $db ;
			$email      =  FSInput::get("reg_email");
			if(!$email){
				return false;
			}
			$sql = " SELECT count(*) 
					FROM fs_members 
					WHERE 
						email = '$email' AND  type ='guest'
					";
			$db -> query($sql);
			$count = $db->getResult();
			if($count){
				return false;
			}
			return true;
		}
		
		/************ LOGGED **************/
		/*
		 * get menu have group = usermenu
		 */
		function getMenusUser()
		{
			global $db ;
			$sql = " SELECT id,link, name, images 
					FROM fs_menus_items
					WHERE published  = 1
						AND group_id = 5 
					ORDER BY ordering";
			// $db->query($sql);
			return $db->getObjectList($sql);
		}
		
		
		/********** DETAIL INFORMATION OF MEMBER **/
		function getMember()
		{
			global $db ;
			$user_id = '';
			if(!empty($_COOKIE['user_id'])){
                $user_id = $_COOKIE['user_id'];
            }
			$sql = " SELECT *
					FROM fs_members
					WHERE id  = '$user_id' ";
			// $db->query($sql);
			return $db->getObject($sql);
		}
		function getProvince($provinceid)
		{
			global $db ;
			$sql = " SELECT name
					FROM fs_cities
					WHERE id   = '$provinceid' ";
			// $db->query($sql);
			return $db->getResult($sql);
		}
		function getDistrict($districtid)
		{
			global $db ;
			$sql = " SELECT name
					FROM fs_districts
					WHERE id   = '$districtid'";
			// $db->query($sql);
			return $db->getResult($sql);
		}
		
		function getUserByUsername($username)
		{
			global $db ;
			
			$sql = " SELECT full_name, id FROM fs_members WHERE username = '$username'";
					// $db->query($sql);
			return $db->getObject($sql);
		}
		function getUserById($userid)
		{
			global $db ;
			
			$sql = " SELECT full_name,id 
					FROM fs_members WHERE id = '$userid'";
					// $db->query($sql);
			return $db->getObject($sql);
		}
		
		/*
		 * get estore_id,estore_name
		 * After login
		 */
//		function get_estore($username){
//			if(!$username)
//				return ;
//			global $db ;
//			$sql = " SELECT id,is_buy FROM fs_estores 
//						WHERE username = '$username'
//						AND activated  = 1
//						AND published = 1";
//					$db->query($sql);
//			return $db->getObject();
//		}
		
		/*
		 * Createa folder when create user
		 */
		function create_folder_upload($id){
			$fsFile = FSFactory::getClass('FsFiles','');
			$path = PATH_BASE.'uploaded'.DS.'estores'.DS.$id;
			return $fsFile->create_folder($path);
		}
		
		
		function send_mail_activated_user($name,$username,$password_de,$activated_code,$user_id,$email){
			// send Mail()
			$mailer = FSFactory::getClass('Email','mail');
			$global = new FsGlobal();
			$admin_name = $global -> getConfig('admin_name');
			$admin_email = $global -> getConfig('admin_email');
			$mail_register_subject = $global -> getConfig('mail_register_subject');
			$mail_register_body = $global -> getConfig('mail_register_body');

//			global $config;
			// config to user gmail
			
			$mailer -> isHTML(true);
			$mailer -> setSender(array($admin_email,$admin_name));
			$mailer -> AddBCC('phamhuy@finalstyle.com','pham van huy');
			$mailer -> AddAddress($email,$name);
			
			$mailer -> setSubject($mail_register_subject);
			$url_activated = FSRoute::_('index.php?module=users&view=users&task=activate&code='.$activated_code.'&id='.$user_id);
			// body
			$body = $mail_register_body;
			$body = str_replace('{name}', $name, $body);
			$body = str_replace('{username}', $username, $body);
			$body = str_replace('{password}', $password_de, $body);
			$body = str_replace('{url_activated}', $url_activated, $body);
											
			$mailer -> setBody($body);
			
			if(!$mailer ->Send())
				return false;
			return true;
			
			//en
		}
	/*
		/*
		 * function forget
		 */
		function activate(){
			global $db;
			$code = FSInput::get('code');	
			$id = FSInput::get('id',0,'int');
			if(!$code || !$id)
				return false;
					
			$sql = " SELECT username,id,published
					FROM fs_members
					WHERE 
						id = '$id'
						 AND activated_code = '$code'
						 AND block <> 1
					 ";
			$db -> query($sql);
			$rs =  $db -> getObject();
			include 'libraries/errors.php';
			if(!$rs){
				Errors::_('Không kích hoạt tài khoản thành công');
				return false;
			}
			if($rs -> published){
				Errors::_('Tài khoản này đã kích hoạt từ trước.');
				return false;
			}
			$time = date("Y-m-d H:i:s");
			$row['published'] = 1;
			$row['published_time'] = $time;
			if(!$this -> _update($row,'fs_members',' id = "'.$id.'" AND activated_code = "'.$code.'" ')){
				Errors::_('Không kích hoạt tài khoản thành công.');
				return false;
			}
			return true;
		}	
			
		/* ==================================================
		 * ================== ADDRESS BOOK  =================
		  ==================================================*/
		function get_address_book_by_key(){
			$key = FSInput::get('key');
			if(!$key)
				return;
			$sql = "SELECT id,name,country_name,category_alias,alias
					FROM fs_address_book
					WHERE published = 1
					AND content_search like '%$key%'
					ORDER BY hits DESC,created_time DESC
					LIMIT 60	";	
			global $db ;
			// $db->query($sql);
			return $db->getObjectList($sql);
		} 
		function get_address_book_properties(){
			$sql = "SELECT id,name,type
					FROM fs_address_book_property
					WHERE published = 1
					ORDER BY type ASC ,ordering ASC
					LIMIT 60	";	
			global $db ;
			// $db->query($sql);
			return $db->getObjectList($sql);
		} 
		function ajax_login()
		{
			global $db;
			$user_email = $_POST['username_login'];
			$password = md5($_POST['password_login']);
			$sql = " SELECT id, username, full_name,block, published 
					FROM fs_members
					WHERE email = '$user_email'
					 AND password = '$password' 
					 AND block <> 1
					  AND type = 'guest'
					 ";
			$db -> query($sql);
			return $db -> getObject();
		}
		function get_comments()
		{
			global $db ;
			$user_id = $_COOKIE['user_id'];
			$sql = " SELECT *
					FROM fs_notify
					WHERE user_id  = '$user_id' 
					ORDER BY created_time ASC
					";
			// $db->query($sql);
			return $db->getObjectList($sql);
		}
		function readed_message(){
			$user_id = $_COOKIE['user_id'];
			if(!$user_id)
				return;
			$sql = ' UPDATE fs_notify SET is_read = 1 WHERE  user_id = '.$user_id .' ';
			global $db;
			// $db->query($sql);
			$rows = $db->affected_rows($sql);
			return $rows;
		}
		
		function get_product($id){
			global $db ;
			$sql = " SELECT *
					FROM fs_products
					WHERE id  = $id 
					";
			// $db->query($sql);
			return $db->getObject($sql);
		}
		function get_comment_reply($id){
			global $db ;
			$sql = " SELECT *
					FROM fs_products_comments
					WHERE parent_id  = $id 
					";
			// $db->query($sql);
			return $db->getObject($sql);
		}
		function getDistricts($cityid = '1473')
		{
			if(!$cityid)
				$cityid = '1473';
			global $db ;
			$sql = " SELECT id, name FROM fs_districts
					WHERE city_id = $cityid ";
			// $db->query($sql);
			return $db->getObjectList($sql);
		}
		/********** REGISTER ***********/
		/*
		 * save register
		 */
		function edit_add_save()
		{
			global $db;
			$row = array();
			$user_id = $_COOKIE['user_id'];
			$sex = FSInput::get("sex");
			$full_name = FSInput::get("full_name");
			$mobilephone = FSInput::get("mobilephone");
			$telephone = FSInput::get("telephone");
			$address = FSInput::get("address");
			$city_id = FSInput::get("city_id");
			$district_id = FSInput::get("district_id");
			$is_default = FSInput::get("is_default");
			if($is_default){
				$is_default = 1;
			}else{
				$is_default = 0;
			}
			// $id = $this -> _update($row, 'fs_members','id='.$user_id);

	        $sql = " UPDATE `fs_members` SET 
	        		sex = '".$sex."',
	        		full_name = '".$full_name."',
	        		mobilephone = '".$mobilephone."',
	        		telephone = '".$telephone."',
	        		address = '".$address."',
	        		city_id = '".$city_id."',
	        		district_id = '".$district_id."',
	        		is_default = '".$is_default."'
	        		WHERE id = '".$user_id."'
	        	";
	        $id = $db->affected_rows($sql);
			return $id;	
		}
		/*
		 * Tạo ra username mới nếu nó tồn tại 
		 */
		function genarate_username_news($value,$id = '',$table_name = ''){
			if(!$value)
				return false;
			if(!$table_name)
				$table_name = $this -> table_name;
			$i = 1;
			while(true){
				$value_news = $value.'_'.$i; 
				if(!$this -> check_exist($value_news,$id,'username',$table_name)){
					return $value_news;
				}
				$i ++;
			}
		}
	}
	
?>