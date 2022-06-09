<?php
/*
 * Huy write
 */
	// controller
	class UsersControllersUsers extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			// call models
			$model = $this -> model;
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/log.php';
		}
		
		/*
		 * View information of member
		 */
		function detail()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = $this -> model;
			$data  = $model -> getMember();
			$province = $model -> getProvince($data -> province);
			$district = $model -> getDistrict($data -> district);
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		/*
		 * View information of member
		 */
		function edit()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = $this -> model;
			$data  = $model -> getMember();
			$cities  = $model -> get_cities();
			$districts  = $model -> get_districts($data -> city_id);
			$config_person_edit  = $model -> getConfig('person_edit');
			include 'modules/'.$this->module.'/views/'.$this->view.'/edit.php';
		}

		function user_info(){
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = $this -> model;
			$data  = $model -> getMember();
			//breadcrumbs
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Thông tin tài khoản', 1 => '');	
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/user_info.php';
		}


		function login()
		{
			$model = $this -> model;
			if(isset($_COOKIE['user_id'])){
				$link = FSRoute::_('index.php?module=users&task=logged&Itemid=37');
				setRedirect($link);
			}
			// $config_person_login_info  = $model -> getConfig('login_info');
			
			//breadcrumbs
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Đăng nhập', 1 => '');	
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			
//			$config_person_register_info  = $model -> getConfig('person_register_info');
			include 'modules/'.$this->module.'/views/'.$this->view.'/login.php';
		}
		
			
		function login_save()
		{
			$model = $this -> model;
			$Itemid = FSInput::get('Itemid',11,'int');
			
	            $user = $model -> login();  
	            
	            if( $user){
	            $persistent ='on';  
				if ($persistent == 'on') {
					
		            /* Set cookie to last *1 day */
					$time =time()+60*60*24*1;
					
		            setcookie('full_name',$user->full_name,$time,'/');
		            setcookie('user_id',$user->id,$time,'/');
		            setcookie('username',$user->username,$time,'/');
		            setcookie('user_email',$user->email,$time,'/');
		            setcookie('image',$user->image,$time,'/');
		            setcookie('group_company',$user->group_company,$time,'/');
		            setcookie('position_group',$user->position_group,$time,'/');
		            setcookie('position_group_name',$user->image,$time,'/');

		        
		        } else {
		            /* Cookie expires when browser closes */
		            setcookie('full_name',$user->full_name,false,'/');
		            setcookie('user_id',$user->id,false,'/');
		            setcookie('username',$user->username,false,'/');
		            setcookie('user_email',$user->email,false,'/');
		            setcookie('image',$user->image,false,'/');
		            setcookie('group_company',$user->group_company,false,'/');
		            setcookie('position_group',$user->position_group,false,'/');
		            setcookie('position_group_name',$user->position_group_name,false,'/');
		        }
				$msg ="Bạn đã đăng nhập thành công";
				$link = URL_ROOT;
			}else{
				$msg ="Bạn chưa đăng nhập thành công";
				$link =URL_ROOT;
			}
			setRedirect($link, $msg);
		}


		/*
		 * Display form forget
		 */
		function forget()
		{
			if(isset($_SESSION['username']))
			{
				if($_SESSION['username'])
				{
					$Itemid = 37;
					$link = FSRoute::_("index.php?module=users&task=logged&Itemid=$Itemid");
					setRedirect($link);
				}
			}
			$model = $this -> model;
			$config_person_forget  = $model -> getConfig('person_forget');
			
			//breadcrumbs
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Quên mật khẩu', 1 => '');	
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/forget.php';
		}
		
		function activate(){
			$model = $this -> model;
			$url = FSRoute::_('index.php?module=users&task=login&Itemid=11');
			if($model->activate()){
				setRedirect($url,'Tài khoản của bạn đã được kích hoạt thành công');	
			}else{
				setRedirect($url);
			}
		}
		
		function forget_save()
		{
			if(!$this->check_captcha())
			{
				$msg = "Mã hiển thị không đúng";
				setRedirect("index.php?module=users&task=forget&Itemid=38",$msg,'error');
			}
			
			$model = $this -> model;
			
			$user = $model->forget();
			if(@$user->email)
			{
				$resetPass = $model->resetPass($user->id);
				if(!$resetPass)
				{
					$msg = "Lỗi hệ thống khi reset Password";
					setRedirect("index.php?module=users&task=login&Itemid=11",$msg,'error');	
				}
				include 'modules/'.$this->module.'/controllers/emails.php';
				// send Mail()
				$user_emails = new  UsersControllersEmail();
				if(!$user_emails -> sendMailForget($user,$resetPass))
				{
					$msg = "Lỗi hệ thống khi send mail";
					setRedirect("index.php?module=users&task=login&Itemid=11",$msg,'error');	
				}
				$msg = "Mật khẩu của bạn đã được thay đổi. Vui lòng kiểm tra email của bạn";
				setRedirect("index.php?module=users&task=login&Itemid=11",$msg);	
			}
			else{
				$msg = "Email của bạn không tồn tại trong hệ thống. Vui lòng kiểm tra lại!";
				setRedirect("index.php?module=users&task=forget&Itemid=38",$msg,'error');
			}
		}
		
		function logout()
		{

			setcookie('full_name', null, -1,'/');
			setcookie('user_id', null, -1,'/');
			setcookie('avatar', null, -1,'/');
			setcookie('username', null, -1,'/');
			setcookie('user_email', null, -1,'/');
			setcookie('type', null, -1,'/');
			setcookie('user', null,-1,'/');
			
			unset($_SESSION['user']);
			unset($_SESSION['access_token']);
			unset($_SESSION['state']);
		
			setRedirect(URL_ROOT);
		}


		/*
		 * After login
		 */
		function logged()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
			$fssecurity -> checkLogin();
			$model = $this -> model;
