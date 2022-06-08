
function submit_form_register() {
	var remember = $('#remember').val();
	$('label.label_error').prev().remove();
	$('label.label_error').remove();

	if(!notEmpty("_reg_email","Bạn phải Email")){
		return false;
	}
	if(!emailValidator("_reg_email","Email nhập không hợp lệ")){
		return false;
	}
	if(!notEmpty("_reg_password","Bạn phải nhập mật khẩu")){
		return false;
	}
	if(!checkMatchPass_2("_reg_password","_re_reg_password","Password bạn nhập không khớp")){
		return false;
	}
	if(!madeCheckbox("remember","Bạn chưa chấp nhận điều khoản")){
		return false;
	}
	document.register_form.submit();
	return true;
}
function submit_form_login() {
	var remember = $('#remember').val();
	$('label.label_error').prev().remove();
	$('label.label_error').remove();

	if(!notEmpty("_log_email","Bạn phải Email")){
		return false;
	}
	if(!emailValidator("_log_email","Email nhập không hợp lệ")){
		return false;
	}
	if(!notEmpty("_log_password","Bạn phải nhập mật khẩu")){
		return false;
	}
	
	document.login_form.submit();
	return true;
}


$('#_reg_email').blur(function(){
	alert(132);
	if($(this).val() != ''){
		if(!emailValidator("_reg_email","Email không đúng định dạng"))
			return false;
		$.ajax({
		type: "POST",	
		data: {reg_email: $('#_reg_email').val()},
		url: root+"index.php?module=users&task=ajax_check_exist_email&raw=1",
		success: function(result) {
			if(result == 0){
				invalid('_reg_email','Tên truy nhập này đã tồn tại. Bạn hãy sử dụng tên truy cập khác');
			} else {
				valid('_reg_email');
				$('<br/><div class=\'label_success email_check\'>'+'Email này được chấp nhận'+'</div>').insertAfter($('#_reg_email').parent().children(':last'));
			}
		}
	});
	}
});
