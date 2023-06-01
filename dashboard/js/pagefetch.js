$(function () {

    $('#project-0-tab').click(function (e) {

        e.preventDefault();

        $.ajax({
            url: "ajax/get-project.php",
            type: 'post',
            data: {
                id: esp_id,
                skey: sk,
                p_id: 0
            },
            success: function (data) {
                // console.log(data);
                $("#body-content").html(data);
                window.history.pushState("Details", "Title", "/dashboard/device.php?id=" + esp_id + "&project=0");
                $("#project-tab > li > a").removeClass("active");
                $('#project-0-tab').addClass("active");
            }
        });
    });

    $('#project-1-tab').click(function (e) {

        e.preventDefault();

        $.ajax({
            url: "ajax/get-project.php?v=" + version,
            type: 'post',
            data: {
                id: esp_id,
                skey: sk,
                p_id: 1
            },
            success: function (data) {
                // console.log(data);
                $("#body-content").html(data);
                window.history.pushState("Details", "Title", "/dashboard/device.php?id=" + esp_id + "&project=1");
                $("#project-tab > li > a").removeClass("active");
                $('#project-1-tab').addClass("active");
            }
        });
    });

    $('#project-2-tab').click(function (e) {

        e.preventDefault();

        $.ajax({
            url: "ajax/get-project.php?v=" + version,
            type: 'post',
            data: {
                id: esp_id,
                skey: sk,
                p_id: 2
            },
            success: function (data) {
                // console.log(data);
                $("#body-content").html(data);
                window.history.pushState("Details", "Title", "/dashboard/device.php?id=" + esp_id + "&project=2");
                $("#project-tab > li > a").removeClass("active");
                $('#project-2-tab').addClass("active");
            }
        });
    });

    $('#project-3-tab').click(function (e) {

        e.preventDefault();

        $.ajax({
            url: "ajax/get-project.php?v=" + version,
            type: 'post',
            data: {
                id: esp_id,
                skey: sk,
                p_id: 3
            },
            success: function (data) {
                // console.log(data);
                $("#body-content").html(data);
                window.history.pushState("Details", "Title", "/dashboard/device.php?id=" + esp_id + "&project=3");
                $("#project-tab > li > a").removeClass("active");
                $('#project-3-tab').addClass("active");
            }
        });
    });

    $('#project-4-tab').click(function (e) {

        e.preventDefault();

        $.ajax({
            url: "ajax/get-project.php?v=" + version,
            type: 'post',
            data: {
                id: esp_id,
                skey: sk,
                p_id: 4
            },
            success: function (data) {
                // console.log(data);
                $("#body-content").html(data);
                window.history.pushState("Details", "Title", "/dashboard/device.php?id=" + esp_id + "&project=4");
                $("#project-tab > li > a").removeClass("active");
                $('#project-4-tab').addClass("active");
            }
        });
    });

    $('#project-5-tab').click(function (e) {

        e.preventDefault();

        $.ajax({
            url: "ajax/get-project.php?v=" + version,
            type: 'post',
            data: {
                id: esp_id,
                skey: sk,
                p_id: 5
            },
            success: function (data) {
                // console.log(data);
                $("#body-content").html(data);
                window.history.pushState("Details", "Title", "/dashboard/device.php?id=" + esp_id + "&project=5");
                $("#project-tab > li > a").removeClass("active");
                $('#project-5-tab').addClass("active");
            }
        });
    });

    $('#project-6-tab').click(function (e) {

        e.preventDefault();

        $.ajax({
            url: "ajax/get-project.php?v=" + version,
            type: 'post',
            data: {
                id: esp_id,
                skey: sk,
                p_id: 6
            },
            success: function (data) {
                // console.log(data);
                $("#body-content").html(data);
                window.history.pushState("Details", "Title", "/dashboard/device.php?id=" + esp_id + "&project=6");
                $("#project-tab > li > a").removeClass("active");
                $('#project-6-tab').addClass("active");
            }
        });
    });

    $('#pin-tab').click(function (e) {

        e.preventDefault();

        $.ajax({
            url: "ajax/get-pin.php",
            type: 'post',
            data: {
                id: esp_id,
                skey: sk
            },
            success: function (data) {
                // console.log(data);
                $("#body-content").html(data);
                window.history.pushState("Details", "Title", "/dashboard/device.php?id=" + esp_id + "&p=pin");
                $("#project-tab > li > a").removeClass("active");
                $('#pin-tab').addClass("active");
            }
        });

    });

});