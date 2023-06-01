$(document).ready(function () {

    $('#project-4-tab').text('Temperature');

    if (p_id == 4) {
        $('#chart_name').text('กราฟแสดงอุณหภูมิของอุปกรณ์จากเซ็นเซอร์ล่าสุด');

        $("#overview_option").click(function () {
            $('#chart_name').text('กราฟแสดงอุณหภูมิของอุปกรณ์จากเซ็นเซอร์ล่าสุด');
        });

        $("#history_option, #day_view").click(function () {
            $('#chart_name').text('กราฟแสดงอุณหภูมิของอุปกรณ์จากเซ็นเซอร์วันนี้เทียบกับเมื่อวาน');
        });

        $("#mouth_view").click(function () {
            $('#chart_name').text('กราฟแสดงอุณหภูมิของอุปกรณ์จากเซ็นเซอร์เฉลี่ยแต่ละวัน');
        });

        $("#history_view").click(function () {
            $('#chart_name').text('กราฟแสดงอุณหภูมิของอุปกรณ์จากเซ็นเซอร์ย้อนหลัง');

        });
    }


});