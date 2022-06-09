<?php 
    global $tmpl;
    $tmpl->addTitle("Quên mật khẩu");
    $tmpl -> addStylesheet("users_forget","modules/users/assets/css");
    $Itemid = FSInput::get('Itemid',1);
    $redirect = FSInput::get('redirect');
?>  
<div id="login-form" class ="frame_large" >
    <div class="frame_auto_head">
		<div class="frame_auto_head_l">
			<h1>Quên mật khẩu</h1>
		</div>
		<div class="frame_auto_head_inner"></div>
		<div class="frame_auto_head_r"></div>
	</div>
    <div class="frame_auto_body">
           
            <!--   FRAME COLOR        -->
                    
                    <!--  CONTENT IN FRAME      -->
                   <form action="<?php echo FSRoute::_("index.php?module=users") ?>" name="forget_form" class="forget_form" method="post">
                       <table cellpadding="5" >
			                <tr>
			                    <td colspan="2"><span>Vui l&#242;ng nh&#7853;p e-mail c&#7911;a b&#7841;n khi &#273;&#259;ng k&#237; th&#224;nh vi&#234;n. Ch&#250;ng t&#244;i s&#7869; ki&#7875;m tra v&#224; g&#7917;i l&#7841;i m&#7853;t kh&#7849;u cho b&#7841;n v&#224;o e-mail &#273;&#243;.</span></td>
			                </tr>
			                <tr>
			                    <td class="label" width="120"><?php echo FSText::_("Email")?></td>
			                    <td class='value' width="183"> <input class="txtinput" type="text" name="email"    /> </td>
			                    
			                </tr>
			                
			                <tr>
			                    <td class='label'><?php echo FSText::_("Nh&#7853;p m&atilde; hi&#7875;n th&#7883;"); ?></td>
			                    <td class='value'>
				                    <input type="text"  id="txtCaptcha" value="" name="txtCaptcha"  maxlength="10" size="7" />
	                                <a href="javascript:changeCaptcha();"  title="Click here to change the captcha" class="code-view" />
	                                    <img id="imgCaptcha" src="<?php echo URL_ROOT?>libraries/jquery/ajax_captcha/create_image.php" />
	                                </a>
			                    </td>
			                </tr>
			                <tr>
			                    <td> </td>
			                    <td> <input type="submit" class='submitbt' name="submitbt" value = "<?php echo FSText::_("&#272;&#7891;ng &#253;");?>"   /> </td>
			                </tr>
			            </table>
                       <input type="hidden" name = "module" value = "users" />
                       <input type="hidden" name = "view" value = "users" />
                       <input type="hidden" name = "task" value = "forget_save" />
                    </form> 
                    
                    <!--    RIGHT       -->
                    <div class='person_info'>
                         <?php echo $config_person_forget; ?>
                    </div>
                    
                   <!--  end CONTENT IN FRAME      -->
           
            </div>
            <!--   end FRAME COLOR        -->
    <div class="frame_auto_body">
		<div class="frame_footer_left">&nbsp;</div>
		<div class="frame_footer_right">&nbsp;</div>
	</div>
</div>    
