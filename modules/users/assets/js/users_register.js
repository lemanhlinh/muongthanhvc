$(document).ready( function(){
	turn_alert();
	check_exist_username();
	check_exist_email();
	$("select#country_id").change(function(){
		country_id = $(this).val();
		reload_location(country_id,'city','');
	});
	$("select#city_id").change(function(){
		city_id = $(this).val();
		reload_location(city_id,'district','');
	})	;
	$("select#district_id").change(function(){
		district_id = $(this).val();
		reload_location(district_id,'commune','');
	})	;
	
	/* REGISTER FORM */
//	$('#submitbt').click(function(){
//		if(checkFormsubmit())
//			document.register_form.submit();
//	})
	$('#use_estore').click(function(){
		if($(this).is(':checked'))
			$('#estore_register').show();
		else 
			$('#estore_register').hide();
	});
	
	/******* SITMAP relate *****/
	append_sitemap();
	remove_sitemap();
	
	/****** CHECK CAPTCHA ****/
	check_captcha();
	
	/****** Expert ******/
	check_address();
	show_hidden();
});
     
function checkFormsubmit()
{
	$('div.label_error').prev().remove();
	$('div.label_error').remove();
	if(!notEmpty("username","Bạn phải nhập tên truy nhập"))
		return false;
	if(!isUsername("username","Tên truy nhập chỉ gồm: chữ, số, kí tự '-' và '_'"))
		return false;
	if(!lengthMin("password",6,"Mật khẩu phải từ 6 kí tự trở lên"))
		return false;
	if(!checkMatchPass("Mật khẩu nhập lại không khớp"))
		return false;	
	if(!notEmpty("full_name","Nhập họ và tên đệm"))
		return false;	
//	if(!notEmpty("lname","Nhập tên"))
//		return false;	
	if(!notEmpty("email","Nhập email"))
		return false;	
	
	if(!emailValidator("email","Email không đúng định dạng"))
		return false;	
	if(!checkMatchEmail("Email không khớp"))
		return false;
	
	if(!notEmpty("mobilephone","Nhập số điện thoại di động"))
		return false;
	if(!isPhone("mobilephone","Số điện thoại di động chưa đúng"))
		return false;	
//	if(!notEmpty("telephone","Nhập số điện thoại cố định"))
//		return false;
//	if(!isPhone("telephone","Nhập số điện thoại cố định"))
//		return false;	
	if(!notEmpty("txtCaptcha","Bạn phải nhập mã hiển thị"))
		return false;
	
	return true;
}
function ismaxlength(obj,mlength){
	if (obj.getAttribute && obj.value.length>mlength)
		obj.value=obj.value.substring(0,mlength);
}
function turn_alert(){
	if($('.img-alert').length){
		$('.img-alert').hover(
				function(){
					$(this).next('span').show();
				},
				function(){
					$(this).next('span').hide();
				}
			);
		
		$('.img-alert')
	}
}

/* CHECK EXIST  USERNAME */
function check_exist_username(){
	$('#username').blur(function(){
		if($(this).val() != ''){
			$.ajax({url: root+"index.php?module=users&task=ajax_check_exist_username&raw=1",
				data: {username: $(this).val()},
				dataType: "text",
				success: function(result) {
					$('label.username_check').prev().remove();
					$('label.username_check').remove();
					if(result == 0){
						invalid('username','Tên truy nhập này đã tồn tại. Bạn hãy sử dụng tên truy cập khác');
					} else {
						valid('username');
						$('<div class=\'label_success username_check\'>'+'Tên truy nhập này được chấp nhận'+'</div>').insertAfter($('#username').parent().children(':last'));
					}
				}
			});
		}
	});
}
/* CHECK CAPTCHA AJAX */
function check_captcha(){
	$('#txtCaptcha').blur(function(){
		if($(this).val() != ''){
			$.ajax({url: root+"index.php?module=users&task=ajax_check_captcha&raw=1",
				data: {txtCaptcha: $(this).val()},
				dataType: "text",
				success: function(result) {
					$('label.username_check').prev().remove();
					$('label.username_check').remove();
					if(result == 0){
						invalid('txtCaptcha','Bạn nhập sai mã hiển thị');
					} else {
						valid('txtCaptcha');
						$('<br/><div class=\'label_success username_check\'>'+'Bạn đã nhập đúng mã hiển thị'+'</div>').insertAfter($('#username').parent().children(':last'));
					}
				}
			});
		}
	});
}

/* CHECK EXIST EMAIL  */
function check_exist_email(){
	$('#email').blur(function(){
		if($(this).val() != ''){
			if(!emailValidator("email","Email không đúng định dạng"))
				return false;
			$.ajax({url: root+"index.php?module=users&task=ajax_check_exist_email&raw=1",
				 data: {email: $(this).val()},
				  dataType: "text",
				  success: function(result) {
						$('label.email_check').prev().remove();
						$('label.email_check').remove();
					  if(result == 0){
						  invalid('email','Email này đã tồn tại. Bạn hãy sử dụng email khác');
					  } else {
						  valid('email');
						  $('<br/><div class=\'label_success username_check\'>'+'Email này được chấp nhận'+'</div>').insertAfter($('#email').parent().children(':last'));
					  }
				  }
			});
		}
	});
}
/*
 * Type: city, district, commune
 */
