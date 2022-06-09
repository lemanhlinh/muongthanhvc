<?php
class FSSecurity
{
	function __construct()
	{
		
	}
	function checkLogin()
	{
		if(!isset($_COOKIE['username']))
		{
			$url = FSRoute::_("index.php?module=users&task=login");
			$msg = FSText :: _("Bạn phải đăng nhập để sử dụng tính năng này");
			setRedirect($url,$msg,'error');
		}
		else 
			return true;
	}
}