<script src="<?php echo URL_ROOT.'modules/users/assets/js/users_edit.js'; ?>" type="text/javascript" language="javascript" ></script>
<form id="form-user-edit" action="<?php echo FSRoute::_("index.php?module=users&task=edit_save&Itemid=40"); ?>" method="post" name="form-user-edit">
	<table width="100%" border="0">
  <tr class="tr-001">
    <td width="21%">Tên tài khoản</td>
    <td width="65%"><input disabled="disabled" type="text" name="username" id="username" value="<?php echo $data->username;?>" /></td>
    <td width="14%"></td>
  </tr>
   <tr class="tr-002">
    <td>Email</td>
    <td>
    	<input disabled="disabled" type="text" name="email" id="email" value="<?php echo $data->email;?>" />
    </td>
    <td></td>
  </tr>
  <tr class="tr-002">
    <td>Họ &amp; tên</td>
    <td><input disabled="disabled" type="text" name="full_name" id="full_name" value="<?php echo $data->full_name;?>" /></td>
    <td><img class="edit-icon" src="<?php echo URL_ROOT.'images/edit-icon.png';?>" alt="Sửa thông tin" /><a class="edit-user-info" lang="full_name" title="Sửa thông tin">Sửa thông tin</a></td>
  </tr>
  <tr class="tr-001">
    <td>Ngày sinh</td>
    <td id="td-wapper-birthday"><input disabled="disabled" type="text" name="birthday" id="birthday" value="<?php echo date("d/m/Y",strtotime($data->birthday) );?>" />
    	<input type="hidden" name="birth_day" value="<?php echo date("d",strtotime($data->birthday) );?>" id = "birth_day"/>
    	<input type="hidden" name="birth_month" value="<?php echo date("m",strtotime($data->birthday) );?>" id = "birth_month"/>
    	<input type="hidden" name="birth_year" value="<?php echo date("Y",strtotime($data->birthday) );?>" id = "birth_year"/>
    </td>
    
    <td><img class="edit-icon" src="<?php echo URL_ROOT.'images/edit-icon.png';?>" alt="Sửa thông tin" /><a class="edit-user-info" lang="birthday" title="Sửa thông tin">Sửa thông tin</a></td>
  </tr>
  <tr class="tr-002">
    <td>Nghề nghiệp</td>
    <td><input disabled="disabled" type="text" name="job" id="job" value="<?php echo $data->job;?>" /></td>
    <td><img class="edit-icon" src="<?php echo URL_ROOT.'images/edit-icon.png';?>" alt="Sửa thông tin" /><a class="edit-user-info" lang="job" title="Sửa thông tin">Sửa thông tin</a></td>
  </tr>
  <tr class="tr-001">
    <td>Địa chỉ</td>
    <td><input disabled="disabled" type="text" name="address" id="address" value="<?php echo $data->address;?>" /></td>
    <td><img class="edit-icon" src="<?php echo URL_ROOT.'images/edit-icon.png';?>" alt="Sửa thông tin" /><a class="edit-user-info" lang="address" title="Sửa thông tin">Sửa thông tin</a></td>
  </tr>
  <tr class="tr-001">
    <td>Điện thoại</td>
    <td><input disabled="disabled" type="text" name="mobilephone" id="mobilephone" value="<?php echo $data->mobilephone;?>" /></td>
    <td><img class="edit-icon" src="<?php echo URL_ROOT.'images/edit-icon.png';?>" alt="Sửa thông tin" /><a class="edit-user-info" lang="mobilephone" title="Sửa thông tin">Sửa thông tin</a></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
  	<td class="button-submit-tr">
    	<input class="button-submit-edit button" name="submit" type="submit" value="Lưu"  />
        <input class="button-reset-edit button" name="reset" type="reset" value="Hủy bỏ"   />
    </td>
  </tr>
</table>

</form>