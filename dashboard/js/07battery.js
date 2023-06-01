$(document).ready(function () {

    //last data
    var volt = [],
        curr = [],
        power = [],
        energy = [],
        label = [],
        volt2 = [],
        curr2 = [],
        power2 = [],
        energy2 = [],
        label = [];
    var min_e1 = 0,min_e2 = 0;
    var lastupdate;

    // today and yesterday
    var power_1 = [],
        power_2 = [],
        label_day = [];

    // this mouth and last month
    var energy_mouth = [],
        energy_mouth2 = [],
        label_mouth = [];

    // custom history range
    var volt_history = [],
        curr_history = [],
        power_history = [],
        energy_history = [],
        volt_history2 = [],
        curr_history2 = [],
        power_history2 = [],
        energy_history2 = [],
        label_history = [],
        label_timestamp = [],
        uplot;

    // for device setting
    var setting;
    var online_state;

    var Chart_1, Chart_history;
    displayChart();
    getLastData();

    $("#uplot").hide();
    $("#google_table").hide();
    $(".setting-page").hide();
    $("#Charthistory").hide();
    $("#range_display").hide();
    $(".history_view_class").hide();
    $(".history_option_class").hide();
    $("#ota-form").hide();

    // bootstrap tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    // display empty chart
    function displayChart() {

        // for display chart axis and legend
        function axiscontrol(e, legendItem, legend) {
            const index = legendItem.datasetIndex;
            const ci = legend.chart;
            const scale = ci.data.datasets[index].yAxisID;
            // console.log(scale);
            if (ci.isDatasetVisible(index)) {
                ci.hide(index);
                ci.options.scales[scale].display = false;
                legendItem.hidden = true;
            } else {
                ci.show(index);
                ci.options.scales[scale].display = true;
                legendItem.hidden = false;
            }
            ci.update();
        };

        Chart_1 = new Chart(
            document.getElementById('Chart_1'), {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Voltage',
                    data: [],
                    yAxisID: 'yv',
                    tension: 0.1,
                    backgroundColor: 'rgba(210, 214, 222, 0.3)',
                    borderColor: 'rgba(210, 214, 222, 1)', fill: true,
                    pointColor: 'rgba(210, 214, 222, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    pointRadius: 0.5,
                    hidden: true
                }, {
                    label: 'Current',
                    data: [],
                    yAxisID: 'yi',
                    tension: 0.1,
                    backgroundColor: '#f05d2380',
                    borderColor: '#f05d23',
                    fill: true,
                    pointColor: '#f05d23',
                    pointStrokeColor: '#f05d23',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: '#f05d23',
                    pointRadius: 0.5,
                    hidden: true
                }, {
                    label: 'Power',
                    data: [],
                    yAxisID: 'yp',
                    tension: 0.1,
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    pointRadius: 0.5,
                }, {
                    label: 'Energy',
                    data: [],
                    yAxisID: 'ye',
                    tension: 0.1,
                    backgroundColor: '#b643cd80',
                    borderColor: '#b643cd',
                    fill: true,
                    pointColor: '#b643cd',
                    pointStrokeColor: '#b643cd',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: '#b643cd',
                    pointRadius: 0.5,
                    hidden: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                },
                plugins: {
                    legend: {
                        display: true,
                        onClick: axiscontrol
                    },
                    zoom: {
                        zoom: {
                            wheel: {
                                enabled: true,
                            },
                            pinch: {
                                enabled: true
                            },
                            // drag: {
                            //     enabled: true
                            // },
                            mode: 'x',
                        }, pan: {
                            enabled: true,
                            mode: 'x',
                        },
                        limits: {
                            x: { min: 'original', max: 'original' },
                        }
                    }
                },
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'minute'
                        },
                        title: {
                            display: true,
                            text: "เวลา",
                        }
                        // ticks: {
                        //     source: 'auto',
                        //     autoSkip: true,
                        // },
                    },
                    yp: {
                        display: true,
                        title: {
                            display: true,
                            text: "Power",
                        },

                        type: 'linear',
                        position: 'left',
                    },
                    yv: {
                        display: true,
                        title: {
                            display: true,
                            text: "Volt",
                        },

                        type: 'linear',
                        position: 'left',
                    }
                    ,
                    yi: {
                        display: true,
                        title: {
                            display: true,
                            text: "Current",
                        },
                        type: 'linear',
                        position: 'right',

                    },
                    ye: {
                        display: true,
                        title: {
                            display: true,
                            text: "Energy",
                        },
                        type: 'linear',
                        position: 'right',

                    }
                }
            }
        });


        Chart_history = new Chart(
            document.getElementById('Chart_history'), {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Today',
                    data: [],
                    tension: 0.1,
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    // pointRadius: 0.5,
                }, {
                    label: 'Lastday',
                    data: [],
                    tension: 0.1, backgroundColor: 'rgba(210, 214, 222, 0.3)',
                    borderColor: 'rgba(210, 214, 222, 1)', fill: true,
                    pointColor: 'rgba(210, 214, 222, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    // pointRadius: 0.5,
                },]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                },
                plugins: {
                    legend: {
                        display: true,
                    },
                    zoom: {
                        zoom: {
                            wheel: {
                                enabled: true,
                                speed: 0.5,
                            },
                            pinch: {
                                enabled: true
                            },
                            // drag: {
                            //     enabled: true
                            // },
                            mode: 'x',
                        }, pan: {
                            enabled: true,
                            mode: 'x',
                        }
                    }

                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: "เวลา",
                        }
                    },
                    y: {
                        display: true,
                        beginAtZero: false,
                    },
                },
                spanGaps: true, // enable for all datasets
                datasets: {
                    line: {
                        pointRadius: 0 // disable for all `'line'` datasets
                    }
                },
                elements: {
                    point: {
                        radius: 0 // default to disabled in all datasets
                    }
                }
            }
        });

    }

    function overlayNodata() {
        $(".overlay").show();
        $(".overlay .svg-inline--fa").hide();
        $(".overlay h3").text("ไม่มีข้อมูล");
    }

    //second data
    function getLastData() {
        $(".overlay").show();

        $.ajax({
            url: "ajax/7.php",
            type: "post",
            data: {
                id: esp_id,
                skey: sk,
                data: "sec",
                point: 200
            },
            success: function (data) {
                if (data == "nodata") {
                    overlayNodata();
                    return;
                }
                // console.log(data);
                try {
                    var json = JSON.parse(data);

                    json.voltage.reverse();
                    json.current.reverse();
                    json.power.reverse();
                    json.energy.reverse();
                    json.voltage2.reverse();
                    json.current2.reverse();
                    json.power2.reverse();
                    json.energy2.reverse();
                    json.time.reverse();

                    volt = json.voltage;
                    curr = json.current;
                    power = json.power;

                    min_e1 = parseFloat(json.min_energy1).toFixed(3);
                    if (isNaN(min_e1)) { min_e1 = parseFloat(json.energy[0]); }

                    for (var count = 0; count < json.energy.length; count++) {
                        energy.push(parseFloat(json.energy[count]) - min_e1);
                    }

                    volt2 = json.voltage2;
                    curr2 = json.current2;
                    power2 = json.power2;

                    min_e2 = parseFloat(json.min_energy2).toFixed(3);
                    if (isNaN(min_e2)) { min_e2 = parseFloat(json.energy2[0]); }
                    // console.log(energy);

                    for (var count = 0; count < json.energy2.length; count++) {
                        energy2.push(parseFloat(json.energy2[count]) - min_e2);
                    }

                    label = json.time;

                    lastupdate = json.lastupdate;
                    updateStatus();

                    $("#voltage").html(json.voltage[json.voltage.length - 1]);
                    $("#current").html(json.current[json.current.length - 1]);
                    $("#power").html(json.power[json.power.length - 1]);
                    $("#energy").html((parseFloat(json.energy[json.energy.length - 1]) - min_e1).toFixed(3));

                    $("#voltage2").html(json.voltage2[json.voltage2.length - 1]);
                    $("#current2").html(json.current2[json.current2.length - 1]);
                    $("#power2").html(json.power2[json.power2.length - 1]);
                    $("#energy2").html((parseFloat(json.energy2[json.energy2.length - 1]) - min_e2).toFixed(3));

                    $("#time").html(json.time[json.time.length - 1]);

                    Chart_1.options.scales['yv'].display = false;
                    Chart_1.options.scales['yi'].display = false;
                    Chart_1.options.scales['ye'].display = false;

                    Chart_1.data.datasets[0].data = volt;
                    Chart_1.data.datasets[0].label = 'Volt';

                    let _curr = [];
                    for (var count = 0; count < curr.length; count++) {
                        _curr.push(parseFloat(curr[count]) - parseFloat(curr2[count]));
                    }
                    curr = _curr;
                    Chart_1.data.datasets[1].data = curr;
                    Chart_1.data.datasets[1].label = 'Current';

                    Chart_1.data.datasets[2].data = power;
                    Chart_1.data.datasets[2].label = 'Power';

                    Chart_1.data.datasets[3].data = energy;
                    Chart_1.data.datasets[3].label = 'Energy';
                    Chart_1.data.labels = label;
                    Chart_1.update();

                    $(".overlay").fadeOut(100);
                    setInterval(updateLastData, 30000); // 1000 = 1 second
                    setInterval(updateStatus, 30000); // 1000 = 1 second
                }
                catch (err) {
                    // console.log(err.message);
                    overlayNodata();
                }
            },
            error: function () {
                overlayNodata();
            }
        })
    };

    function updateStatus() {
        // console.log(moment().format('MMMM Do YYYY, h:mm:ss a'));
        let now = moment().format('YYYY-MM-DD HH:mm:ss');
        let lastupdatemoment = moment(lastupdate, 'YYYY-MM-DD HH:mm:ss');
        let secdiff = moment(now, 'YYYY-MM-DD HH:mm:ss').diff(lastupdatemoment, 'seconds');

        // console.log(secdiff);

        if (isNaN(secdiff) || secdiff >= 60) {
            $("#device_status").html("offline");
            $("#device_status").removeClass('badge-success').addClass('badge-secondary');
            online_state = 0;
        }
        else {
            $("#device_status").html("online");
            $("#device_status").removeClass('badge-secondary').addClass('badge-success');
            online_state = 1;
        }
    }

    function updateLastData() {
        $.ajax({
            url: "ajax/7.php",
            type: "post",
            data: {
                id: esp_id,
                skey: sk,
                data: "sec",
                point: 1
            },
            success: function (data) {
                // console.log(data);
                var json = JSON.parse(data);
                let fulltime = json.time[0];

                if (label[label.length - 1] != fulltime) {

                    if (label.length > 1000) {
                        label.shift();
                        volt.shift();
                        curr.shift();
                        power.shift();
                        energy.shift();
                    }

                    volt.push(json.voltage[0]);
                    curr.push(parseFloat(json.current[0]) - parseFloat(json.current2[0]));
                    power.push(json.power[0]);
                    energy.push(parseFloat(json.energy[0]) - min_e1);
                    volt2.push(json.voltage2[0]);
                    curr2.push(json.current2[0]);
                    power2.push(json.power2[0]);
                    energy2.push(parseFloat(json.energy2[0]) - min_e2);
                    label.push(json.time[0]);

                    // console.log(json.power[0]);
                    // console.log(timesplit[1]);

                    $("#voltage").html(json.voltage[0]);
                    $("#current").html(json.current[0]);
                    $("#power").html(json.power[0]);
                    $("#energy").html((parseFloat(json.energy[0]) - min_e1).toFixed(3));
                    $("#voltage2").html(json.voltage2[0]);
                    $("#current2").html(json.current2[0]);
                    $("#power2").html(json.power2[0]);
                    $("#energy2").html((parseFloat(json.energy2[0]) - min_e2).toFixed(3));
                    $("#time").html(json.time[0]);

                    Chart_1.update();
                }
                lastupdate = json.lastupdate;
            }
        })
    };

    // for tab select
    $("#overview_option").click(function () {

        $("#value").show();
        $("#io").show();
        $("#chart").show();
        $("#uplot").hide();
        $("#google_table").hide();
        $(".setting-page").hide();
        $('#chart_name').text('Power [watt] & Voltage [v]');
        $("#Charthistory").hide();
        $("#Chart1").show();
        $("#range_display").hide();
        $(".history_view_class").hide();
        $(".history_option_class").hide();

        if (label.length) $(".overlay").hide();
        else overlayNodata();

        Chart_1.resetZoom();

        Chart_1.data.datasets[0].data = [];
        Chart_1.data.datasets[1].data = [];
        Chart_1.data.datasets[2].data = [];
        Chart_1.data.datasets[3].data = [];
        Chart_1.update();

        Chart_1.data.datasets[0].data = volt;
        Chart_1.data.datasets[0].label = 'Volt';
        Chart_1.data.datasets[1].data = curr;
        Chart_1.data.datasets[1].label = 'Current';
        Chart_1.data.datasets[2].data = power;
        Chart_1.data.datasets[2].label = 'Power';
        Chart_1.data.datasets[3].data = energy;
        Chart_1.data.datasets[3].label = 'Energy';
        Chart_1.data.labels = label;
        Chart_1.update();


    });

    // for tab select
    $("#history_option, #day_view").click(function () {

        $("#value").hide();
        $("#io").hide();
        $("#chart").show();
        $("#uplot").hide();
        $("#google_table").hide();
        $(".setting-page").hide();
        $("#Charthistory").show();
        $("#Chart1").hide();
        $("#range_display").show();
        $(".history_option_class").show();
        $(".history_view_class").hide();

        $("#day_view").addClass("active");
        $("#mouth_view,#history_view").removeClass("active");

        $('#chart_name').text('ค่ากำลังไฟฟ้าของวันนี้ vs เมื่อวาน [watt]');

        Chart_history.resetZoom();
        Chart_history.options.scales['x'].title.text = "เวลา";
        // alert('today vs yesterday');
        if (label_day.length == 0) { // if empty array let get new

            $(".overlay").show();

            $.post('ajax/7.php', {
                id: esp_id,
                skey: sk,
                data: "sec",
                range: {
                    start: moment().startOf('days').format('YYYY-MM-DD HH:mm:ss'),
                    end: moment().format('YYYY-MM-DD HH:mm:ss'),
                }
            })
                .done(function (response) {
                    // console.log(response);

                    if (response == "nodata") {
                        overlayNodata();
                        return;
                    }

                    $(".overlay").fadeOut(200);
                    if (response == "") return;

                    var json = JSON.parse(response);

                    power_1 = json.power;
                    power_1.reverse();
                    power_2 = json.power2;
                    power_2.reverse();

                    let fulltime = json.time;
                    fulltime.reverse();

                    label_day = [];
                    for (var count = 0; count < fulltime.length; count++) {
                        let timesplit = String(fulltime[count]).split(" ");
                        label_day.push(timesplit[1]);
                    }

                    Chart_history.type = 'line';
                    Chart_history.data.datasets[0].data = power_1;
                    Chart_history.data.datasets[0].label = 'Discharge';
                    Chart_history.data.datasets[0].type = 'line';
                    Chart_history.data.datasets[1].data = power_2;
                    Chart_history.data.datasets[1].label = 'Charge';
                    Chart_history.data.datasets[1].type = 'line';
                    Chart_history.data.labels = label_day;

                    Chart_history.update();

                })
                .fail(function () {
                    // alert("An error occurred");
                    $(".overlay").fadeOut(200);
                    $('.toast').removeClass('bg-success bg-warning').addClass('bg-danger');
                    // $('.toast').addClass('bg-warning');
                    $('#toast-body').text("โหลดข้อมูลไม่สำเร็จ โปรดลองใหม่อีกครั้ง");
                    $('.toast').toast('show');
                });
        } else {

            Chart_history.type = 'line';
            Chart_history.data.datasets[0].data = power_1;
            Chart_history.data.datasets[0].label = 'Discharge';
            Chart_history.data.datasets[0].type = 'line';
            Chart_history.data.datasets[1].data = power_2;
            Chart_history.data.datasets[1].label = 'Charge';
            Chart_history.data.datasets[1].type = 'line';
            Chart_history.data.labels = label_day;

            Chart_history.update();

        }
    });

    // for tab select
    $("#mouth_view").click(function () {

        $("#chart").show();
        $("#uplot").hide();
        $("#google_table").hide();
        $(".setting-page").hide();
        $("#Charthistory").show();
        $("#Chart1").hide();
        $(".history_option_class").show();
        $(".history_view_class").hide();

        Chart_history.resetZoom();
        Chart_history.options.scales['x'].title.text = "วันที่";
        $('#chart_name').text('หน่วยไฟฟ้าแต่ละวัน [kWh]');

        if (label_mouth.length == 0) { // if empty array let get new

            $(".overlay").show();

            $.post('ajax/7.php', {
                id: esp_id,
                skey: sk,
                data: "day",
                range: {
                    start: moment().subtract(1, 'month').startOf('month').format('YYYY-MM-DD'),
                    end: moment().format('YYYY-MM-DD')
                }
            })
                .done(function (response) {
                    // console.log(response);
                    if (response == "nodata") {
                        $(".overlay").hide();
                        return;
                    }

                    $(".overlay").fadeOut(100);
                    if (response == "") return;

                    var json = JSON.parse(response);

                    energy_mouth = json.energy;
                    energy_mouth.reverse();
                    energy_mouth2 = json.energy2;
                    energy_mouth2.reverse();
                    var fulldate = json.time;
                    fulldate.reverse();

                    label_mouth = [];
                    for (var count = 0; count < fulldate.length; count++) {
                        let timesplit = String(fulldate[count]).split("-");
                        label_mouth.push(timesplit[2]);
                    }

                    Chart_history.data.datasets[0].data = energy_mouth;
                    Chart_history.data.datasets[0].label = 'Discharge';

                    Chart_history.data.datasets[1].data = energy_mouth2;
                    Chart_history.data.datasets[1].label = 'Charge';
                    Chart_history.data.labels = label_mouth;

                    Chart_history.data.datasets[0].type = 'bar';
                    Chart_history.data.datasets[1].type = 'bar';

                    Chart_history.update();

                })
                .fail(function () {

                    $(".overlay").fadeOut(200);
                    $('.toast').removeClass('bg-success bg-warning').addClass('bg-danger');
                    $('#toast-body').text("โหลดข้อมูลไม่สำเร็จ โปรดลองใหม่อีกครั้ง");
                    $('.toast').toast('show');

                });
        } else {

            Chart_history.data.datasets[0].data = [];
            Chart_history.data.datasets[1].data = [];
            Chart_history.update();

            Chart_history.data.datasets[0].data = energy_mouth;
            Chart_history.data.datasets[0].label = 'Discharge';

            Chart_history.data.datasets[1].data = energy_mouth2;
            Chart_history.data.datasets[1].label = 'Charge';
            Chart_history.data.labels = label_mouth;

            Chart_history.data.datasets[0].type = 'bar';
            Chart_history.data.datasets[1].type = 'bar';

            Chart_history.update();
        }
    });

    // for tab select
    $("#history_view").click(function () {

        $("#chart").show();
        $(".setting-page").hide();
        $("#uplot").show();
        $("#google_table").show();
        $("#Chart1").hide();
        $("#Charthistory").hide();
        $("#uplot").show();
        $(".history_option_class").show();
        $(".history_view_class").show();

        $('#chart_name').text('ค่าย้อนหลัง');

        if (typeof uplot === 'undefined') cbTimerange(moment().startOf('days'), moment());

    });


    $("#setting_option").click(function () {

        $("#value").hide();
        $("#io").hide();
        $("#chart").hide();
        $("#uplot").hide();
        $("#google_table").hide();
        $(".setting-page").show();
        $("#range_display").hide();
        $(".history_view_class").hide();

        if (typeof setting === 'undefined') {
            getlinedata();
        }
    });

    $('#linedata-save').click(function () {

        // console.log($('#dailynotify').prop('checked') ? 1 : 0);

        $.post('ajax/setting.php', {
            id: esp_id,
            skey: sk,
            p_id: 3,
            linetoken: $('#linetoken').val(),
            dailynotify: $('#dailynotify').prop('checked') ? 1 : 0,
            offlinenotify: $('#offlinenotify').prop('checked') ? 1 : 0,
            online_state: online_state
        })
            .done(function (response) {
                // console.log(response);
                if (response) {
                    $('.toast').removeClass('bg-warning').removeClass('bg-danger').addClass('bg-success');
                    // $('.toast').addClass('bg-success');
                    $('#toast-body').text("บันทึกข้อมูลเรียบร้อยแล้ว");
                    $('.toast').toast('show');
                }
            })
            .fail(function () {
                $('.toast').removeClass('bg-success').removeClass('bg-danger').addClass('bg-warning');
                // $('.toast').addClass('bg-warning');
                $('#toast-body').text("บันทึกข้อมูลไม่สำเร็จ โปรดลองใหม่อีกครั้ง");
                $('.toast').toast('show');
            });

    });

    $('#getLineToken label a').click(function () {
        document.addEventListener("visibilitychange", getlinedata);
    });

    function getlinedata() {
        if (!document.hidden) {

            $(".overlay").show();

            $.post('ajax/setting.php', {
                id: esp_id,
                skey: sk,
                p_id: 3
            })
                .done(function (response) {
                    // console.log(response);
                    $(".overlay").fadeOut(100);
                    if (response == "") return;

                    setting = JSON.parse(response);

                    // console.log(setting.daily_notify);

                    $("#linetoken").val(setting.line_token);
                    $("#dailynotify").prop("checked", setting.daily_notify == '1' ? true : false);
                    $('#offlinenotify').prop('checked', setting.offline_notify == '1' ? true : false);
                    $('#onlinenotify').prop('checked', setting.online_notify == '1' ? true : false);

                    document.removeEventListener("visibilitychange", getlinedata);
                })
                .fail(function () {
                    $(".overlay").fadeOut(100);
                    $('.toast').removeClass('bg-success bg-warning').addClass('bg-danger');
                    // $('.toast').addClass('bg-warning');
                    $('#toast-body').text("โหลดข้อมูลไม่สำเร็จ โปรดลองใหม่อีกครั้ง");
                    $('.toast').toast('show');
                });
        }
    }

    function wheelZoomPlugin(opts) {
        let factor = opts.factor || 0.75;

        let xMin, xMax, yMin, yMax, xRange, yRange;

        function clamp(nRange, nMin, nMax, fRange, fMin, fMax) {
            if (nRange > fRange) {
                nMin = fMin;
                nMax = fMax;
            }
            else if (nMin < fMin) {
                nMin = fMin;
                nMax = fMin + nRange;
            }
            else if (nMax > fMax) {
                nMax = fMax;
                nMin = fMax - nRange;
            }

            return [nMin, nMax];
        }

        return {
            hooks: {
                ready: u => {
                    xMin = u.scales.x.min;
                    xMax = u.scales.x.max;
                    yMin = u.scales.y.min;
                    yMax = u.scales.y.max;

                    xRange = xMax - xMin;
                    yRange = yMax - yMin;

                    let over = u.over;
                    let rect = over.getBoundingClientRect();

                    // wheel drag pan
                    over.addEventListener("mousedown", e => {
                        if (e.button == 1) {
                            //	plot.style.cursor = "move";
                            e.preventDefault();

                            let left0 = e.clientX;
                            //	let top0 = e.clientY;

                            let scXMin0 = u.scales.x.min;
                            let scXMax0 = u.scales.x.max;

                            let xUnitsPerPx = u.posToVal(1, 'x') - u.posToVal(0, 'x');

                            function onmove(e) {
                                e.preventDefault();

                                let left1 = e.clientX;
                                //	let top1 = e.clientY;

                                let dx = xUnitsPerPx * (left1 - left0);

                                u.setScale('x', {
                                    min: scXMin0 - dx,
                                    max: scXMax0 - dx,
                                });
                            }

                            function onup(e) {
                                document.removeEventListener("mousemove", onmove);
                                document.removeEventListener("mouseup", onup);
                            }

                            document.addEventListener("mousemove", onmove);
                            document.addEventListener("mouseup", onup);
                        }
                    });

                    // wheel scroll zoom
                    over.addEventListener("wheel", e => {
                        e.preventDefault();

                        let { left, top } = u.cursor;

                        let leftPct = left / rect.width;
                        let btmPct = 1 - top / rect.height;
                        let xVal = u.posToVal(left, "x");
                        let yVal = u.posToVal(top, "y");
                        let oxRange = u.scales.x.max - u.scales.x.min;
                        let oyRange = u.scales.y.max - u.scales.y.min;

                        let nxRange = e.deltaY < 0 ? oxRange * factor : oxRange / factor;
                        let nxMin = xVal - leftPct * nxRange;
                        let nxMax = nxMin + nxRange;
                        [nxMin, nxMax] = clamp(nxRange, nxMin, nxMax, xRange, xMin, xMax);

                        let nyRange = e.deltaY < 0 ? oyRange * factor : oyRange / factor;
                        let nyMin = yVal - btmPct * nyRange;
                        let nyMax = nyMin + nyRange;
                        [nyMin, nyMax] = clamp(nyRange, nyMin, nyMax, yRange, yMin, yMax);

                        u.batch(() => {
                            u.setScale("x", {
                                min: nxMin,
                                max: nxMax,
                            });

                            u.setScale("y", {
                                min: nyMin,
                                max: nyMax,
                            });
                        });
                    });
                }
            }
        };
    }

    function uplotupdate() {

        function getSize(elementId) {
            return {
                width: document.getElementById(elementId).offsetWidth,
                height: document.getElementById(elementId).offsetHeight - 50,
            }
        }

        let data = [label_timestamp, volt_history, curr_history, power_history, energy_history, volt_history2, curr_history2, power_history2, energy_history2];

        // console.log(data);
        // console.log(data2);
        if (typeof uplot === 'undefined') {
            const optsAreaChart = {
                ...getSize('areaChart'),
                plugins: [
                    wheelZoomPlugin({ factor: 0.75 })
                ],
                series: [
                    {},
                    {
                        // initial toggled state (optional)
                        show: false,

                        // spanGaps: true,

                        // in-legend display
                        label: "Volt-Discharge",
                        scale: "v",
                        value: (self, rawValue) => rawValue.toFixed(2) + " v",

                        stroke: 'rgba(210, 214, 222, 1)',
                        width: 2,
                        fill: 'rgba(210, 214, 222, 0.1)'
                    },
                    {
                        // initial toggled state (optional)
                        show: false,

                        // spanGaps: true,

                        // in-legend display
                        label: "Current-Discharge",
                        scale: "i",
                        value: (self, rawValue) => rawValue.toFixed(2) + " A",

                        stroke: '#f05d23',
                        width: 2,
                        fill: '#f05d2350'
                    },
                    {
                        // initial toggled state (optional)
                        show: true,

                        // spanGaps: true,

                        // in-legend display
                        label: "power-Discharge",
                        scale: "p",
                        value: (self, rawValue) => rawValue.toFixed(1) + " W",

                        stroke: "rgba(60,141,188,1)",
                        width: 2,
                        fill: "rgba(60,141,188,0.3)"
                    },
                    {
                        // initial toggled state (optional)
                        show: false,

                        // spanGaps: true,

                        // in-legend display
                        label: "Energy-Discharge",
                        scale: "e",
                        value: (self, rawValue) => rawValue.toFixed(3) + " kWh",

                        stroke: "#b643cd",
                        width: 1,
                        fill: "#b643cd20"
                    },
                    {
                        // initial toggled state (optional)
                        show: false,

                        // spanGaps: true,

                        // in-legend display
                        label: "Volt-Change",
                        scale: "v",
                        value: (self, rawValue) => rawValue.toFixed(2) + " v",

                        stroke: 'rgba(110, 114, 222, 1)',
                        width: 2,
                        fill: 'rgba(110, 114, 222, 0.1)'
                    },
                    {
                        // initial toggled state (optional)
                        show: false,

                        // spanGaps: true,

                        // in-legend display
                        label: "Current-Change",
                        scale: "i",
                        value: (self, rawValue) => rawValue.toFixed(2) + " A",

                        stroke: '#f01d23',
                        width: 2,
                        fill: '#f01d2350'
                    },
                    {
                        // initial toggled state (optional)
                        show: true,

                        // spanGaps: true,

                        // in-legend display
                        label: "power-Change",
                        scale: "p",
                        value: (self, rawValue) => rawValue.toFixed(1) + " W",

                        stroke: "rgba(10,241,188,1)",
                        width: 2,
                        fill: "rgba(10,241,188,0.3)"
                    },
                    {
                        // initial toggled state (optional)
                        show: false,

                        // spanGaps: true,

                        // in-legend display
                        label: "Energy-Change",
                        scale: "e",
                        value: (self, rawValue) => rawValue.toFixed(3) + " kWh",

                        stroke: "#b9432d",
                        width: 1,
                        fill: "#b9432d20"
                    }
                ],
                axes: [
                    {
                        label: "เวลา",
                        // labelSize: 20,
                        stroke: "white",
                    },
                    {
                        scale: "v",
                        label: "Voltage",
                        stroke: "white",
                    }, {
                        side: 1,
                        scale: "i",
                        label: "Current",
                        stroke: "white",
                    }, {
                        scale: "p",
                        label: "Power",
                        stroke: "white",
                    }, {
                        side: 1,
                        scale: "e",
                        label: "Energy",
                        stroke: "white",
                    }
                ],
            };

            uplot = new uPlot(optsAreaChart, data, document.getElementById('areaChart'));

            window.addEventListener("resize", e => {
                uplot.setSize(getSize('areaChart'));
            });
        }
        else {
            uplot.setData(data);
        }
    }

    function tablechart() {

        // prepare data for table chart
        var google_data = [];
        for (var count = label_history.length - 1; count >= 0; count--) {
            google_data.push([volt_history[count], curr_history[count], power_history[count], energy_history[count], volt_history2[count], curr_history2[count], power_history2[count], energy_history2[count], label_history[count]]);
        }

        google.charts.load('current', { 'packages': ['table'] });
        google.charts.setOnLoadCallback(drawTable);


        function drawTable() {
            var data = new google.visualization.DataTable();
            data.addColumn('number', 'Volt');
            data.addColumn('number', 'Curr');
            data.addColumn('number', 'Power');
            data.addColumn('number', 'Energy');
            data.addColumn('number', 'Volt2');
            data.addColumn('number', 'Curr2');
            data.addColumn('number', 'Power2');
            data.addColumn('number', 'Energy2');
            data.addColumn('string', 'time');
            data.addRows(google_data);


            var options = {
                showRowNumber: true,
                allowHtml: true,
                width: '100%', height: '100%',
                page: 'enable', pageSize: 50,
                cssClassNames: {
                    headerRow: 'table-secondary bg-dark',
                    headerCell: 'table-secondary bg-dark',
                    tableCell: 'table-secondary bg-dark'
                }
            };

            var table = new google.visualization.Table(document.getElementById('table_div'));

            table.draw(data, options);
        }
    }

    function cbTimerange(start, end) {

        // alert("hello from cbTimerange");
        $('.daterange span').html(start.format('YYYY-MM-DD HH:mm') + ' - ' + end.format('YYYY-MM-DD HH:mm'));

        let minutesdiff = end.diff(start, 'minutes');
        let minutesfromnow = moment().diff(start, 'minutes');
        var datarange;
        if (minutesdiff <= 60 * 24 * 7 && minutesfromnow <= 60 * 24 * 7) datarange = "sec";
        else if (minutesdiff <= 60 * 24 * 31 * 3 && minutesfromnow <= 60 * 24 * 31 * 3) datarange = "hr";
        else datarange = "day";

        $(".overlay").show(100);

        $.ajax({
            url: "ajax/7.php",
            type: "post",
            data: {
                id: esp_id,
                skey: sk,
                data: datarange,
                range: {
                    start: start.format('YYYY-MM-DD HH:mm'),
                    end: end.format('YYYY-MM-DD HH:mm')
                }
            },
            success: function (data) {
                // console.log(data);
                if (data == "nodata") {
                    $(".overlay").hide();
                    return;
                }

                var json = JSON.parse(data);

                // reverse for uplot
                json.voltage.reverse();
                json.current.reverse();
                json.power.reverse();
                json.energy.reverse();
                json.voltage2.reverse();
                json.current2.reverse();
                json.power2.reverse();
                json.energy2.reverse();
                json.time.reverse();

                volt_history = [];
                curr_history = [];
                power_history = [];
                let min_energy_history = parseFloat(json.energy[0]);
                energy_history = [];
                volt_history2 = [];
                curr_history2 = [];
                power_history2 = [];
                let min_energy_history2 = parseFloat(json.energy2[0]);
                energy_history2 = [];

                // convert string to time stamp for uplot
                label_timestamp = [];

                for (var count = 0; count < json.time.length; count++) {
                    volt_history.push(parseFloat(json.voltage[count]));
                    curr_history.push(parseFloat(json.current[count]));
                    power_history.push(parseFloat(json.power[count]));
                    energy_history.push(parseFloat(json.energy[count]) - min_energy_history);
                    volt_history2.push(parseFloat(json.voltage2[count]));
                    curr_history2.push(parseFloat(json.current2[count]));
                    power_history2.push(parseFloat(json.power2[count]));
                    energy_history2.push(parseFloat(json.energy2[count]) - min_energy_history2);
                    label_timestamp.push(Date.parse(json.time[count]) / 1000);
                }

                // for save as csv
                label_history = json.time;

                $(".overlay").fadeOut(100);

                if (label_history.length != 0) {
                    uplotupdate();
                    tablechart();
                }

            },
            error: function () {
                // alert("An error occurred");
                $(".overlay").fadeOut(200);
                $('.toast').removeClass('bg-success bg-warning').addClass('bg-danger');
                // $('.toast').addClass('bg-warning');
                $('#toast-body').text("โหลดข้อมูลไม่สำเร็จ โปรดลองใหม่อีกครั้ง");
                $('.toast').toast('show');
            }
        })

    }

    $('.daterange').daterangepicker({
        "timePicker": true,
        "timePicker24Hour": true,
        ranges: {
            Today: [moment().startOf('days'), moment()],
            Yesterday: [moment().subtract(1, 'days').startOf('days'), moment().subtract(1, 'days').endOf('days')],
            'Last 2 Days': [moment().subtract(1, 'days').startOf('days'), moment()],
            'Last 7 Days': [moment().subtract(6, 'days').startOf('days'), moment()],
            'Last 15 Days': [moment().subtract(14, 'days').startOf('days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days').startOf('days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Last 3 Month': [moment().subtract(2, 'month').startOf('month'), moment()],
            'This Years': [moment().startOf('year'), moment()]
        },
        startDate: moment().startOf('days'),
        endDate: moment()
    }, cbTimerange);


    $("#csvdownload").click(function () {
        var data = [
            ["time", "voltage", "current", "power", "energy", "voltage2", "current2", "power2", "energy2"]
        ];

        // console.log(label_history.length);return;

        for (var count = 0; count < label_history.length; count++) {
            data.push([label_history[count], volt_history[count], curr_history[count], power_history[count], energy_history[count], volt_history2[count], curr_history2[count], power_history2[count], energy_history2[count]]);
            // console.log([label_history[count], volt_history[count], curr_history[count], power_history[count], energy_history[count], freq_history[count], p_f_history[count]]);
        }

        let csvContent = "data:text/csv;charset=utf-8," +
            data.map(e => e.join(",")).join("\n");

        var encodedUri = encodeURI(csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", label_history[0] + "_to_" + label_history[label_history.length - 1] + "_data.csv");
        document.body.appendChild(link);
        link.click();
    });

});