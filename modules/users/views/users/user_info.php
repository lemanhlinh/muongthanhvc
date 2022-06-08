<?php 
    global $tmpl;
    $tmpl->setTitle("Thành viên");
    $tmpl -> addStylesheet("users_info","modules/users/assets/css");
    $tmpl -> addScript('form');
    $tmpl -> addScript('users_info','modules/users/assets/js');
?>  
<div class="row">
	<div class="menu_users col-lg-3">
		<div class="title_menu">
			<span>Tài khoản của tôi</span>
		</div>
		<ul class="">
        	<li class="menu-item">
            	<a class='logout exit' href="<?php echo FSRoute::_('index.php?module=users&task=user_info');?>">Thông tin tài khoản</a>
         	</li>
         	<li class="menu-item">
            	<a class='' href="<?php echo FSRoute::_('index.php?module=users&task=address_book');?>">Sổ địa chỉ</a>
       		</li>
        	<li class="menu-item">
            	<a class='' href="<?php echo FSRoute::_('index.php?module=products&view=order&task=status');?>">Tình trạng đơn hàng</a>
            </li>
            <li class="menu-item">
            	<a class='' href="<?php echo FSRoute::_('index.php?module=products&view=order');?>">Lịch sử giao dịch</a>
            </li>
            <li class="menu-item">
            	<a  href="<?php echo FSRoute::_('index.php?module=warranties&task=warrany');?>">Lịch sử bảo hành</a>
            </li>
            <!-- <li class="menu-item">
            	<a  href="<?php //echo FSRoute::_('index.php?module=users&task=commemts');?>">Danh sách bình luận</a>
            </li>
            <li class="menu-item">
           	 	<a class='' href="<?php //echo FSRoute::_('index.php?module=products&view=favourites');?>">Danh sách yêu thích</a>
          	</li> -->
            <li class="menu-item menu-item-last">
           		<a class='logout exit' href="<?php echo FSRoute::_('index.php?module=users&task=user_info');?>">Thoát</a>
            </li>
        </ul>
	</div>
	<div class="users_info col-lg-9">
		<h1><span>Chỉnh sửa thông tin các nhân</span></h1>
		
		<form id="form-user-edit" action="<?php echo FSRoute::_("index.php?module=users&task=edit_save&Itemid=40"); ?>" method="post" name="form-user-edit" enctype="multipart/form-data">
			<table width="100%" border="0" cellpadding="6">
				<tr>
			    	<td align="right" width="35%">Họ tên:&nbsp;&nbsp;</td>
			    	<td>
			    		<div class="select-box pull-left">
				    		<select name="sex">
				    			<option value="">Giới tính</option>
				    			<option value="male" <?php echo ($data->sex == 'male')?'selected':''?>>Anh</option>
				    			<option value="female" <?php echo ($data->sex == 'female' && $data->sex !='')?'selected':''?>>Chị</option>
				    		</select>
			    		</div>
			    		<input class="txt-input input-full-name" type="text" name="full_name" id="full_name" value="<?php echo $data->full_name;?>" />
			    		<div class="clearfix"></div>
			    	</td>
				</tr>
				<tr>
			    	<td align="right">Email:&nbsp;<font color="red">*</font></td>
				    <td>
				    	<input class="txt-input" type="text" name="email" id="email" value="<?php echo $data->email;?>" />
				    </td>
				</tr>
				<tr>
			    	<td align="right">Ngày sinh:&nbsp;&nbsp;</td>
			    	<td id="td-wapper-birthday">
			    		<div class="select-box pull-left">
				    		<select name="birth_day" >
				    			<option>Ngày</option>
				    			<?php for($i = 1;$i<=31;$i++){?>
				    				<option value="<?php echo $i?>" <?php echo (date("d",strtotime($data->birthday))==$i)?'selected':'';?>><?php echo $i?></option>
				    			<?php }?>
				    		</select>
			    		</div>
			    		<div class="select-box pull-left">
				    		<select  name="birth_month">
				    			<option>Tháng</option>
				    			<?php for($j = 1;$j<=12;$j++){?>
				    				<option value="<?php echo $j?>" <?php echo (date("m",strtotime($data->birthday))==$j)?'selected':'';?>><?php echo $j?></option>
				    			<?php }?>
				    		</select>
				    	</div>
				    	<div class="select-box pull-left">	
				    		<select name="birth_year">
				    			<option>Năm</option>
				    			<?php for($k = (date("Y")-13);$k>(date("Y")-70);$k--){?>
				    				<option value="<?php echo $k?>" <?php echo (date("Y",strtotime($data->birthday))==$k)?'selected':'';?>><?php echo $k?></option>
				    			<?php }?>
				    		</select>
			    		</div>
			    		<div class="clearfix"></div>
			    	</td>
				</tr>
				<!-- <tr>
					<td align="right" valign='top'>Ảnh đại điện&nbsp;&nbsp;</td>
					<td>
						<div class="avatar">
							<?php if(!@$data->avatar){?>
								<img alt="No avatar" src="<?php echo URL_ROOT.'images/no_avatar.gif'?>">
							<?php }else {?>
								<img alt="Avatar" src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $data->avatar);?>">
							<?php }?>
						</div>
						<input id="image" type="file" name="avatar">
					</td>
				</tr> -->
			 	<tr>
			 		<td>&nbsp;</td>
			    	<td>
			   	 		<input type="checkbox" name="edit_pass" id="edit_pass"/> 
			   	 		<font color="#0066AB">Thay đổi mật khẩu</font>
			   		</td>
				</tr>
				<tr class='password_area'>
					<td align="right">Nhập mật hiện tại&nbsp;&nbsp;</td>
					<td>
						<input class="txt-input"  type="password" name="old_password" id="old_password" value=""/>
					</td>
				</tr>
				<tr class='password_area'>
					<td align="right">Mật khẩu mới&nbsp;&nbsp;</td>
					<td>
						<input class="txt-input" type="password" name="password" id="password"  value=""/>
					</td>
				</tr>
				<tr class='password_area'>
					<td align="right">Xác nhận mật khẩu mới&nbsp;&nbsp;</td>
					<td><input class="txt-input" type="password" name="re-password" id="re-password" value="" /></td>
				</tr>
			  	<tr>
			 		<td>&nbsp;</td>
			  		<td class="button-submit-tr">
			    		<input class="button-submit-edit button" name="submit" type="submit" value="Lưu thông tin"  />
			       		<input class="button-reset-edit button" name="reset" type="reset" value="Nhập lại"   />
			    	</td>
			  	</tr>
			</table>
		</form>
	</div>
</div>	