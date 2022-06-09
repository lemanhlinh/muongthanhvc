$(document).ready(function() {
    $('#date_release').datetimepicker({
        format: 'L'
    });
    $('#time_start').datetimepicker({
        format: 'L'
    });
    $('#time_end').datetimepicker({
        format: 'L'
    });
    $('.select2').select2();

    $(".card-body input[name=type_voucher]").map(function(){
        $('#type_voucher'+$(this).val()).click(function(e){
            $.ajax({
                type: "POST",
                data: {type_voucher: $(this).val()},
                url: "index.php?module=vouchers&view=vouchers&task=load_sample_voucher&raw=1",
                success : function(data){
                    var data = JSON.parse(data);
                    $("#voucher_for_type").html(data.html);
                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    alert('There is an error in the process of bringing up the server. Would you please check the connection.');
                }
            });
        })
    });
})
