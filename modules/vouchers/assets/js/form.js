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
})