//			$menus_user = $model -> getMenusUser();
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/logged.php';	
		}
		/**************** EDIT ***********/
		function edit_save()
		{
			$model = $this -> model;
			$Itemid = FSInput::get("Itemid",1);
			$edit_pass = FSInput::get("edit_pass");
			if($edit_pass)
			{
				if(! $this -> check_edit_save())
				{
					$link = FSRoute::_("index.php?module=users&view=users&task=user_info&Itemid=$Itemid");
					$msg = FSText::_("Không thay đổi được!");
					setRedirect($link,$msg,'error');
				}
			}
			$id = $model->edit_save();
			// if not save
			if($id)
			{
				$data  = $model -> getMember();
				setcookie('full_name', FSInput::get('full_name'),$time);
				if($data-> avatar);
					setcookie('avatar',$data-> avatar,$time);
				$link = FSRoute::_("index.php?module=users&task=user_info&Itemid=$Itemid");
				$msg = FSText::_("Bạn đã cập nhật thành công");
				setRedirect($link,$msg);
			}
			else
			{
				$link = FSRoute::_("index.php?module=users&task=user_info&Itemid=$Itemid");
				$msg = FSText::_("Không cập nhật thành công!");
				setRedirect($link,$msg,'error');
			}
		}
		
		/**************** EDIT ***********/
		function save_dd_care()
		{
			$model = $this -> model;
			$Itemid = FSInput::get("Itemid",1);
		
			$id = $model->save_dd_care();
			// if not save
			if($id){
		
				$link = FSRoute::_("index.php?module=users&task=dd_care&Itemid=$Itemid");
				$msg = FSText::_("Bạn đã cập nhật thành công");
				setRedirect($link,$msg);
			}
			else
			{
				$link = FSRoute::_("index.php?module=users&task=dd_care&Itemid=$Itemid");
				$msg = FSText::_("Không cập nhật thành công!");
				setRedirect($link,$msg,'error');
			}
		}
		function views_select_birthday(){
			include 'modules/'.$this->module.'/views/'.$this->view.'/select_birthday.php';	
		}
		function check_edit_save()
		{
			FSFactory::include_class('errors');
			$model = $this -> model;
			// check pass
			$old_password = FSInput::get("old_password");
			$password = FSInput::get("password");
			$re_password = FSInput::get("re-password");
			if(!$model -> checkOldpass($old_password))
			{
				Errors::setError(FSText::_("Mật khẩu không đúng"));
				return false;
			}
			if($password && ($password != $re_password))
			{
				Errors::setError(FSText::_("Mật khẩu không trùng nhau nhau"));
				return false;
			}	
			if($password=='' || $re_password =='')
			{
				Errors::setError(FSText::_("Chưa nhập mật khẩu mới"));
				return false;
			}	

			return true;
		}
		/**************** REGISTER ***********/
		/*
		 * Resigter
		 */
		function register()
		{
			
			$model = $this -> model;
			$config_register_rules  = $model -> getConfig('register_rules');
			$config_register_info  = $model -> getConfig('register_info');

			
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Đăng ký thành viên', 1 => '');	
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/register.php';
		}
		
		function register_save()
		{
			$model = $this -> model;
			$Itemid = FSInput::get("Itemid",1);
			if(! $this -> check_register_save()){
				return URL_ROOT;
			}
			$id = $model->save();
			$user = $model -> get_record_by_id($id,'fs_members','username,full_name');
			// if not save
			if($id){
				
				$time =time()+60*60*24*30; 
				setcookie('full_name', $user-> full_name,$time);
	            setcookie('user_id', $id,$time);
	            setcookie('username',$user->username,$time);


				$link = FSRoute::_("index.php?module=users&view=users&task=user_info");
				
 				$msg = "Bạn đã đăng ký tài khoản thành công!";
				setRedirect($link,$msg);
			}
			else
			{
				$link =URL_ROOT;
				$msg = FSText::_("Xin lỗi. Bạn chưa đăng ký thành công.");
				setRedirect($link,$msg,'error');
			}
		}
		
		function check_register_save(){
			// check pass
			// $username = FSInput::get("username");
			// FSFactory::include_class('errors');
			// if(!$username){
			// 	Errors::setError(FSText::_("Chưa nhập username"));
   //              return false;
			// }
			     
			// $password = FSInput::get("password");
			// $re_password = FSInput::get("re-password");
			// if(!$password || !$re_password)
			// {
			// 	Errors::setError(FSText::_("Chưa nhập mật khẩu"));
			// 	return false;
			// }
			// if($password != $re_password)
			// {
			// 	Errors::setError(FSText::_("Mật khẩu không trùng nhau"));
			// 	return false;
			// }	
			
			// $email = FSInput::get("email");
			// $re_email = FSInput::get("re-email");
			// if(!$email || !$re_email)
			// {
			// 	Errors::setError(FSText::_("Chưa nhập email"));
			// 	return false;
			// }
			// if($email != $re_email)
			// {
			// 	Errors::setError(FSText::_("Email nhập lại không khớp"));
			// 	return false;
			// }
			
			// check captcha				
// 			if(!$this->check_captcha()){
// //				Errors::setError(FSText::_("Mã hiển thị chưa đúng"));
// 				$this -> alert_error('Mã hiển thị chưa đúng');
// 				return false;
// 			}
			
			$model = $this -> model;
			// check email and identify card
			if(!$model->check_exits_email()){
				return false;
			}
			// if(!$model->check_exits_username()){
			// 	return false;
			// }
			
			return true;
		}
		
		
		function check_exits_email(){
			$model = $this -> model;
			if(!$model -> check_exits_email())
				return false;
			return true;
		}
		
		function ajax_check_exist_username(){
			$model = $this -> model;
			if(!$model -> ajax_check_exits_username()){
				echo 0;
				return false;
			}
			echo 1;
			return true;
		}
		
		function ajax_check_exist_email(){
			$model = $this -> model;
			if(!$model -> ajax_check_exits_email()){
				echo 0;
				return false;
			}
			echo 1;
			return true;
		}
		
		/*
		 * load District by city id. 
		 * Use Ajax
		 */
		
		function destination(){
			$model = $this -> model;
			
			$cid = FSInput::get('cid');
			$did = FSInput::get('did');
			if($cid){
				$rs  = $model -> getDestination($cid);
			}
			if($did){
				$rs  = $model -> getDestination1($did);
			}
			$json = '[{id: 0,name: "Điểm đến"},'; // start the json array element
			$json_names = array();
			foreach( $rs as $item)
			{
				$json_names[] = "{id: $item->id, name: '$item->name'}";
			}
			$json .= implode(',', $json_names);
			$json .= ']'; // end the json array element
			echo $json;
		}
		
		/*
		 * check valid Sim
		 */
