$(function(){
	$("select#city_id").change(function(){
	$.ajax({url: "index.php?module=users&task=district&raw=1",
			data: {cid: $(this).val()},
			dataType: "text",
			
			success: function(text) {
				if(text == '')
					return;
				j = eval("(" + text + ")");
				
				var options = '';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].id + '">' + j[i].name + '</option>';
				}
				$('#district_id').html(options);
				elemnent_fisrt = $('#district_id option:first').val();
			}
		});
	});
})