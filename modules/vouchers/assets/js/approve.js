$(document).ready(function () {
    $('#list_approve').DataTable({
        responsive: true,
        ordering: false,
        searching: false,
        lengthChange: false,
        "language": {
            "info": "Hiển thị _PAGE_ - _PAGES_ của _TOTAL_",
            paginate: {
                first:    '«',
                previous: '‹',
                next:     '›',
                last:     '»'
            },
        },
    });
})