<?php 
	global $tmpl;
	$tmpl->setTitle("&#272;&#259;ng nh&#7853;p");
	$tmpl -> addStylesheet("users_login","modules/users/assets/css");
	$Itemid = FSInput::get('Itemid',1);
	$redirect = FSInput::get('redirect');
?>	
<div id="login-form" class ="frame_large" >
    <div class="frame_auto_head">
		<div class="frame_auto_head_l">
			<h1>Đăng nhập</h1>
		</div>
		<div class="frame_auto_head_inner"></div>
		<div class="frame_auto_head_r"></div>
	</div>
    <div class="frame_auto_body">
           
            <!--   FRAME COLOR        -->
            <div class='frame_color'>
               
                    <!--  CONTENT IN FRAME      -->
		           <form action="<?php echo FSRoute::_("index.php?module=users") ?>" name="login_form" class="login_form" method="post">
		               <table cellpadding="5" >
		                    <tr>
		                        <td  valign="top"><label><?php echo FSText::_("Tên truy cập")?> :</label></td>
		                        <td> <input class="txtinput" type="text" name="username"    /> 
		                        </td>
		                    </tr>
		                    <tr>
		                        <td class="label"> <label> <?php echo FSText::_("Mật khẩu")?></label></td>
		                        <td> <input  class="txtinput" type="password" name="password"    /> 
		                        </td>
		                    </tr>
		                    <tr>
		                        <td> </td>
		                        <td> <input type="submit" class='submitbt' name="submitbt" value = "<?php echo FSText::_("&#272;&#259;ng nh&#7853;p");?>"   /> </td>
		                    </tr>
		                    <tr>
		                        <td> </td>
		                        <td> <a href="<?php echo FSRoute::_("index.php?module=users&task=forget&Itemid=156");?>" ><?php echo FSText::_("Qu&#234;n m&#7853;t kh&#7849;u")?></a></td>
		                    </tr>
		                    <tr>
		                        <td> </td>
		                        <td> <a class="button2" href="<?php echo FSRoute::_("index.php?module=users&task=register&Itemid=39"); ?>">
		                                    <span><?php echo FSText::_("&#272;&#259;ng k&#253; th&#224;nh vi&#234;n"); ?></span>
		                                </a></td>
		                    </tr>
		                </table>
		                <input type="hidden" name = "module" value = "users" />
		                <input type="hidden" name = "view" value = "users" />
		                <input type="hidden" name = "task" value = "login_save" />
		                <input type="hidden" name = "Itemid" value = "<?php echo $Itemid;?>" />
		                <?php if($redirect)
		                    echo "<input type='hidden' name = 'redirect' value = '$redirect' />";  
		                ?>
		            </form> 
		            
		            <!--    RIGHT       -->
		            <div class='person_info'>
		                 <?php echo $config_person_login_info; ?>
		            </div>
		            
		           <!--  end CONTENT IN FRAME      -->
                              
            </div>
            <!--   end FRAME COLOR        -->
            
    </div>
   	<div class="frame_auto_footer">
		<div class="frame_footer_left">&nbsp;</div>
		<div class="frame_footer_right">&nbsp;</div>
	</div>
</div>    
		
		