//		function check_valid_sim()
//		{
//		// check SIM
//			$model = $this -> model;
//			if(!$model->checkSimByAjax())
//			{
//				echo 0;
//				return;
//			}
//			echo 1;
//			return;
//		}
	 function changepass()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
            $model = $this -> model;
			$Itemid = FSInput::get("Itemid",1);
			include 'modules/'.$this->module.'/views/'.$this->view.'/changepass.php';
			
		}
        function edit_save_changepass()
		{
			// check logged
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = $this -> model;
			$Itemid = FSInput::get("Itemid",1);
			
			$link = FSRoute::_("index.php?module=users&task=&Itemid=40");
			$check =  $model->check_change_pass();
			if(!$check){
				setRedirect($link,'Mật khẩu cũ chưa chính xác','error');
			}
			
			$rs = $model->save_changepass();
			// if not save
			
			if($rs) {
				$msg = FSText::_("Bạn đã thay đổi thành công");
				setRedirect($link,$msg);
			}
			else
			{
				$msg = FSText::_("Xin lỗi. Bạn chưa thay đổi thành công!");
				setRedirect($link,$msg,'error');
			}
		}
		
        function change_email_save()
		{
			// check logged
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = $this -> model;
			$Itemid = FSInput::get("Itemid",1);
			
			$link = FSRoute::_("index.php?module=users&task=changepass&Itemid=$Itemid");
			$email_new = FSInput::get('email_new');
			if($email_new){
				
				$re_email_new = FSInput::get('re_email_new');		
				if($email_new != $re_email_new){
					$msg = FSText::_("Email nh&#7853;p ch&#432;a kh&#7899;p!");
					setRedirect($link,$msg,'error');
				}
				$check =  $model->check_change_pass();
				if(!$check){
					setRedirect($link,'Email m&#7899;i c&#7911;a b&#7841;n &#273;&#227; t&#7891;n t&#7841;i trong h&#7879; th&#7889;ng. B&#7841;n ch&#432;a thay &#273;&#7893;i &#273;&#432;&#7907;c th&#244;ng tin','error');
				}
			} 
			
			$rs = $model->save_changepass();
			// if not save
            
			
			if($rs) {
				$msg = FSText::_("B&#7841;n &#273;&#227; thay &#273;&#7893;i th&#224;nh c&#244;ng");
				setRedirect($link,$msg);
			}
			else
			{
				$msg = FSText::_("Xin l&#7895;i, b&#7841;n &#273;&#227; thay &#273;&#7893;i kh&#244;ng th&#224;nh c&#244;ng!");
				setRedirect($link,$msg,'error');
			}
		}
		/*
		 * * Load list addbook
		 * Get address book for search
		 */
		function ajax_get_address_book_by_key(){
			$model = $this -> model;
			$list = $model -> get_address_book_by_key();
			$total = count($list);
			if(!$total){
				$add_property = $model -> get_address_book_properties();
				// convert to array
				$other_properties = array();
				foreach($add_property as $item){
					if(!isset($other_properties[$item->type]))
						$other_properties[$item->type] = array();
					$other_properties[$item->type][] = $item;
				}
				// location	
				$countries  = $model -> get_countries();
				$country_current = isset($data -> coutry_id)?$data -> coutry_id:66; // default: VietNam
				$cities  = $model -> get_cities($country_current);
				$city_id_first = $cities[0] ->id;
				$city_current = isset($data -> city_id)?$data -> city_id:$city_id_first;
				$districts  = $model -> get_districts($city_current);
				$district_current = isset($data -> district_id)?$data -> district_id:$districts[0]->id;
				$communes  = $model -> get_communes($district_current);
				$commune_current = isset($communes[0]->id)?$communes[0]->id:0;
				$categories = $model -> get_records('published = 1','fs_address_book_categories',$select = 'id,name,parent_id',$ordering = ' ordering,id ');
			}
			include 'modules/'.$this->module.'/views/'.$this->view.'/register_address_book.php';
		}
		
		function ajax_add_address_book_form(){
			$model = $this -> model;
			$add_property = $model -> get_address_book_properties();
			// convert to array
			$other_properties = array();
			foreach($add_property as $item){
				if(!isset($other_properties[$item->type]))
					$other_properties[$item->type] = array();
				$other_properties[$item->type][] = $item;
			}
				
			// location	
			$countries  = $model -> get_countries();
			$country_current = 66; // default: VietNam
			$cities  = $model -> get_cities($country_current);
			$city_current = isset($cities[0] ->id)?$cities[0] ->id:0;
			$districts  = $model -> get_districts($city_current);
			$district_current = isset($data -> district_id)?$data -> district_id:$districts[0]->id;
			$communes  = $model -> get_communes($district_current);
			$commune_current = isset($communes[0]->id)?$communes[0]->id:0;
			$categories = $model -> get_records('published = 1','fs_address_book_categories',$select = 'id,name,parent_id',$ordering = ' ordering,id ');
			include 'modules/'.$this->module.'/views/'.$this->view.'/register_add_addressbook.php';
		}
		
		/*
		 * Get address book for search
		 */
		function ajax_load_address_book_by_id(){
			$model = $this -> model;
			$id = FSInput::get('id','int',0);
			if(!$id)
				return;
			$data = $model -> get_record_by_id($id,'fs_address_book');
			if(!$data)
				return;
			$add_property = $model -> get_address_book_properties();
			// convert to array
			$other_properties = array();
			foreach($add_property as $item){
				if(!isset($other_properties[$item->type]))
					$other_properties[$item->type] = array();
				$other_properties[$item->type][] = $item;
			}
			// location	
			$countries  = $model -> get_countries();
			$country_current = isset($data -> coutry_id)?$data -> coutry_id:66; // default: VietNam
			$cities  = $model -> get_cities($country_current);
			$city_id_first = $cities[0] ->id;
			$city_current = isset($data -> city_id)?$data -> city_id:$city_id_first;
			$districts  = $model -> get_districts($city_current);
			$district_current = isset($data -> district_id)?$data -> district_id:$districts[0]->id;
			$communes  = $model -> get_communes($district_current);
			$commune_current = isset($data -> commune_id)?$data -> commune_id:$communes[0]->id;
			$categories = $model -> get_records('published = 1','fs_address_book_categories',$select = 'id,name,parent_id',$ordering = ' ordering,id ');

			include 'modules/'.$this->module.'/views/'.$this->view.'/register_load_address_book.php';
		}
		function ajax_check_check_login(){
			
			$user = $this->model -> ajax_login();
			if(!$user){
				echo 0;
				return false;
			}
			echo 1;
			return true;
		}

	function majax_check_check_login(){

		$user = $this->model -> ajax_login();
		if(!$user){
			echo 0;
			return false;
		}
		echo 1;
		return true;
	}

		function commemts(){
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = $this -> model;
			$comments = $model -> get_comments();

			$model -> readed_message();
			include 'modules/'.$this->module.'/views/'.$this->view.'/comments.php';
		}
	function mcommemts(){
		$fssecurity  = FSFactory::getClass('fssecurity');
		$fssecurity -> checkLogin();
		$model = $this -> model;
		$comments = $model -> get_comments();

		$model -> readed_message();
		include 'modules/'.$this->module.'/views/'.$this->view.'/comments.php';
	}
		function  get_product($id) {
			$model = $this -> model;
			$comments = $model -> get_product($id);
			return $comments;
		}
		function  get_comment_reply($id) {
			$model = $this -> model;
			$comments = $model -> get_comment_reply($id);
			return $comments;
		}
		function district()
		{
			$model  = $this -> model;
			$cid = FSInput::get('cid');
			$rs  = $model -> getDistricts($cid);
			
			$json = '['; // start the json array element
			$json_names = array();
			foreach( $rs as $item)
			{
				$json_names[] = "{id: $item->id, name: '$item->name'}";
			}
			$json .= implode(',', $json_names);
			$json .= ']'; // end the json array element
			echo $json;
		}
		function edit_add_save(){
			$model = $this -> model;
			$Itemid = FSInput::get("Itemid",1);
	
			$id = $model->edit_add_save();
			// if not save
			if($id)
			{
				$link = FSRoute::_("index.php?module=users&task=address_book&Itemid=$Itemid");
				$msg = FSText::_("Bạn đã cập nhật thành công");
				setRedirect($link,$msg);
			}
			else
			{
				$link = FSRoute::_("index.php?module=users&task=address_book&Itemid=$Itemid");
				$msg = FSText::_("Không cập nhật thành công!");
				setRedirect($link,$msg,'error');
			}
		}
		function city_save(){
			$city_id = FSInput::get('city_id');
			$return = FSInput::get('return');
			$link = URL_BASIC.base64_decode($return);
			setcookie( "city_id", $city_id, time()+(60*60*24*30) ); 
			if($return)
				setRedirect($link);
			else
				setRedirect(URL_ROOT);
		}
		function mcity_save(){
			$city_id = FSInput::get('city_id');
			$return = FSInput::get('return');
			$link = URL_BASIC.base64_decode($return);
			setcookie( "city_id", $city_id, time()+(60*60*24*30) ); 
			if($return)
				setRedirect($link);
			else
				setRedirect(URL_ROOT);
		}
		function add_save(){
			$add_id = FSInput::get('add_id');
			$return = FSInput::get('return');
			$link = URL_BASIC.base64_decode($return);
			setcookie( "add_id", $add_id, time()+(60*60*24*30) ); 
			if($return)
				setRedirect($link);
			else
				setRedirect(URL_ROOT);
		}
		function madd_save(){
			$add_id = FSInput::get('add_id');
			$return = FSInput::get('return');
			$link = URL_BASIC.base64_decode($return);
			setcookie( "add_id", $add_id, time()+(60*60*24*30) ); 
			if($return)
				setRedirect($link);
			else
				setRedirect(URL_ROOT);
		}
		function show_box_login(){
			global $config;
			$html='';
			$html .=' <div class="modal-dialog">';
				$html .=' <div class="modal-content">';
					$html .='<div class="modal-header">';
		        		$html .='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;</button>';
	                $html .=' </div>';
             		$html.='<div class="modal-body">';
	                  	$html.='<ul class="nav nav-tabs _tabs mbl ">';
		                    $html.='<li class="active"><a href="#login" data-toggle="tab">Đăng nhập tài khoản</a></li>';
		                    $html.='<li><a href="#create" data-toggle="tab">Đăng ký mới</a></li>';
	                  	$html.='</ul>';
		                $html.='<div id="myTabContent" class="tab-content">';
		                    $html.='<div class="tab-pane active in" id="login">';
		                      	$html.='<form class="" action="#" method="post" name="login_form" onsubmit="javascript: submit_form_login();return false;">';
		                            $html.='<p>';
		                              	$html.='<span class="txt_title">Email của bạn:</span>';
		                              	$html.='<input type="text" id="_log_email" name="_log_email" placeholder="Email của bạn" class="txt_input">';
		                            $html.='</p>';
		                            $html.='<p>';
		                              	$html.='<span class="txt_title">Mật khẩu:</span>';
		                              	$html.='<input type="password" id="_log_password" name="_log_password" placeholder="Nhập mật khẩu" class="txt_input">';
		                            $html.='</p>';
		                       		$html .='<p >';
			                          	$html.='<span class="txt_title">&nbsp;</span>';
		                              	$html .='<input type="submit"  class = "_btn_register" value="Đăng nhập" />';
			                        $html .='</p>';
			                        $html.='<input type="hidden" name = "module" value = "users" />';
				                    $html.='<input type="hidden" name = "view" value = "users" />';
				                    $html.='<input type="hidden" name = "task" value = "login_save" />';
		                      	$html.='</form>';                
		                    $html.='</div>';
		                    $html.='<div class="tab-pane fade" id="create">';
		               			$html.='<form action="'.FSRoute::_("index.php?module=users") .'" name="register_form" class="register_form" method="post" onsubmit="javascript: submit_form_register();return false;">';
			                      	$html.='<p>';
			                        	$html.='<span class="txt_title">Email của bạn:</span>';
		                              	$html.='<input type="text" id="_reg_email" name="_reg_email" value="" class="txt_input"  placeholder="Email của bạn">';
			                        $html.='</p>';
			                        $html.='<p>';
			                        	$html.='<span class="txt_title">Mật khẩu:</span>';
		                              	$html.='<input type=password id="_reg_password" name="_reg_password" value="" class="txt_input"  placeholder="Nhập mật khẩu">';
			                        $html.='</p>	';
			                        $html .='<p>';
			                        	$html.='<span class="txt_title">Nhập lại mật khẩu:</span>';
		                              	$html .='<input type=password id="_re_reg_password" name="_re_reg_password" value="" class="txt_input"  placeholder="Nhập lại mật khẩu">';
			                        $html .='</p>';
			                        $html.='<p>';
							    	    $html.='<span class="txt_title" style="padding:0;">&nbsp;</span>';
		                              	$html.='<input name="remember" type="checkbox" id="remember">&nbsp; Chấp nhận <a title="Điều khoản sử dụng" href="'.$config['dieu_khoan_sd'].'">Điều khoản sử dụng</a> của Maxmobile';
							    	$html.='</p>';
							    	$html .='<p>';
			                          	$html.='<span class="txt_title">&nbsp;</span>';
		                              	$html .='<input type="submit"  class = "_btn_register" value="Đăng ký" />';
			                        $html .='</p>';
									$html.='<input type="hidden" name = "module" value = "users" />';
				                    $html.='<input type="hidden" name = "view" value = "users" />';
				                    $html.='<input type="hidden" name = "task" value = "register_save" />';
		                      	$html.='</form>';
		                	$html.='</div>';
		                	  $html.='<p class="text-center">';
	                         	$html.='<span class="txt_title">&nbsp;</span>';
		                        $html.='<label>Hoặc kết nối với chúng tôi qua</label>';
								$html.='<a class="btn btn-primary social-login-btn social-facebook" href="'.FSRoute::_('index.php?module=users&view=face&task=face_login').'"><img src="'.URL_ROOT.'templates/default/images/icon-facebook.png" alt="facebook"></a>';
								$html.='<a class="btn btn-primary social-login-btn social-google" href="'.URL_ROOT.'index.php?module=users&view=google&raw=1&task=google_login&Itemid=10'.'"><img src="'.URL_ROOT.'templates/default/images/icon-google.png" alt="facebook"></a>';
							$html.='</p>';
		            	$html .=' </div>';    
            		$html .=' </div>';
            	$html .=' </div>';
            $html .=' </div>';	
            echo $html;
    
		}

		function show_box_register(){
			global $config;
			$html='';
			$html .=' <div class="modal-dialog">';
				$html .=' <div class="modal-content">';
					$html .='<div class="modal-header">';
		        		$html .='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;</button>';
	                $html .=' </div>';
             		$html.='<div class="modal-body">';
	                  	$html.='<ul class="nav nav-tabs _tabs mbl ">';
		                    $html.='<li><a href="#login" data-toggle="tab">Đăng nhập tài khoản</a></li>';
		                    $html.='<li class="active"><a href="#create" data-toggle="tab">Đăng ký mới</a></li>';
	                  	$html.='</ul>';
		                $html.='<div id="myTabContent" class="tab-content">';
		                    $html.='<div class="tab-pane fade" id="login">';
		                      	$html.='<form class="" action="#" method="post" name="login_form" onsubmit="javascript: submit_form_login();return false;">';
		                            $html.='<p>';
		                              	$html.='<span class="txt_title">Email của bạn:</span>';
		                              	$html.='<input type="text" id="_log_email" name="_log_email" placeholder="Email của bạn" class="txt_input">';
		                            $html.='</p>';
		                            $html.='<p>';
		                              	$html.='<span class="txt_title">Mật khẩu:</span>';
		                              	$html.='<input type="password" id="_log_password" name="_log_password" placeholder="Nhập mật khẩu" class="txt_input">';
		                            $html.='</p>';
		                       		$html .='<p >';
			                          	$html.='<span class="txt_title">&nbsp;</span>';
		                              	$html .='<input type="submit"  class = "_btn_register" value="Đăng nhập" />';
			                        $html .='</p>';
			                        $html.='<input type="hidden" name = "module" value = "users" />';
				                    $html.='<input type="hidden" name = "view" value = "users" />';
				                    $html.='<input type="hidden" name = "task" value = "login_save" />';
		                      	$html.='</form>';                
		                    $html.='</div>';
		                    $html.='<div class="tab-pane active in" id="create">';
		               			$html.='<form action="'.FSRoute::_("index.php?module=users") .'" name="register_form" class="register_form" method="post" onsubmit="javascript: submit_form_register();return false;">';
			                      	$html.='<p>';
			                        	$html.='<span class="txt_title">Email của bạn:</span>';
		                              	$html.='<input type="text" id="_reg_email" name="_reg_email" value="" class="txt_input"  placeholder="Email của bạn">';
			                        $html.='</p>';
			                        $html.='<p>';
			                        	$html.='<span class="txt_title">Mật khẩu:</span>';
		                              	$html.='<input type=password id="_reg_password" name="_reg_password" value="" class="txt_input"  placeholder="Nhập mật khẩu">';
			                        $html.='</p>	';
			                        $html .='<p>';
			                        	$html.='<span class="txt_title">Nhập lại mật khẩu:</span>';
		                              	$html .='<input type=password id="_re_reg_password" name="_re_reg_password" value="" class="txt_input"  placeholder="Nhập lại mật khẩu">';
			                        $html .='</p>';
			                        $html.='<p>';
							    	    $html.='<span class="txt_title" style="padding:0;">&nbsp;</span>';
		                              	$html.='<input name="remember" type="checkbox" id="remember">&nbsp; Chấp nhận <a title="Điều khoản sử dụng" href="'.$config['dieu_khoan_sd'].'">Điều khoản sử dụng</a> của Maxmobile';
							    	$html.='</p>';
							    	$html .='<p>';
			                          	$html.='<span class="txt_title">&nbsp;</span>';
		                              	$html .='<input type="submit"  class = "_btn_register" value="Đăng ký" />';
			                        $html .='</p>';
									$html.='<input type="hidden" name = "module" value = "users" />';
				                    $html.='<input type="hidden" name = "view" value = "users" />';
				                    $html.='<input type="hidden" name = "task" value = "register_save" />';
		                      	$html.='</form>';
		                	$html.='</div>';
		                	  $html.='<p class="text-center">';
	                         	$html.='<span class="txt_title">&nbsp;</span>';
		                        $html.='<label>Hoặc kết nối với chúng tôi qua</label>';
								$html.='<a class="btn btn-primary social-login-btn social-facebook" href="'.FSRoute::_('index.php?module=users&view=face&task=face_login').'"><i class="fa fa-facebook"></i></a>';
								$html.='<a class="btn btn-primary social-login-btn social-google" href="'.URL_ROOT.'index.php?module=users&view=google&raw=1&task=google_login&Itemid=10'.'"><i class="fa fa-google-plus"></i></a>';
							$html.='</p>';
		            	$html .=' </div>';    
            		$html .=' </div>';
            	$html .=' </div>';
            $html .=' </div>';	
            echo $html;
    
		}

	function mlogin(){
		if(isset($_COOKIE['user_id'])){
			$link = FSRoute::_('index.php?module=users&task=logged&Itemid=37');
			setRedirect($link);
		}
		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Đăng nhập', 1 => '');
		global $tmpl;
		$tmpl -> assign('breadcrumbs', $breadcrumbs);
		include 'modules/'.$this->module.'/views/'.$this->view.'/mlogin.php';
	}
}
?>
