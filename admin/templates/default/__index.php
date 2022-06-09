<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>CMS - FinalStyle</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="copyright" content="© 2013 FinalStyle, Thiết kế website Phong Cách Số" /> 
    <meta name="robots" content="noindex, nofollow"/>
    <link rel="shortcut icon" href="templates/default/images/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="templates/default/css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="templates/default/css/templates.css"/>
    <!--[if gte IE]>
        <link rel="stylesheet" type="text/css" href="templates/default/css/ie.css"/>
    <![endif]-->
    <script type="text/javascript" src="templates/default/js/jquery-1.9.0.min.js"></script>
    <script type="text/javascript" src="templates/default/js/helper.js"></script>
    <script type="text/javascript" src="<?php echo URL_ROOT; ?>libraries/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?php echo URL_ROOT; ?>libraries/ckeditor/plugins/ckfinder/ckfinder.js"></script>
</head>
<body>
    <div id="wrapper">
        <div id="sidebar" class="fl">
            <div id="admin-info">
                <div class="avatar fl">
                    <img src="templates/default/images/logo/admin.png" />
                </div><!--end: .avatar-->
                <div class="info fr">
                    <div class="lang">
                	<?php
                		//$language = $_SESSION['ad_lang'];
//						$url_current  = $_SERVER['REQUEST_URI'];
//						$sort_admin = $_SERVER['SCRIPT_NAME'];
//						$sort_admin = str_replace('/index.php','',$sort_admin);
//						$pos = strripos($sort_admin,'/');
//						$sort_admin = substr($sort_admin,($pos+1));
//						$url_current = substr($url_current,strlen(URL_ROOT_REDUCE));
//						$url_current =  trim(preg_replace('/[&?]ad_lang=[a-z]+/i', '', $url_current));
////						echo $url_current;
//						function create_url_for_lang($url,$lang,$sort_admin){
//							if(!$url)
//								return URL_ROOT.$sort_admin.'/index.php?ad_lang='.$lang;
//							if(strpos($url, 'index.php') === false)
//								return URL_ROOT.$sort_admin.'/index.php?ad_lang='.$lang;
//							if(substr($url,-9) == 'index.php')
//								return URL_ROOT.$sort_admin.'/index.php?ad_lang='.$lang;
//							if($url == 'index.php')
//								return URL_ROOT.$sort_admin.'index.php?ad_lang='.$lang;
//							return URL_ROOT.$url.'&ad_lang='.$lang;
//						}
//						$lang_arr = array('en'=>'English','vi'=>'Viet Nam');
//						foreach ($lang_arr as $key => $value){
//							$class = $key;
//							$class .= ($key == $language)?' current ':'';
//							echo "<a href='". create_url_for_lang($url_current,$key,$sort_admin)."' class='".$class."' title='".$value."' ><img src='".URL_ROOT.$folder_admin.'/templates/default/images/'.$key.".jpg' alt='".$value."' /></a>";
//						}
                	?>

                    </div><!--end: .lang-->
                    
                    <div class="tool">
                       <span class="name"><?php echo $_SESSION['ad_username']; ?></span>
                        <span>|</span>
                        <a href="index.php?module=users&view=log&task=logout" title="Logout" >Logout</a>
                    </div><!--end: .tool-->
                </div><!--end: .info-->
            </div><!--end: #admin-info-->
            <div id="menu-bar">
                <?php require('modules/menus/admin.php');?>
            </div><!--end: #menu-bar-->
            <div id="menu-author">
                <div class="bound">
                    <a href="#"><span>Tin dịch vụ</span></a>
                    <a href="#"><span>Gửi yêu cầu</span></a>
                    <div class="clearfix"></div>
                </div><!--end: .bound-->
            </div><!--end: #menu-author-->
            <div class="clearfix"></div>
        </div><!--end: #sidebar-->
        <div id="wrap-content">
            <div id="box-content">
                <?php 
        		global $toolbar;
        		echo $toolbar->show_head_form();
                echo $main_content; 
                ?>
                <div class="clearfix"></div>
            </div><!--end: #box-content-->
            
            <div class="clearfix"></div>
        </div><!--end: #wrap-content-->
        <div class="clearfix"></div>
    </div><!--end: #wrapper-->
    <div id="footer">
    </div><!--end: #footer-->
    
    <div id="wrapper">
        
    </div><!-- END: #wrapper -->
</body>		
</html>


