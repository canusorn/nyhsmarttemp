$(function () {

    $('input.timer').timepicker({
        interval: 60,
    });

    var table = $('#line-timer_table').DataTable({
        "ajax": "ajax/line-timer.php?id=" + esp_id + "&skey=" + sk,
        dom: 'tp',
        ordering: false,
        responsive: true,
        columnDefs: [
            {
            "render": function (data, type, row) {
                renderdata = '<a href="ajax/line-timer.php?id=' + esp_id + '&skey=' + sk + '&timer=' + row[0] + '&deltime=' + row[1] + '" class="btn btn-outline-danger btn-sm delete"><i class="fa-solid fa-trash-can"></i></a>';
                return renderdata;
            },
            "targets": -1
        },
    ],
    });

    // add timer
    $('#line-timer-form').submit(function (e) {

        e.preventDefault();

        var form = $(this);
        var actionUrl = form.attr('action');

        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(), // serializes the form's elements.
            success: function (data) {
                // alert(data); // show response from the php script.
                console.log(data);
                if (data == 1) {
                    table.ajax.reload(null, false);
                } else if (data == "duplicates") {
                    alert("ข้อมูลซ้ำ");
                }
            }
        });

    });

    // del timer
    $('#line-timer_table tbody').on('click', 'a.delete', function (e) {

        e.preventDefault();

        $.ajax({
            url: $(this).attr('href'),
            success: function (data) {
                // alert(data); // show response from the php script.
                console.log(data);
                if (data == 1) {
                    table.ajax.reload(null, false);
                } 
            }
        });

    });

});