function reload_location(parent_value,type,prefix){
	$.ajax({url: root+"index.php?module=users&task=get_location_ajax&raw=1&type="+type,
		data: {cid: parent_value},
		dataType: "text",
		success: function(text) {
			if(text == '')
				return;
			j = eval("(" + text + ")");
			
			var options = '';
			for (var i = 0; i < j.length; i++) {
				options += '<option value="' + j[i].id + '">' + j[i].name + '</option>';
			}
			if(type == 'city'){
				$('#' + prefix + 'city_id').html(options);
				elemnent_fisrt = $('#' + prefix + 'city_id option:first').val();
				reload_location(elemnent_fisrt,'district',prefix);
			}else if(type == 'district'){
				$('#' + prefix + 'district_id').html(options);
				elemnent_fisrt = $('#' + prefix + 'district_id option:first').val();
				reload_location(elemnent_fisrt,'commune',prefix);
			}else if(type == 'commune'){
				$('#' + prefix + 'commune_id').html(options);
			}
		}
	});
}
function append_sitemap(){
	$('#append_field').click(function(){
		sitemap_count = $('#sitemap_count').val();
		if(sitemap_count < 5){
			$("#list_relate option:selected").each(function (index,domEle) {
				var value = $(this).val();
				var title = $(this).attr('rel');
				if(index < 5){
					if(!$('#'+value).length){
						$('#sitemap_count').attr('value',parseInt($('#sitemap_count').val())+1);
						$('#advance-hidden').append('<input type="hidden" name="arelate_select[]" class="'+value+'" value="'+value+'"/>');
						html_remove = '<div class="remove-selected" title="Bỏ chọn" lang="'+value+'">';
						html_remove += '<img src="'+root+'images/yteviet/icon-delete.jpg" alt="Bỏ chọn" title="Bỏ chọn" border="0" /> Xóa';
						html_remove += '</div>';
						$('#area_selected').append('<div id="'+value+'" class="sitemap_item_selected">'+title+html_remove+'</div>');
						remove_sitemap();
					}
				}
			});
		}
	});
}
function remove_sitemap(){
	$('.remove-selected').click(function(){
		var val = $(this).attr('lang');
		$('#'+val).remove();
		$('.'+val).remove();
		$('#sitemap_count').attr('value',parseInt($('#sitemap_count').val())-1);
	})
}
/*
 * Get list address_book 
 */
function check_address(){
	$('#check_address').click(function(){
		var key = $('#name_address').val();
		var register_type = $('#register_type').val();
		$.get(root+'index.php?module=users&task=ajax_get_address_book_by_key&key='+key+'&raw=1',function(response){
			$('#wrap-address-register').html(response);
			// Có kết quả load form chi tiết danh bạ
			load_address_book_by_id();
			reload_location_in_address_form();
			call_news_form_address_book();
			// Load Cascade quốc gia
		});
	});	
}
/*
 * Load Address book 
 */
function load_address_book_by_id(){
	$('.load_address').click(function(){
		var value = $(this).attr('lang');
		var address = value.split('|');
		var register_type = $('#register_type').val();
		$('#check_name_address').attr('value',address[1]);
		$.get(root+'index.php?module=users&task=ajax_load_address_book_by_id&id='+address[0]+'&raw=1',function(response){
			$('#load-address-book').html(response);
			enable_field_address();
			reload_location_in_address_form();
		});
		$('a.link-blue'+address[0]).css('color','#d66100');
	 });
}
function call_news_form_address_book(){
	$('#create_address').click(function(){
		$.get(root+'index.php?module=users&task=ajax_add_address_book_form&raw=1',function(response){
			$('#load-address-book').html(response);
			reload_location_in_address_form();
		});
	});
}
/*
 * Enable fields in address book form  
 */
function enable_field_address(){	
	$('.edit-field-address').click(function(){
		var value = $(this).attr('lang');
		var values = value.split('|');
		switch(values[1]){
			case 'certificate':
				$('.certificate-detail').css('background-color','#fff');
				$("input[id='certificate']").removeAttr('disabled');
			break;
			case 'object_service':
				$('.object-detail').css('background-color','#fff');
				$("input[id='object_service']").removeAttr('disabled');
			break;
			case 'lunch_break_to':
				$('.working-time select').removeAttr('disabled').css('background-color','#fff');
			break;
			default:
			$('#'+values[1]+values[0]).removeAttr('disabled').css('background-color','#fff');
			break;
		}          
	});
}
function reload_location_in_address_form(){
	$("select#address_country_id").change(function(){
		country_id = $(this).val();
		reload_location(country_id,'city','address_');
	});
	$("select#address_city_id").change(function(){
		city_id = $(this).val();
		reload_location(city_id,'district','address_');
	})	;
	$("select#address_district_id").change(function(){
		district_id = $(this).val();
		reload_location(district_id,'commune','address_');
	})	;
}
function show_hidden(){
	$('.show-hidden-register').click(function(){
		var stt = $(this).attr('lang');
		if($('#hidden-professional'+stt).css('display')=='block'){
			$('#hidden-professional'+stt).css('display','none');
			$(this).removeClass('bottom-collapse');
			$(this).addClass('bottom-expand');
		}else{
			$('#hidden-professional'+stt).css('display','block');
			$(this).removeClass('bottom-expand');
			$(this).addClass('bottom-collapse');
		}
	});
}