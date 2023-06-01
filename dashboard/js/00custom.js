$(document).ready(function () {

    // for variable lebel
    var var0_label = "var0",
        var1_label = "var1",
        var2_label = "var2",
        var3_label = "var3",
        var4_label = "var4",
        var5_label = "var5",
        var6_label = "var6",
        var7_label = "var7",
        var8_label = "var8",
        var9_label = "var9";

    //last data
    var var0 = [],
        var1 = [],
        var2 = [],
        var3 = [],
        var4 = [],
        var5 = [],
        var6 = [],
        var7 = [],
        var8 = [],
        var9 = [],
        label = [];
    var lastupdate;

    // today and yesterday
    var var0_today = [],
        var1_today = [],
        var2_today = [],
        var3_today = [],
        var4_today = [],
        var5_today = [],
        var6_today = [],
        var7_today = [],
        var8_today = [],
        var9_today = [],
        label_day = [];

    // this mouth and last month
    var var0_thismouth = [],
        var1_thismouth = [],
        var2_thismouth = [],
        var3_thismouth = [],
        var4_thismouth = [],
        var5_thismouth = [],
        var6_thismouth = [],
        var7_thismouth = [],
        var8_thismouth = [],
        var9_thismouth = [],
        label_mouth = [];
    var fulldate;

    // custom history range
    var var0_history = [],
        var1_history = [],
        var2_history = [],
        var3_history = [],
        var4_history = [],
        var5_history = [],
        var6_history = [],
        var7_history = [],
        var8_history = [],
        var9_history = [],
        label_history = [],
        label_timestamp = [],
        raw_var0_history = [],
        raw_var1_history = [],
        raw_var2_history = [],
        raw_var3_history = [],
        raw_var4_history = [],
        raw_var5_history = [],
        raw_var6_history = [],
        raw_var7_history = [],
        raw_var8_history = [],
        raw_var9_history = [],
        raw_label_history = [],
        raw_label_timestamp = [],
        uplot;

    // for device setting
    var setting;
    var online_state;

    var Chart0;
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
    $(".month-view-page").hide();
    $(".day-view-page").hide();

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
                legendItem.hidden = true;
            } else {
                ci.show(index);
                legendItem.hidden = false;
            }

            if (ci.isDatasetVisible(0) || ci.isDatasetVisible(1)) ci.options.scales['y'].display = true;
            else ci.options.scales['y'].display = false;
            if (ci.isDatasetVisible(2) || ci.isDatasetVisible(3)) ci.options.scales['yh'].display = true;
            else ci.options.scales['yh'].display = false;

            ci.update();
        };

        Chart0 = new Chart(
            document.getElementById('Chart0'), {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'var0',
                    data: [],
                    yAxisID: 'y',
                    tension: 0.1,
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    pointRadius: 0.5,
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
                    title: {
                        display: true,
                        text: var0_label,
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        type: 'time',
                        title: {
                            display: true,
                            text: "เวลา",
                        }, time: {
                            unit: 'minute'
                        },
                    },
                    y: {
                        title: {
                            display: true,
                            text: "Var0",
                        },
                        type: 'linear',
                        display: true,
                        position: 'left',
                    }
                }
            }
        }
        );

        Chart1 = new Chart(
            document.getElementById('Chart1'), {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'var1',
                    data: [],
                    yAxisID: 'y',
                    tension: 0.1,
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    pointRadius: 0.5,
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
                    title: {
                        display: true,
                        text: var1_label,
                    },
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    x: {
                        type: 'time',
                        title: {
                            display: true,
                            text: "เวลา",
                        }, time: {
                            unit: 'minute'
                        },
                    },
                    y: {
                        title: {
                            display: true,
                            text: "Var1",
                        },
                        type: 'linear',
                        display: true,
                        position: 'left',
                    }
                }
            }
        }
        );

        Chart2 = new Chart(
            document.getElementById('Chart2'), {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'var2',
                    data: [],
                    yAxisID: 'y',
                    tension: 0.1,
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    pointRadius: 0.5,
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
                    title: {
                        display: true,
                        text: var2_label,
                    },
                    legend: {
                        display: false
                    },
                },
                scales: {
                    x: {
                        type: 'time',
                        title: {
                            display: true,
                            text: "เวลา",
                        }, time: {
                            unit: 'minute'
                        },
                        // ticks: {
                        //     source: 'auto',
                        //     autoSkip: true,
                        // },
                    },
                    y: {
                        title: {
                            display: true,
                            text: "Var2",
                        },
                        type: 'linear',
                        display: true,
                        position: 'left',
                    }
                }
            }
        }
        );

        Chart3 = new Chart(
            document.getElementById('Chart3'), {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'var3',
                    data: [],
                    yAxisID: 'y',
                    tension: 0.1,
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    pointRadius: 0.5,
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
                    title: {
                        display: true,
                        text: var3_label,
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        type: 'time',
                        title: {
                            display: true,
                            text: "เวลา",
                        }, time: {
                            unit: 'minute'
                        },
                        // ticks: {
                        //     source: 'auto',
                        //     autoSkip: true,
                        // },
                    },
                    y: {
                        title: {
                            display: true,
                            text: "Var3",
                        },
                        type: 'linear',
                        display: true,
                        position: 'left',
                    }
                }
            }
        }
        );

        Chart4 = new Chart(
            document.getElementById('Chart4'), {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'var4',
                    data: [],
                    yAxisID: 'y',
                    tension: 0.1,
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    pointRadius: 0.5,
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
                    title: {
                        display: true,
                        text: var4_label,
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        type: 'time',
                        title: {
                            display: true,
                            text: "เวลา",
                        }, time: {
                            unit: 'minute'
                        },
                        // ticks: {
                        //     source: 'auto',
                        //     autoSkip: true,
                        // },
                    },
                    y: {
                        title: {
                            display: true,
                            text: "Var4",
                        },
                        type: 'linear',
                        display: true,
                        position: 'left',
                    }
                }
            }
        }
        );

        Chart5 = new Chart(
            document.getElementById('Chart5'), {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'var5',
                    data: [],
                    yAxisID: 'y',
                    tension: 0.1,
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    pointRadius: 0.5,
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
                    title: {
                        display: true,
                        text: var5_label,
                    },
                    legend: {
                        display: false
                    },
                },
                scales: {
                    x: {
                        type: 'time',
                        title: {
                            display: true,
                            text: "เวลา",
                        }, time: {
                            unit: 'minute'
                        },
                        // ticks: {
                        //     source: 'auto',
                        //     autoSkip: true,
                        // },
                    },
                    y: {
                        title: {
                            display: true,
                            text: "Var5",
                        },
                        type: 'linear',
                        display: true,
                        position: 'left',
                    }
                }
            }
        }
        );

        Chart6 = new Chart(
            document.getElementById('Chart6'), {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'var6',
                    data: [],
                    yAxisID: 'y',
                    tension: 0.1,
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    pointRadius: 0.5,
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
                    title: {
                        display: true,
                        text: var6_label,
                    },
                    legend: {
                        display: false
                    },
                },
                scales: {
                    x: {
                        type: 'time',
                        title: {
                            display: true,
                            text: "เวลา",
                        }, time: {
                            unit: 'minute'
                        },
                        // ticks: {
                        //     source: 'auto',
                        //     autoSkip: true,
                        // },
                    },
                    y: {
                        title: {
                            display: true,
                            text: "Var6",
                        },
                        type: 'linear',
                        display: true,
                        position: 'left',
                    }
                }
            }
        }
        );

        Chart7 = new Chart(
            document.getElementById('Chart7'), {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'var7',
                    data: [],
                    yAxisID: 'y',
                    tension: 0.1,
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    pointRadius: 0.5,
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
                    title: {
                        display: true,
                        text: var7_label,
                    },
                    legend: {
                        display: false
                    },
                },
                scales: {
                    x: {
                        type: 'time',
                        title: {
                            display: true,
                            text: "เวลา",
                        }, time: {
                            unit: 'minute'
                        },
                        // ticks: {
                        //     source: 'auto',
                        //     autoSkip: true,
                        // },
                    },
                    y: {
                        title: {
                            display: true,
                            text: "Var7",
                        },
                        type: 'linear',
                        display: true,
                        position: 'left',
                    }
                }
            }
        }
        );

        Chart8 = new Chart(
            document.getElementById('Chart8'), {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'var8',
                    data: [],
                    yAxisID: 'y',
                    tension: 0.1,
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    pointRadius: 0.5,
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
                    title: {
                        display: true,
                        text: var8_label,
                    },
                    legend: {
                        display: false
                    },
                },
                scales: {
                    x: {
                        type: 'time',
                        title: {
                            display: true,
                            text: "เวลา",
                        }, time: {
                            unit: 'minute'
                        },
                        // ticks: {
                        //     source: 'auto',
                        //     autoSkip: true,
                        // },
                    },
                    y: {
                        title: {
                            display: true,
                            text: "Var8",
                        },
                        type: 'linear',
                        display: true,
                        position: 'left',
                    }
                }
            }
        }
        );

        Chart9 = new Chart(
            document.getElementById('Chart9'), {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'var9',
                    data: [],
                    yAxisID: 'y',
                    tension: 0.1,
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    pointRadius: 0.5,
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
                    title: {
                        display: true,
                        text: var9_label,
                    },
                    legend: {
                        display: false
                    },
                },
                scales: {
                    x: {
                        type: 'time',
                        title: {
                            display: true,
                            text: "เวลา",
                        }, time: {
                            unit: 'minute'
                        },
                        // ticks: {
                        //     source: 'auto',
                        //     autoSkip: true,
                        // },
                    },
                    y: {
                        title: {
                            display: true,
                            text: "Var9",
                        },
                        type: 'linear',
                        display: true,
                        position: 'left',
                    }
                }
            }
        }
        );

        Chart_history_0 = new Chart(
            document.getElementById('Chart_history_0'), {
            type: 'bar',
            plugins: [ChartDataLabels],
            data: {
                labels: [],
                datasets: [{
                    label: 'var0-Today',
                    data: [],
                    tension: 0.1,
                    yAxisID: 'y',
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    // pointRadius: 0.5,
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
                    title: {
                        display: true,
                        text: var0_label,
                    },
                    legend: {
                        display: false,
                        onClick: axiscontrol
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
                    },
                    datalabels: {
                        align: 'end',
                        anchor: 'end',
                        formatter: (value) => {
                            return value != null ? Math.round(value) : '';
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
                        title: {
                            display: false,
                            text: var0_label,
                        },
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

        Chart_history_1 = new Chart(
            document.getElementById('Chart_history_1'), {
            type: 'bar',
            plugins: [ChartDataLabels],
            data: {
                labels: [],
                datasets: [{
                    label: 'var1-Today',
                    data: [],
                    tension: 0.1,
                    yAxisID: 'y',
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    // pointRadius: 0.5,
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
                    title: {
                        display: true,
                        text: var1_label,
                    },
                    legend: {
                        display: false,
                        onClick: axiscontrol
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
                    },
                    datalabels: {
                        align: 'end',
                        anchor: 'end',
                        formatter: (value) => {
                            return value != null ? Math.round(value) : '';
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
                        title: {
                            display: false,
                            text: var1_label,
                        },
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

        Chart_history_2 = new Chart(
            document.getElementById('Chart_history_2'), {
            type: 'bar',
            plugins: [ChartDataLabels],
            data: {
                labels: [],
                datasets: [{
                    label: 'var2-Today',
                    data: [],
                    tension: 0.1,
                    yAxisID: 'y',
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    // pointRadius: 0.5,
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
                    title: {
                        display: true,
                        text: var2_label,
                    },
                    legend: {
                        display: false,
                        onClick: axiscontrol
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
                    },
                    datalabels: {
                        align: 'end',
                        anchor: 'end',
                        formatter: (value) => {
                            return value != null ? Math.round(value) : '';
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
                        title: {
                            display: false,
                            text: var2_label,
                        },
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

        Chart_history_3 = new Chart(
            document.getElementById('Chart_history_3'), {
            type: 'bar',
            plugins: [ChartDataLabels],
            data: {
                labels: [],
                datasets: [{
                    label: 'var3-Today',
                    data: [],
                    tension: 0.1,
                    yAxisID: 'y',
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    // pointRadius: 0.5,
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
                    title: {
                        display: true,
                        text: var3_label,
                    },
                    legend: {
                        display: false,
                        onClick: axiscontrol
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
                    },
                    datalabels: {
                        align: 'end',
                        anchor: 'end',
                        formatter: (value) => {
                            return value != null ? Math.round(value) : '';
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
                        title: {
                            display: false,
                            text: var3_label,
                        },
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

        Chart_history_4 = new Chart(
            document.getElementById('Chart_history_4'), {
            type: 'bar',
            plugins: [ChartDataLabels],
            data: {
                labels: [],
                datasets: [{
                    label: 'var4-Today',
                    data: [],
                    tension: 0.1,
                    yAxisID: 'y',
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    // pointRadius: 0.5,
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
                    title: {
                        display: true,
                        text: var4_label,
                    },
                    legend: {
                        display: false,
                        onClick: axiscontrol
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
                    },
                    datalabels: {
                        align: 'end',
                        anchor: 'end',
                        formatter: (value) => {
                            return value != null ? Math.round(value) : '';
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
                        title: {
                            display: false,
                            text: var4_label,
                        },
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

        Chart_history_5 = new Chart(
            document.getElementById('Chart_history_5'), {
            type: 'bar',
            plugins: [ChartDataLabels],
            data: {
                labels: [],
                datasets: [{
                    label: 'var5-Today',
                    data: [],
                    tension: 0.1,
                    yAxisID: 'y',
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    // pointRadius: 0.5,
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
                    title: {
                        display: true,
                        text: var5_label,
                    },
                    legend: {
                        display: false,
                        onClick: axiscontrol
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
                    },
                    datalabels: {
                        align: 'end',
                        anchor: 'end',
                        formatter: (value) => {
                            return value != null ? Math.round(value) : '';
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
                        title: {
                            display: false,
                            text: var5_label,
                        },
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

        Chart_history_6 = new Chart(
            document.getElementById('Chart_history_6'), {
            type: 'bar',
            plugins: [ChartDataLabels],
            data: {
                labels: [],
                datasets: [{
                    label: 'var6-Today',
                    data: [],
                    tension: 0.1,
                    yAxisID: 'y',
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    // pointRadius: 0.5,
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
                    title: {
                        display: true,
                        text: var6_label,
                    },
                    legend: {
                        display: false,
                        onClick: axiscontrol
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
                    },
                    datalabels: {
                        align: 'end',
                        anchor: 'end',
                        formatter: (value) => {
                            return value != null ? Math.round(value) : '';
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
                        title: {
                            display: false,
                            text: var6_label,
                        },
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

        Chart_history_7 = new Chart(
            document.getElementById('Chart_history_7'), {
            type: 'bar',
            plugins: [ChartDataLabels],
            data: {
                labels: [],
                datasets: [{
                    label: 'var7-Today',
                    data: [],
                    tension: 0.1,
                    yAxisID: 'y',
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    // pointRadius: 0.5,
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
                    title: {
                        display: true,
                        text: var7_label,
                    },
                    legend: {
                        display: false,
                        onClick: axiscontrol
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
                    },
                    datalabels: {
                        align: 'end',
                        anchor: 'end',
                        formatter: (value) => {
                            return value != null ? Math.round(value) : '';
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
                        title: {
                            display: false,
                            text: var7_label,
                        },
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

        Chart_history_8 = new Chart(
            document.getElementById('Chart_history_8'), {
            type: 'bar',
            plugins: [ChartDataLabels],
            data: {
                labels: [],
                datasets: [{
                    label: 'var8-Today',
                    data: [],
                    tension: 0.1,
                    yAxisID: 'y',
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    // pointRadius: 0.5,
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
                    title: {
                        display: true,
                        text: var8_label,
                    },
                    legend: {
                        display: false,
                        onClick: axiscontrol
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
                    },
                    datalabels: {
                        align: 'end',
                        anchor: 'end',
                        formatter: (value) => {
                            return value != null ? Math.round(value) : '';
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
                        title: {
                            display: false,
                            text: var8_label,
                        },
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

        Chart_history_9 = new Chart(
            document.getElementById('Chart_history_9'), {
            type: 'bar',
            plugins: [ChartDataLabels],
            data: {
                labels: [],
                datasets: [{
                    label: 'var9-Today',
                    data: [],
                    tension: 0.1,
                    yAxisID: 'y',
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    // pointRadius: 0.5,
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
                    title: {
                        display: true,
                        text: var9_label,
                    },
                    legend: {
                        display: false,
                        onClick: axiscontrol
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
                    },
                    datalabels: {
                        align: 'end',
                        anchor: 'end',
                        formatter: (value) => {
                            return value != null ? Math.round(value) : '';
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
                        title: {
                            display: false,
                            text: var9_label,
                        },
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

    function checkNull(val) {
        return val == '0.0';
    }

    function varUpdate() {

        $("#var-name-0").val(var0_label);
        $("#var-0-label").html(var0_label);
        $("#var-name-1").val(var1_label);
        $("#var-1-label").html(var1_label);
        $("#var-name-2").val(var2_label);
        $("#var-2-label").html(var2_label);
        $("#var-name-3").val(var3_label);
        $("#var-3-label").html(var3_label);
        $("#var-name-4").val(var4_label);
        $("#var-4-label").html(var4_label);
        $("#var-name-5").val(var5_label);
        $("#var-5-label").html(var5_label);
        $("#var-name-6").val(var6_label);
        $("#var-6-label").html(var6_label);
        $("#var-name-7").val(var7_label);
        $("#var-7-label").html(var7_label);
        $("#var-name-8").val(var8_label);
        $("#var-8-label").html(var8_label);
        $("#var-name-9").val(var9_label);
        $("#var-9-label").html(var9_label);

        Chart0.options.plugins.title.text = var0_label;
        Chart1.options.plugins.title.text = var1_label;
        Chart2.options.plugins.title.text = var2_label;
        Chart3.options.plugins.title.text = var3_label;
        Chart4.options.plugins.title.text = var4_label;
        Chart5.options.plugins.title.text = var5_label;
        Chart6.options.plugins.title.text = var6_label;
        Chart7.options.plugins.title.text = var7_label;
        Chart8.options.plugins.title.text = var8_label;
        Chart9.options.plugins.title.text = var9_label;

        Chart_history_0.options.plugins.title.text = var0_label;
        Chart_history_1.options.plugins.title.text = var1_label;
        Chart_history_2.options.plugins.title.text = var2_label;
        Chart_history_3.options.plugins.title.text = var3_label;
        Chart_history_4.options.plugins.title.text = var4_label;
        Chart_history_5.options.plugins.title.text = var5_label;
        Chart_history_6.options.plugins.title.text = var6_label;
        Chart_history_7.options.plugins.title.text = var7_label;
        Chart_history_8.options.plugins.title.text = var8_label;
        Chart_history_9.options.plugins.title.text = var9_label;
    }

    //second data
    function getLastData() {
        $(".overlay").show();

        $.ajax({
            url: "ajax/custom/custom.php",
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

                    json.var0.reverse();
                    json.var1.reverse();
                    json.var2.reverse();
                    json.var3.reverse();
                    json.var4.reverse();
                    json.var5.reverse();
                    json.var6.reverse();
                    json.var7.reverse();
                    json.var8.reverse();
                    json.var9.reverse();
                    json.time.reverse();

                    var0 = json.var0;
                    var1 = json.var1;
                    var2 = json.var2;
                    var3 = json.var3;
                    var4 = json.var4;
                    var5 = json.var5;
                    var6 = json.var6;
                    var7 = json.var7;
                    var8 = json.var8;
                    var9 = json.var9;
                    label = json.time;

                    if (json.label) {

                        let var_label = JSON.parse(json.label);

                        if (var_label.c0) {
                            var0_label = var_label.c0;
                        }
                        if (var_label.c1) {
                            var1_label = var_label.c1;
                        }
                        if (var_label.c2) {
                            var2_label = var_label.c2;
                        }
                        if (var_label.c3) {
                            var3_label = var_label.c3;
                        }
                        if (var_label.c4) {
                            var4_label = var_label.c4;
                        }
                        if (var_label.c5) {
                            var5_label = var_label.c5;
                        }
                        if (var_label.c6) {
                            var6_label = var_label.c6;
                        }
                        if (var_label.c7) {
                            var7_label = var_label.c7;
                        }
                        if (var_label.c8) {
                            var8_label = var_label.c8;
                        }
                        if (var_label.c9) {
                            var9_label = var_label.c9;
                        }

                    }

                    varUpdate();

                    lastupdate = json.lastupdate;
                    updateStatus();

                    $("#var-0-value").html(json.var0[json.var0.length - 1]);
                    $("#var-1-value").html(json.var1[json.var1.length - 1]);
                    $("#var-2-value").html(json.var2[json.var2.length - 1]);
                    $("#var-3-value").html(json.var3[json.var3.length - 1]);
                    $("#var-4-value").html(json.var4[json.var4.length - 1]);
                    $("#var-5-value").html(json.var5[json.var5.length - 1]);
                    $("#var-6-value").html(json.var6[json.var6.length - 1]);
                    $("#var-7-value").html(json.var7[json.var7.length - 1]);
                    $("#var-8-value").html(json.var8[json.var8.length - 1]);
                    $("#var-9-value").html(json.var9[json.var9.length - 1]);
                    $("#time").html(json.time[json.time.length - 1]);

                    if (var0.every(checkNull)) {
                        $("#var-0-value").parent().parent().remove();
                        $("#Chart0").parent().parent().remove();
                        $("#Chart_history_0").parent().parent().remove();
                        $(".var_0_class").remove();
                        // Chart0.options.scales['y'].display = false;
                        // Chart0.options.plugins.legend.display = false;
                        // Chart0.data.datasets[0].hidden = true;
                    }
                    if (var1.every(checkNull)) {
                        $("#var-1-value").parent().parent().remove();
                        $("#Chart1").parent().parent().remove();
                        $("#Chart_history_1").parent().parent().remove();
                        $(".var_1_class").remove();
                        // Chart1.options.scales['y'].display = false;
                        // Chart1.options.plugins.legend.display = false;
                        // Chart1.data.datasets[0].hidden = true;
                    }
                    if (var2.every(checkNull)) {
                        $("#var-2-value").parent().parent().remove();
                        $("#Chart2").parent().parent().remove();
                        $("#Chart_history_2").parent().parent().remove();
                        $(".var_2_class").remove();
                        // Chart2.options.scales['y'].display = false;
                        // Chart2.options.plugins.legend.display = false;
                        // Chart2.data.datasets[0].hidden = true;
                    }
                    if (var3.every(checkNull)) {
                        $("#var-3-value").parent().parent().remove();
                        $("#Chart3").parent().parent().remove();
                        $("#Chart_history_3").parent().parent().remove();
                        $(".var_3_class").remove();
                        // Chart3.options.scales['y'].display = false;
                        // Chart3.options.plugins.legend.display = false;
                        // Chart3.data.datasets[0].hidden = true;
                    }
                    if (var4.every(checkNull)) {
                        $("#var-4-value").parent().parent().remove();
                        $("#Chart4").parent().parent().remove();
                        $("#Chart_history_4").parent().parent().remove();
                        $(".var_4_class").remove();
                        // Chart4.options.scales['y'].display = false;
                        // Chart4.options.plugins.legend.display = false;
                        // Chart4.data.datasets[0].hidden = true;
                    }
                    if (var5.every(checkNull)) {
                        $("#var-5-value").parent().parent().remove();
                        $("#Chart5").parent().parent().remove();
                        $("#Chart_history_5").parent().parent().remove();
                        $(".var_5_class").remove();
                        // Chart5.options.scales['y'].display = false;
                        // Chart5.options.plugins.legend.display = false;
                        // Chart5.data.datasets[0].hidden = true;
                    }
                    if (var6.every(checkNull)) {
                        $("#var-6-value").parent().parent().remove();
                        $("#Chart6").parent().parent().remove();
                        $("#Chart_history_6").parent().parent().remove();
                        $(".var_6_class").remove();
                        // Chart6.options.scales['y'].display = false;
                        // Chart6.options.plugins.legend.display = false;
                        // Chart6.data.datasets[0].hidden = true;
                    }
                    if (var7.every(checkNull)) {
                        $("#var-7-value").parent().parent().remove();
                        $("#Chart7").parent().parent().remove();
                        $("#Chart_history_7").parent().parent().remove();
                        $(".var_7_class").remove();
                        // Chart7.options.scales['y'].display = false;
                        // Chart7.options.plugins.legend.display = false;
                        // Chart7.data.datasets[0].hidden = true;
                    }
                    if (var8.every(checkNull)) {
                        $("#var-8-value").parent().parent().remove();
                        $("#Chart8").parent().parent().remove();
                        $("#Chart_history_8").parent().parent().remove();
                        $(".var_8_class").remove();
                        // Chart8.options.scales['y'].display = false;
                        // Chart8.options.plugins.legend.display = false;
                        // Chart8.data.datasets[0].hidden = true;
                    }
                    if (var9.every(checkNull)) {
                        $("#var-9-value").parent().parent().remove();
                        $("#Chart9").parent().parent().remove();
                        $("#Chart_history_9").parent().parent().remove();
                        $(".var_9_class").remove();
                        // Chart9.options.scales['y'].display = false;
                        // Chart9.options.plugins.legend.display = false;
                        // Chart9.data.datasets[0].hidden = true;
                    }

                    Chart0.data.datasets[0].data = var0;
                    Chart0.data.labels = label;
                    Chart0.update();

                    Chart1.data.datasets[0].data = var1;
                    Chart1.data.labels = label;
                    Chart1.update();

                    Chart2.data.datasets[0].data = var2;
                    Chart2.data.labels = label;
                    Chart2.update();

                    Chart3.data.datasets[0].data = var3;
                    Chart3.data.labels = label;
                    Chart3.update();

                    Chart4.data.datasets[0].data = var4;
                    Chart4.data.labels = label;
                    Chart4.update();

                    Chart5.data.datasets[0].data = var5;
                    Chart5.data.labels = label;
                    Chart5.update();

                    Chart6.data.datasets[0].data = var6;
                    Chart6.data.labels = label;
                    Chart6.update();

                    Chart7.data.datasets[0].data = var7;
                    Chart7.data.labels = label;
                    Chart7.update();

                    Chart8.data.datasets[0].data = var8;
                    Chart8.data.labels = label;
                    Chart8.update();

                    Chart9.data.datasets[0].data = var9;
                    Chart9.data.labels = label;
                    Chart9.update();

                    $(".overlay").fadeOut(100);
                    setInterval(updateLastData, 30000); // 1000 = 1 second
                    setInterval(updateStatus, 30000); // 1000 = 1 second
                }
                catch (err) {
                    console.log(err.message);
                    overlayNodata();
                }
            },
            error: function () {
                overlayNodata();
            }
        })
    };

    function updateLastData() {
        $.ajax({
            url: "ajax/custom/custom.php",
            type: "post",
            data: {
                id: esp_id,
                skey: sk,
                data: "sec",
                point: 1
            },
            success: function (data) {

                var json = JSON.parse(data);
                let fulltime = json.time[0];

                if (label[label.length - 1] != fulltime) {

                    if (label.length > 500) {
                        label.shift();
                        var0.shift();
                        var1.shift();
                        var2.shift();
                        var3.shift();
                        var4.shift();
                        var5.shift();
                        var6.shift();
                        var7.shift();
                        var8.shift();
                        var9.shift();
                    }

                    var0.push(json.var0[0]);
                    var1.push(json.var1[0]);
                    var2.push(json.var2[0]);
                    var3.push(json.var3[0]);
                    var4.push(json.var4[0]);
                    var5.push(json.var5[0]);
                    var6.push(json.var6[0]);
                    var7.push(json.var7[0]);
                    var8.push(json.var8[0]);
                    var9.push(json.var9[0]);
                    label.push(json.time[0]);

                    $("#var-0-value").html(json.var0[0]);
                    $("#var-1-value").html(json.var1[0]);
                    $("#var-2-value").html(json.var2[0]);
                    $("#var-3-value").html(json.var3[0]);
                    $("#var-4-value").html(json.var4[0]);
                    $("#var-5-value").html(json.var5[0]);
                    $("#var-6-value").html(json.var6[0]);
                    $("#var-7-value").html(json.var7[0]);
                    $("#var-8-value").html(json.var8[0]);
                    $("#var-9-value").html(json.var9[0]);
                    $("#time").html(json.time[0]);

                    Chart0.update();
                    Chart1.update();
                    Chart2.update();
                    Chart3.update();
                    Chart4.update();
                    Chart5.update();
                    Chart6.update();
                    Chart7.update();
                    Chart8.update();
                    Chart9.update();
                }
                lastupdate = json.lastupdate;
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

    // for tab select
    $("#overview_option").click(function () {

        $("#value").show();
        $("#io").show();
        $("#chart").show();
        $("#Chartday").show();
        $(".overview-page").show();
        $("#uplot").hide();
        $("#google_table").hide();
        $(".setting-page").hide();
        $("#Charthistory").hide();
        $("#Chart1").show();
        $("#range_display").hide();
        $(".history_view_class").hide();
        $(".history_option_class").hide();
        $('#chart_name').text('ค่าล่าสุด');
        $(".month-view-page").hide();
        $(".day-view-page").hide();

        if (label.length) $(".overlay").hide();
        else overlayNodata();

        // Chart0.data.datasets[0].data = var0;
        // Chart0.data.datasets[1].data = var1;
        // Chart0.data.labels = label;
        // Chart0.update();

    });

    // for tab select
    $("#history_option, #day_view").click(function () {

        $("#value").hide();
        $("#io").hide();
        $(".overview-page").hide();
        $("#chart").show();
        $("#Chartday").hide();
        $("#uplot").hide();
        $("#google_table").hide();
        $(".setting-page").hide();
        $("#Charthistory").show();
        $("#Chart1").hide();
        $("#range_display").show();
        $(".history_option_class").show();
        $(".history_view_class").hide();
        $(".month-view-page").hide();
        $(".day-view-page").show();

        $("#day_view").addClass("active");
        $("#mouth_view,#history_view").removeClass("active");

        $('#chart_name').text('ค่าวันนี้');
        Chart_history_0.resetZoom();
        Chart_history_1.resetZoom();
        Chart_history_2.resetZoom();
        Chart_history_3.resetZoom();
        Chart_history_4.resetZoom();
        Chart_history_5.resetZoom();
        Chart_history_6.resetZoom();
        Chart_history_7.resetZoom();
        Chart_history_8.resetZoom();
        Chart_history_9.resetZoom();
        Chart_history_0.options.scales['x'].title.text = "เวลา";
        Chart_history_1.options.scales['x'].title.text = "เวลา";
        Chart_history_2.options.scales['x'].title.text = "เวลา";
        Chart_history_3.options.scales['x'].title.text = "เวลา";
        Chart_history_4.options.scales['x'].title.text = "เวลา";
        Chart_history_5.options.scales['x'].title.text = "เวลา";
        Chart_history_6.options.scales['x'].title.text = "เวลา";
        Chart_history_7.options.scales['x'].title.text = "เวลา";
        Chart_history_8.options.scales['x'].title.text = "เวลา";
        Chart_history_9.options.scales['x'].title.text = "เวลา";

        if (label_day.length == 0) { // if empty array let get new

            $(".overlay").show();

            $.post('ajax/custom/custom.php', {
                id: esp_id,
                skey: sk,
                data: "sec",
                range: {
                    start: moment().startOf('days').format('YYYY-MM-DD HH:mm:ss'),
                    end: moment().format('YYYY-MM-DD HH:mm:ss')
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

                    var0_today = json.var0;
                    var0_today.reverse();
                    var1_today = json.var1;
                    var1_today.reverse();
                    var2_today = json.var2;
                    var2_today.reverse();
                    var3_today = json.var3;
                    var3_today.reverse();
                    var4_today = json.var4;
                    var4_today.reverse();
                    var5_today = json.var5;
                    var5_today.reverse();
                    var6_today = json.var6;
                    var6_today.reverse();
                    var7_today = json.var7;
                    var7_today.reverse();
                    var8_today = json.var8;
                    var8_today.reverse();
                    var9_today = json.var9;
                    var9_today.reverse();
                    let fulltime = json.time;
                    fulltime.reverse();
                    label_day = [];
                    for (var count = 0; count < fulltime.length; count++) {
                        let timesplit = String(fulltime[count]).split(" ");
                        label_day.push(timesplit[1]);
                    }

                    Chart_history_0.type = 'line';
                    Chart_history_0.data.datasets[0].data = var0_today;
                    Chart_history_0.data.datasets[0].type = 'line';
                    Chart_history_0.options.plugins.datalabels.display = false;
                    Chart_history_0.options.plugins.title.text = var0_label;
                    Chart_history_1.type = 'line';
                    Chart_history_1.data.datasets[0].data = var1_today;
                    Chart_history_1.data.datasets[0].type = 'line';
                    Chart_history_1.options.plugins.datalabels.display = false;
                    Chart_history_1.options.plugins.title.text = var1_label;
                    Chart_history_2.type = 'line';
                    Chart_history_2.data.datasets[0].data = var2_today;
                    Chart_history_2.data.datasets[0].type = 'line';
                    Chart_history_2.options.plugins.datalabels.display = false;
                    Chart_history_2.options.plugins.title.text = var2_label;
                    Chart_history_3.type = 'line';
                    Chart_history_3.data.datasets[0].data = var3_today;
                    Chart_history_3.data.datasets[0].type = 'line';
                    Chart_history_3.options.plugins.datalabels.display = false;
                    Chart_history_3.options.plugins.title.text = var3_label;
                    Chart_history_4.type = 'line';
                    Chart_history_4.data.datasets[0].data = var4_today;
                    Chart_history_4.data.datasets[0].type = 'line';
                    Chart_history_4.options.plugins.datalabels.display = false;
                    Chart_history_4.options.plugins.title.text = var4_label;
                    Chart_history_5.type = 'line';
                    Chart_history_5.data.datasets[0].data = var5_today;
                    Chart_history_5.data.datasets[0].type = 'line';
                    Chart_history_5.options.plugins.datalabels.display = false;
                    Chart_history_5.options.plugins.title.text = var5_label;
                    Chart_history_6.type = 'line';
                    Chart_history_6.data.datasets[0].data = var6_today;
                    Chart_history_6.data.datasets[0].type = 'line';
                    Chart_history_6.options.plugins.datalabels.display = false;
                    Chart_history_6.options.plugins.title.text = var6_label;
                    Chart_history_7.type = 'line';
                    Chart_history_7.data.datasets[0].data = var7_today;
                    Chart_history_7.data.datasets[0].type = 'line';
                    Chart_history_7.options.plugins.datalabels.display = false;
                    Chart_history_7.options.plugins.title.text = var7_label;
                    Chart_history_8.type = 'line';
                    Chart_history_8.data.datasets[0].data = var8_today;
                    Chart_history_8.data.datasets[0].type = 'line';
                    Chart_history_8.options.plugins.datalabels.display = false;
                    Chart_history_8.options.plugins.title.text = var8_label;
                    Chart_history_9.type = 'line';
                    Chart_history_9.data.datasets[0].data = var9_today;
                    Chart_history_9.data.datasets[0].type = 'line';
                    Chart_history_9.options.plugins.datalabels.display = false;
                    Chart_history_9.options.plugins.title.text = var9_label;

                    Chart_history_0.data.labels = label_day;
                    Chart_history_1.data.labels = label_day;
                    Chart_history_2.data.labels = label_day;
                    Chart_history_3.data.labels = label_day;
                    Chart_history_4.data.labels = label_day;
                    Chart_history_5.data.labels = label_day;
                    Chart_history_6.data.labels = label_day;
                    Chart_history_7.data.labels = label_day;
                    Chart_history_8.data.labels = label_day;
                    Chart_history_9.data.labels = label_day;

                    Chart_history_0.update();
                    Chart_history_1.update();
                    Chart_history_2.update();
                    Chart_history_3.update();
                    Chart_history_4.update();
                    Chart_history_5.update();
                    Chart_history_6.update();
                    Chart_history_7.update();
                    Chart_history_8.update();
                    Chart_history_9.update();

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

            Chart_history_0.type = 'line';
            Chart_history_0.data.datasets[0].data = var0_today;
            Chart_history_0.data.datasets[0].type = 'line';
            Chart_history_0.options.plugins.datalabels.display = false;
            Chart_history_1.type = 'line';
            Chart_history_1.data.datasets[0].data = var1_today;
            Chart_history_1.data.datasets[0].type = 'line';
            Chart_history_1.options.plugins.datalabels.display = false;
            Chart_history_2.type = 'line';
            Chart_history_2.data.datasets[0].data = var2_today;
            Chart_history_2.data.datasets[0].type = 'line';
            Chart_history_2.options.plugins.datalabels.display = false;
            Chart_history_3.type = 'line';
            Chart_history_3.data.datasets[0].data = var3_today;
            Chart_history_3.data.datasets[0].type = 'line';
            Chart_history_3.options.plugins.datalabels.display = false;
            Chart_history_4.type = 'line';
            Chart_history_4.data.datasets[0].data = var4_today;
            Chart_history_4.data.datasets[0].type = 'line';
            Chart_history_4.options.plugins.datalabels.display = false;
            Chart_history_5.type = 'line';
            Chart_history_5.data.datasets[0].data = var5_today;
            Chart_history_5.data.datasets[0].type = 'line';
            Chart_history_5.options.plugins.datalabels.display = false;
            Chart_history_6.type = 'line';
            Chart_history_6.data.datasets[0].data = var6_today;
            Chart_history_6.data.datasets[0].type = 'line';
            Chart_history_6.options.plugins.datalabels.display = false;
            Chart_history_7.type = 'line';
            Chart_history_7.data.datasets[0].data = var7_today;
            Chart_history_7.data.datasets[0].type = 'line';
            Chart_history_7.options.plugins.datalabels.display = false;
            Chart_history_8.type = 'line';
            Chart_history_8.data.datasets[0].data = var8_today;
            Chart_history_8.data.datasets[0].type = 'line';
            Chart_history_8.options.plugins.datalabels.display = false;
            Chart_history_9.type = 'line';
            Chart_history_9.data.datasets[0].data = var9_today;
            Chart_history_9.data.datasets[0].type = 'line';
            Chart_history_9.options.plugins.datalabels.display = false;

            Chart_history_0.data.labels = label_day;
            Chart_history_1.data.labels = label_day;
            Chart_history_2.data.labels = label_day;
            Chart_history_3.data.labels = label_day;
            Chart_history_4.data.labels = label_day;
            Chart_history_5.data.labels = label_day;
            Chart_history_6.data.labels = label_day;
            Chart_history_7.data.labels = label_day;
            Chart_history_8.data.labels = label_day;
            Chart_history_9.data.labels = label_day;

            Chart_history_0.update();
            Chart_history_1.update();
            Chart_history_2.update();
            Chart_history_3.update();
            Chart_history_4.update();
            Chart_history_5.update();
            Chart_history_6.update();
            Chart_history_7.update();
            Chart_history_8.update();
            Chart_history_9.update();

        }
    });

    // for tab select
    $("#mouth_view").click(function () {

        $("#chart").show();
        $(".overview-page").hide();
        $("#uplot").hide();
        $("#google_table").hide();
        $(".setting-page").hide();
        $("#Charthistory").show();
        $("#Chart1").hide();
        $("#Chartday").hide();
        $(".history_option_class").show();
        $(".history_view_class").hide();
        $(".month-view-page").show();
        $(".day-view-page").hide();

        Chart_history_0.resetZoom();
        Chart_history_1.resetZoom();
        Chart_history_2.resetZoom();
        Chart_history_3.resetZoom();
        Chart_history_4.resetZoom();
        Chart_history_5.resetZoom();
        Chart_history_6.resetZoom();
        Chart_history_7.resetZoom();
        Chart_history_8.resetZoom();
        Chart_history_9.resetZoom();
        Chart_history_0.options.scales['x'].title.text = "วันที่";
        Chart_history_1.options.scales['x'].title.text = "วันที่";
        Chart_history_2.options.scales['x'].title.text = "วันที่";
        Chart_history_3.options.scales['x'].title.text = "วันที่";
        Chart_history_4.options.scales['x'].title.text = "วันที่";
        Chart_history_5.options.scales['x'].title.text = "วันที่";
        Chart_history_6.options.scales['x'].title.text = "วันที่";
        Chart_history_7.options.scales['x'].title.text = "วันที่";
        Chart_history_8.options.scales['x'].title.text = "วันที่";
        Chart_history_9.options.scales['x'].title.text = "วันที่";
        $('#chart_name').text('ค่าเฉลี่ยในแต่ละวัน');

        if (label_mouth.length == 0) { // if empty array let get new

            $(".overlay").show();

            $.post('ajax/custom/custom.php', {
                id: esp_id,
                skey: sk,
                data: "day",
                range: {
                    start: moment().subtract(2, 'month').startOf('month').format('YYYY-MM-DD'),
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

                    var0_thismouth = json.var0;
                    var0_thismouth.reverse();
                    var1_thismouth = json.var1;
                    var1_thismouth.reverse();
                    var2_thismouth = json.var2;
                    var2_thismouth.reverse();
                    var3_thismouth = json.var3;
                    var3_thismouth.reverse();
                    var4_thismouth = json.var4;
                    var4_thismouth.reverse();
                    var5_thismouth = json.var5;
                    var5_thismouth.reverse();
                    var6_thismouth = json.var6;
                    var6_thismouth.reverse();
                    var7_thismouth = json.var7;
                    var7_thismouth.reverse();
                    var8_thismouth = json.var8;
                    var8_thismouth.reverse();
                    var9_thismouth = json.var9;
                    var9_thismouth.reverse();

                    fulldate = json.time;
                    fulldate.reverse();
                    label_mouth = [];
                    for (var count = 0; count < fulldate.length; count++) {
                        let timesplit = String(fulldate[count]).split("-");
                        label_mouth.push(timesplit[2]);
                    }

                    Chart_history_0.data.datasets[0].type = 'bar';
                    Chart_history_0.data.datasets[0].data = var0_thismouth;
                    Chart_history_0.data.labels = label_mouth;
                    Chart_history_0.options.plugins.datalabels.display = true;

                    Chart_history_1.data.datasets[0].type = 'bar';
                    Chart_history_1.data.datasets[0].data = var1_thismouth;
                    Chart_history_1.data.labels = label_mouth;
                    Chart_history_1.options.plugins.datalabels.display = true;

                    Chart_history_2.data.datasets[0].type = 'bar';
                    Chart_history_2.data.datasets[0].data = var2_thismouth;
                    Chart_history_2.data.labels = label_mouth;
                    Chart_history_2.options.plugins.datalabels.display = true;

                    Chart_history_3.data.datasets[0].type = 'bar';
                    Chart_history_3.data.datasets[0].data = var3_thismouth;
                    Chart_history_3.data.labels = label_mouth;
                    Chart_history_3.options.plugins.datalabels.display = true;

                    Chart_history_4.data.datasets[0].type = 'bar';
                    Chart_history_4.data.datasets[0].data = var4_thismouth;
                    Chart_history_4.data.labels = label_mouth;
                    Chart_history_4.options.plugins.datalabels.display = true;

                    Chart_history_5.data.datasets[0].type = 'bar';
                    Chart_history_5.data.datasets[0].data = var5_thismouth;
                    Chart_history_5.data.labels = label_mouth;
                    Chart_history_5.options.plugins.datalabels.display = true;

                    Chart_history_6.data.datasets[0].type = 'bar';
                    Chart_history_6.data.datasets[0].data = var6_thismouth;
                    Chart_history_6.data.labels = label_mouth;
                    Chart_history_6.options.plugins.datalabels.display = true;

                    Chart_history_7.data.datasets[0].type = 'bar';
                    Chart_history_7.data.datasets[0].data = var7_thismouth;
                    Chart_history_7.data.labels = label_mouth;
                    Chart_history_7.options.plugins.datalabels.display = true;

                    Chart_history_8.data.datasets[0].type = 'bar';
                    Chart_history_8.data.datasets[0].data = var8_thismouth;
                    Chart_history_8.data.labels = label_mouth;
                    Chart_history_8.options.plugins.datalabels.display = true;

                    Chart_history_9.data.datasets[0].type = 'bar';
                    Chart_history_9.data.datasets[0].data = var9_thismouth;
                    Chart_history_9.data.labels = label_mouth;
                    Chart_history_9.options.plugins.datalabels.display = true;

                    Chart_history_0.update();
                    Chart_history_1.update();
                    Chart_history_2.update();
                    Chart_history_3.update();
                    Chart_history_4.update();
                    Chart_history_5.update();
                    Chart_history_6.update();
                    Chart_history_7.update();
                    Chart_history_8.update();
                    Chart_history_9.update();

                })
                .fail(function () {

                    $(".overlay").fadeOut(200);
                    $('.toast').removeClass('bg-success bg-warning').addClass('bg-danger');
                    $('#toast-body').text("โหลดข้อมูลไม่สำเร็จ โปรดลองใหม่อีกครั้ง");
                    $('.toast').toast('show');

                });
        } else {

            Chart_history_0.data.datasets[0].type = 'bar';
            Chart_history_0.data.datasets[0].data = var0_thismouth;
            Chart_history_0.data.labels = label_mouth;
            Chart_history_0.options.plugins.datalabels.display = true;

            Chart_history_1.data.datasets[0].type = 'bar';
            Chart_history_1.data.datasets[0].data = var1_thismouth;
            Chart_history_1.data.labels = label_mouth;
            Chart_history_1.options.plugins.datalabels.display = true;

            Chart_history_2.data.datasets[0].type = 'bar';
            Chart_history_2.data.datasets[0].data = var2_thismouth;
            Chart_history_2.data.labels = label_mouth;
            Chart_history_2.options.plugins.datalabels.display = true;

            Chart_history_3.data.datasets[0].type = 'bar';
            Chart_history_3.data.datasets[0].data = var3_thismouth;
            Chart_history_3.data.labels = label_mouth;
            Chart_history_3.options.plugins.datalabels.display = true;

            Chart_history_4.data.datasets[0].type = 'bar';
            Chart_history_4.data.datasets[0].data = var4_thismouth;
            Chart_history_4.data.labels = label_mouth;
            Chart_history_4.options.plugins.datalabels.display = true;

            Chart_history_5.data.datasets[0].type = 'bar';
            Chart_history_5.data.datasets[0].data = var5_thismouth;
            Chart_history_5.data.labels = label_mouth;
            Chart_history_5.options.plugins.datalabels.display = true;

            Chart_history_6.data.datasets[0].type = 'bar';
            Chart_history_6.data.datasets[0].data = var6_thismouth;
            Chart_history_6.data.labels = label_mouth;
            Chart_history_6.options.plugins.datalabels.display = true;

            Chart_history_7.data.datasets[0].type = 'bar';
            Chart_history_7.data.datasets[0].data = var7_thismouth;
            Chart_history_7.data.labels = label_mouth;
            Chart_history_7.options.plugins.datalabels.display = true;

            Chart_history_8.data.datasets[0].type = 'bar';
            Chart_history_8.data.datasets[0].data = var8_thismouth;
            Chart_history_8.data.labels = label_mouth;
            Chart_history_8.options.plugins.datalabels.display = true;

            Chart_history_9.data.datasets[0].type = 'bar';
            Chart_history_9.data.datasets[0].data = var9_thismouth;
            Chart_history_9.data.labels = label_mouth;
            Chart_history_9.options.plugins.datalabels.display = true;

            Chart_history_0.update();
            Chart_history_1.update();
            Chart_history_2.update();
            Chart_history_3.update();
            Chart_history_4.update();
            Chart_history_5.update();
            Chart_history_6.update();
            Chart_history_7.update();
            Chart_history_8.update();
            Chart_history_9.update();
        }

        $("#month_csvdownload").click(function () {
            var data = [["time", var0_label, var1_label, var2_label, var3_label, var4_label, var5_label, var6_label, var7_label, var8_label, var9_label,]];

            // console.log(label_history.length);return;

            for (var count = 0; count < fulldate.length; count++) {
                data.push([fulldate[count], var0_thismouth[count], var1_thismouth[count], var2_thismouth[count], var3_thismouth[count], var4_thismouth[count], var5_thismouth[count], var6_thismouth[count], var7_thismouth[count], var8_thismouth[count], var9_thismouth[count]]);
            }

            let csvContent = "data:text/csv;charset=utf-8," +
                data.map(e => e.join(",")).join("\n");

            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", fulldate[0] + "_to_" + fulldate[fulldate.length - 1] + "_data.csv");
            document.body.appendChild(link);
            link.click();
        });

        $("#month-line").click(function () {
            Chart_history_0.type = 'line';
            Chart_history_0.data.datasets[0].type = 'line';
            Chart_history_1.type = 'line';
            Chart_history_1.data.datasets[0].type = 'line';
            Chart_history_2.type = 'line';
            Chart_history_2.data.datasets[0].type = 'line';
            Chart_history_3.type = 'line';
            Chart_history_3.data.datasets[0].type = 'line';
            Chart_history_4.type = 'line';
            Chart_history_4.data.datasets[0].type = 'line';
            Chart_history_5.type = 'line';
            Chart_history_5.data.datasets[0].type = 'line';
            Chart_history_6.type = 'line';
            Chart_history_6.data.datasets[0].type = 'line';
            Chart_history_7.type = 'line';
            Chart_history_7.data.datasets[0].type = 'line';
            Chart_history_8.type = 'line';
            Chart_history_8.data.datasets[0].type = 'line';
            Chart_history_9.type = 'line';
            Chart_history_9.data.datasets[0].type = 'line';
            Chart_history_0.update();
            Chart_history_1.update();
            Chart_history_2.update();
            Chart_history_3.update();
            Chart_history_4.update();
            Chart_history_5.update();
            Chart_history_6.update();
            Chart_history_7.update();
            Chart_history_8.update();
            Chart_history_9.update();
        });

        $("#month-bar").click(function () {
            Chart_history_0.type = 'bar';
            Chart_history_0.data.datasets[0].type = 'bar';
            Chart_history_1.type = 'bar';
            Chart_history_1.data.datasets[0].type = 'bar';
            Chart_history_2.type = 'bar';
            Chart_history_2.data.datasets[0].type = 'bar';
            Chart_history_3.type = 'bar';
            Chart_history_3.data.datasets[0].type = 'bar';
            Chart_history_4.type = 'bar';
            Chart_history_4.data.datasets[0].type = 'bar';
            Chart_history_5.type = 'bar';
            Chart_history_5.data.datasets[0].type = 'bar';
            Chart_history_6.type = 'bar';
            Chart_history_6.data.datasets[0].type = 'bar';
            Chart_history_7.type = 'bar';
            Chart_history_7.data.datasets[0].type = 'bar';
            Chart_history_8.type = 'bar';
            Chart_history_8.data.datasets[0].type = 'bar';
            Chart_history_9.type = 'bar';
            Chart_history_9.data.datasets[0].type = 'bar';
            Chart_history_0.update();
            Chart_history_1.update();
            Chart_history_2.update();
            Chart_history_3.update();
            Chart_history_4.update();
            Chart_history_5.update();
            Chart_history_6.update();
            Chart_history_7.update();
            Chart_history_8.update();
            Chart_history_9.update();
        });

    });

    // for tab select
    $("#history_view").click(function () {

        $("#chart").show();
        $(".overview-page").hide();
        $(".setting-page").hide();
        $("#uplot").show();
        $("#google_table").show();
        $("#Chart1").hide();
        $("#Chartday").hide();
        $("#Charthistory").hide();
        $("#uplot").show();
        $(".history_option_class").show();
        $(".history_view_class").show();
        $(".month-view-page").hide();
        $(".day-view-page").hide();

        $('#chart_name').text('ข้อมูลย้อนหลัง');

        if (typeof uplot === 'undefined') cbTimerange(moment().startOf('days'), moment());

    });

    $("#setting_option").click(function () {

        $("#value").hide();
        $("#io").hide();
        $("#chart").hide();
        $("#Chartday").hide();
        $("#uplot").hide();
        $("#google_table").hide();
        $(".setting-page").show();
        $(".overview-page").hide();
        $(".month-view-page").hide();
        $(".day-view-page").hide();

        if (typeof setting === 'undefined') {
            getlinedata();
        }
    });

    $('#linedata-save').click(function () {

        // console.log($('#dailynotify').prop('checked') ? 1 : 0);

        $.post('ajax/setting.php', {
            id: esp_id,
            skey: sk,
            p_id: 0,
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
                p_id: 0
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
                height: document.getElementById(elementId).offsetHeight - 100,
            }
        }

        let data = [label_timestamp, var0_history, var1_history, var2_history, var3_history, var4_history, var5_history, var6_history, var7_history, var8_history, var9_history];

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
                        show: true,

                        spanGaps: true,

                        // in-legend display
                        label: var0_label,
                        // scale: "t",
                        value: (self, rawValue) => rawValue.toFixed(1),

                        stroke: "rgba(255, 0, 0, 1)",
                        width: 2,
                        fill: "rgba(255, 0, 0, 0.1)"
                    },
                    {
                        // initial toggled state (optional)
                        show: false,

                        spanGaps: true,

                        // in-legend display
                        label: var1_label,
                        // scale: "h",
                        value: (self, rawValue) => rawValue.toFixed(1),

                        stroke: "rgba(0, 0, 255, 1)",
                        width: 2,
                        fill: "rgba(0, 0, 255, 0.1)"
                    },
                    {
                        // initial toggled state (optional)
                        show: false,

                        spanGaps: true,

                        // in-legend display
                        label: var2_label,
                        // scale: "h",
                        value: (self, rawValue) => rawValue.toFixed(1),

                        stroke: "rgba(0, 255,0,  1)",
                        width: 2,
                        fill: "rgba(0, 255,0,  0.1)"
                    },
                    {
                        // initial toggled state (optional)
                        show: false,

                        spanGaps: true,

                        // in-legend display
                        label: var3_label,
                        // scale: "h",
                        value: (self, rawValue) => rawValue.toFixed(1),

                        stroke: "rgba(128, 0, 255, 1)",
                        width: 2,
                        fill: "rgba(128, 0, 255, 0.1)"
                    },
                    {
                        // initial toggled state (optional)
                        show: false,

                        spanGaps: true,

                        // in-legend display
                        label: var4_label,
                        // scale: "h",
                        value: (self, rawValue) => rawValue.toFixed(1),

                        stroke: "rgba(0, 128, 255, 1)",
                        width: 2,
                        fill: "rgba(0, 128, 255, 0.1)"
                    },
                    {
                        // initial toggled state (optional)
                        show: false,

                        spanGaps: true,

                        // in-legend display
                        label: var5_label,
                        // scale: "h",
                        value: (self, rawValue) => rawValue.toFixed(1),

                        stroke: "rgba(128, 128, 255, 1)",
                        width: 2,
                        fill: "rgba(128, 128, 255, 0.1)"
                    },
                    {
                        // initial toggled state (optional)
                        show: false,

                        spanGaps: true,

                        // in-legend display
                        label: var6_label,
                        // scale: "h",
                        value: (self, rawValue) => rawValue.toFixed(1),

                        stroke: "rgba(128, 0, 128, 1)",
                        width: 2,
                        fill: "rgba(128, 0, 128, 0.1)"
                    },
                    {
                        // initial toggled state (optional)
                        show: false,

                        spanGaps: true,

                        // in-legend display
                        label: var7_label,
                        // scale: "h",
                        value: (self, rawValue) => rawValue.toFixed(1),

                        stroke: "rgba(0, 128, 128, 1)",
                        width: 2,
                        fill: "rgba(0, 128, 128, 0.1)"
                    },
                    {
                        // initial toggled state (optional)
                        show: false,

                        spanGaps: true,

                        // in-legend display
                        label: var8_label,
                        // scale: "h",
                        value: (self, rawValue) => rawValue.toFixed(1),

                        stroke: "rgba(128, 128, 0, 1)",
                        width: 2,
                        fill: "rgba(128, 128, 0, 0.1)"
                    },
                    {
                        // initial toggled state (optional)
                        show: false,

                        spanGaps: true,

                        // in-legend display
                        label: var9_label,
                        // scale: "h",
                        value: (self, rawValue) => rawValue.toFixed(1),

                        stroke: "rgba(64, 128, 32, 1)",
                        width: 2,
                        fill: "rgba(64, 128, 32, 0.1)"
                    },
                ],
                axes: [
                    {
                        // space: 50,
                        // size: 30,
                        label: "เวลา",
                        labelSize: 20,
                        stroke: "white",
                    },
                    {
                        label: "values",
                        stroke: "rgb(255, 255, 255)",
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
        for (var count = label_timestamp.length - 1; count >= 0; count--) {
            let dateFormat = new Date(label_timestamp[count] * 1000);
            let thisdate = dateFormat.getFullYear() + "-" + ("0" + (dateFormat.getMonth() + 1)).substr(-2) + "-" + ("0" + dateFormat.getDate()).substr(-2) + " " + ("0" + dateFormat.getHours()).substr(-2) + ":" + ("0" + dateFormat.getMinutes()).substr(-2) + ":" + ("0" + dateFormat.getSeconds()).substr(-2);
            google_data.push([var0_history[count], var1_history[count], var2_history[count], var3_history[count], var4_history[count], var5_history[count], var6_history[count], var7_history[count], var8_history[count], var9_history[count], thisdate]);
        }

        google.charts.load('current', { 'packages': ['table'] });
        google.charts.setOnLoadCallback(drawTable);

        function drawTable() {
            var data = new google.visualization.DataTable();
            data.addColumn('number', var0_label);
            data.addColumn('number', var1_label);
            data.addColumn('number', var2_label);
            data.addColumn('number', var3_label);
            data.addColumn('number', var4_label);
            data.addColumn('number', var5_label);
            data.addColumn('number', var6_label);
            data.addColumn('number', var7_label);
            data.addColumn('number', var8_label);
            data.addColumn('number', var9_label);
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
        if (minutesdiff <= 60 * 24 * 7 && minutesfromnow <= 60 * 24 * 7) {
            datarange = "sec";
            $("#history-rawdata").hide();
            $("#history-minute").show();
            $("#history-hourly").show();
            if (minutesdiff > 60 * 24) {
                $("#history-daily").show();
            }
            else {
                $("#history-daily").hide();
            }
        }
        else if (minutesdiff <= 60 * 24 * 31 * 3 && minutesfromnow <= 60 * 24 * 31 * 3) {
            datarange = "hr";
            $("#history-rawdata").hide();
            $("#history-minute").hide();
            $("#history-hourly").hide();
            $("#history-daily").show();
        }
        else {
            datarange = "day";
            $("#history-rawdata").hide();
            $("#history-minute").hide();
            $("#history-hourly").hide();
            $("#history-daily").hide();
        }

        $(".overlay").show(100);

        $.ajax({
            url: "ajax/custom/custom.php",
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
                json.var0.reverse();
                json.var1.reverse();
                json.var2.reverse();
                json.var3.reverse();
                json.var4.reverse();
                json.var5.reverse();
                json.var6.reverse();
                json.var7.reverse();
                json.var8.reverse();
                json.var9.reverse();
                json.time.reverse();

                var0_history = [];
                for (var count = 0; count < json.var0.length; count++) {
                    var0_history.push(parseFloat(json.var0[count]));
                }
                var1_history = [];
                for (var count = 0; count < json.var1.length; count++) {
                    var1_history.push(parseFloat(json.var1[count]));
                }
                var2_history = [];
                for (var count = 0; count < json.var2.length; count++) {
                    var2_history.push(parseFloat(json.var2[count]));
                }
                var3_history = [];
                for (var count = 0; count < json.var3.length; count++) {
                    var3_history.push(parseFloat(json.var3[count]));
                }
                var4_history = [];
                for (var count = 0; count < json.var4.length; count++) {
                    var4_history.push(parseFloat(json.var4[count]));
                }
                var5_history = [];
                for (var count = 0; count < json.var5.length; count++) {
                    var5_history.push(parseFloat(json.var5[count]));
                }
                var6_history = [];
                for (var count = 0; count < json.var6.length; count++) {
                    var6_history.push(parseFloat(json.var6[count]));
                }
                var7_history = [];
                for (var count = 0; count < json.var7.length; count++) {
                    var7_history.push(parseFloat(json.var7[count]));
                }
                var8_history = [];
                for (var count = 0; count < json.var8.length; count++) {
                    var8_history.push(parseFloat(json.var8[count]));
                }
                var9_history = [];
                for (var count = 0; count < json.var9.length; count++) {
                    var9_history.push(parseFloat(json.var9[count]));
                }

                // for save as csv
                label_history = json.time;

                // convert string to time stamp for uplot
                label_timestamp = [];
                for (var count = 0; count < json.time.length; count++) {
                    label_timestamp.push(Date.parse(json.time[count]) / 1000);
                }

                // console.log(power_history);
                // console.log(label_timestamp);

                $(".overlay").fadeOut(100);

                if (label_history.length != 0) {

                    raw_var0_history = var0_history;
                    raw_var1_history = var1_history;
                    raw_var2_history = var2_history;
                    raw_var3_history = var3_history;
                    raw_var4_history = var4_history;
                    raw_var5_history = var5_history;
                    raw_var6_history = var6_history;
                    raw_var7_history = var7_history;
                    raw_var8_history = var8_history;
                    raw_var9_history = var9_history;
                    raw_label_history = label_history;
                    raw_label_timestamp = label_timestamp;

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
        startDate: moment().subtract(1, 'hour'),
        endDate: moment()
    }, cbTimerange);


    $("#csvdownload").click(function () {
        var data = [
            ["time", var0_label, var1_label, var2_label, var3_label, var4_label, var5_label, var6_label, var7_label, var8_label, var9_label,]
        ];

        // console.log(label_history.length);return;

        for (var count = 0; count < label_history.length; count++) {
            data.push([label_history[count], var0_history[count], var1_history[count], var2_history[count], var3_history[count], var4_history[count], var5_history[count], var6_history[count], var7_history[count], var8_history[count], var9_history[count]]);
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


    $("#history-minute").click(function () {
        if (raw_label_history.length == 0) return;

        var new_label_timestamp = [];
        label_split = ['2000-00-00 99', '99', '00'];
        var new_var0_history = [], new_var1_history = [], new_var2_history = [], new_var3_history = [], new_var4_history = [], new_var5_history = [], new_var6_history = [], new_var7_history = [], new_var8_history = [], new_var9_history = [];
        let var0_buff, var1_buff, var2_buff, var3_buff, var4_buff, var5_buff, var6_buff, var7_buff, var8_buff, var9_buff, index_buff;

        for (let count = 0; count < raw_label_history.length; count++) {
            let timesplit = String(raw_label_history[count]).split(":");
            if (timesplit[1] != label_split[1]) {

                if (var0_buff || var1_buff || var2_buff || var3_buff || var4_buff || var5_buff || var6_buff || var7_buff || var8_buff || var9_buff || index_buff) {
                    new_var0_history.push(var0_buff / index_buff);
                    new_var1_history.push(var1_buff / index_buff);
                    new_var2_history.push(var2_buff / index_buff);
                    new_var3_history.push(var3_buff / index_buff);
                    new_var4_history.push(var4_buff / index_buff);
                    new_var5_history.push(var5_buff / index_buff);
                    new_var6_history.push(var6_buff / index_buff);
                    new_var7_history.push(var7_buff / index_buff);
                    new_var8_history.push(var8_buff / index_buff);
                    new_var9_history.push(var9_buff / index_buff);
                }

                label_split[0] = timesplit[0];
                label_split[1] = timesplit[1];
                var0_buff = raw_var0_history[count];
                var1_buff = raw_var1_history[count];
                var2_buff = raw_var2_history[count];
                var3_buff = raw_var3_history[count];
                var4_buff = raw_var4_history[count];
                var5_buff = raw_var5_history[count];
                var6_buff = raw_var6_history[count];
                var7_buff = raw_var7_history[count];
                var8_buff = raw_var8_history[count];
                var9_buff = raw_var9_history[count];
                index_buff = 1;
                new_label_timestamp.push(Date.parse(timesplit[0] + ":" + timesplit[1]) / 1000);
            } else {
                var0_buff += raw_var0_history[count];
                var1_buff += raw_var1_history[count];
                var2_buff += raw_var2_history[count];
                var3_buff += raw_var3_history[count];
                var4_buff += raw_var4_history[count];
                var5_buff += raw_var5_history[count];
                var6_buff += raw_var6_history[count];
                var7_buff += raw_var7_history[count];
                var8_buff += raw_var8_history[count];
                var9_buff += raw_var9_history[count];
                index_buff++;
            }

            if (count == raw_label_history.length - 1) {
                if (var0_buff || var1_buff || var2_buff || var3_buff || var4_buff || var5_buff || var6_buff || var7_buff || var8_buff || var9_buff || index_buff) {

                    new_var0_history.push(var0_buff / index_buff);
                    new_var1_history.push(var1_buff / index_buff);
                    new_var2_history.push(var2_buff / index_buff);
                    new_var3_history.push(var3_buff / index_buff);
                    new_var4_history.push(var4_buff / index_buff);
                    new_var5_history.push(var5_buff / index_buff);
                    new_var6_history.push(var6_buff / index_buff);
                    new_var7_history.push(var7_buff / index_buff);
                    new_var8_history.push(var8_buff / index_buff);
                    new_var9_history.push(var9_buff / index_buff);
                }
            }
        }
        var0_history = new_var0_history;
        var1_history = new_var1_history;
        var2_history = new_var2_history;
        var3_history = new_var3_history;
        var4_history = new_var4_history;
        var5_history = new_var5_history;
        var6_history = new_var6_history;
        var7_history = new_var7_history;
        var8_history = new_var8_history;
        var9_history = new_var9_history;

        label_timestamp = new_label_timestamp;
        console.log(label_timestamp);
        $("#history-rawdata").show();
        if (label_timestamp.length != 0) {
            uplotupdate();
            tablechart();
        }

    });

    $("#history-hourly").click(function () {

        if (raw_label_history.length == 0) return;

        var new_label_timestamp = [];
        let label_split = ['2000-00-00 99', '99', '00'];
        let hr_label_split = label_split[0].split(" ");
        var new_var0_history = [], new_var1_history = [], new_var2_history = [], new_var3_history = [], new_var4_history = [], new_var5_history = [], new_var6_history = [], new_var7_history = [], new_var8_history = [], new_var9_history = [];
        let var0_buff, var1_buff, var2_buff, var3_buff, var4_buff, var5_buff, var6_buff, var7_buff, var8_buff, var9_buff, index_buff;

        for (let count = 0; count < raw_label_history.length; count++) {
            let timesplit = String(raw_label_history[count]).split(":");
            let hr_timesplit = timesplit[0].split(" ");

            if (hr_timesplit[1] != hr_label_split[1]) {

                if (var0_buff || var1_buff || var2_buff || var3_buff || var4_buff || var5_buff || var6_buff || var7_buff || var8_buff || var9_buff || index_buff) {

                    new_var0_history.push(var0_buff / index_buff);
                    new_var1_history.push(var1_buff / index_buff);
                    new_var2_history.push(var2_buff / index_buff);
                    new_var3_history.push(var3_buff / index_buff);
                    new_var4_history.push(var4_buff / index_buff);
                    new_var5_history.push(var5_buff / index_buff);
                    new_var6_history.push(var6_buff / index_buff);
                    new_var7_history.push(var7_buff / index_buff);
                    new_var8_history.push(var8_buff / index_buff);
                    new_var9_history.push(var9_buff / index_buff);
                }

                hr_label_split[0] = hr_timesplit[0];
                hr_label_split[1] = hr_timesplit[1];
                var0_buff = raw_var0_history[count];
                var1_buff = raw_var1_history[count];
                var2_buff = raw_var2_history[count];
                var3_buff = raw_var3_history[count];
                var4_buff = raw_var4_history[count];
                var5_buff = raw_var5_history[count];
                var6_buff = raw_var6_history[count];
                var7_buff = raw_var7_history[count];
                var8_buff = raw_var8_history[count];
                var9_buff = raw_var9_history[count];
                index_buff = 1;
                new_label_timestamp.push(Date.parse(hr_label_split[0] + " " + hr_label_split[1] + ":00") / 1000);
            } else {
                var0_buff += raw_var0_history[count];
                var1_buff += raw_var1_history[count];
                var2_buff += raw_var2_history[count];
                var3_buff += raw_var3_history[count];
                var4_buff += raw_var4_history[count];
                var5_buff += raw_var5_history[count];
                var6_buff += raw_var6_history[count];
                var7_buff += raw_var7_history[count];
                var8_buff += raw_var8_history[count];
                var9_buff += raw_var9_history[count];
                index_buff++;
            }

            if (count == raw_label_history.length - 1) {
                if (var0_buff || var1_buff || var2_buff || var3_buff || var4_buff || var5_buff || var6_buff || var7_buff || var8_buff || var9_buff || index_buff) {

                    new_var0_history.push(var0_buff / index_buff);
                    new_var1_history.push(var1_buff / index_buff);
                    new_var2_history.push(var2_buff / index_buff);
                    new_var3_history.push(var3_buff / index_buff);
                    new_var4_history.push(var4_buff / index_buff);
                    new_var5_history.push(var5_buff / index_buff);
                    new_var6_history.push(var6_buff / index_buff);
                    new_var7_history.push(var7_buff / index_buff);
                    new_var8_history.push(var8_buff / index_buff);
                    new_var9_history.push(var9_buff / index_buff);
                }
            }
        }

        var0_history = new_var0_history;
        var1_history = new_var1_history;
        var2_history = new_var2_history;
        var3_history = new_var3_history;
        var4_history = new_var4_history;
        var5_history = new_var5_history;
        var6_history = new_var6_history;
        var7_history = new_var7_history;
        var8_history = new_var8_history;
        var9_history = new_var9_history;

        label_timestamp = new_label_timestamp;
        console.log(label_timestamp);
        $("#history-rawdata").show();
        if (label_timestamp.length != 0) {
            uplotupdate();
            tablechart();
        }

    });

    $("#history-daily").click(function () {


        if (raw_label_history.length == 0) return;

        var new_label_timestamp = [];
        let label_split = ['2000', '99', '00'];
        var new_var0_history = [], new_var1_history = [], new_var2_history = [], new_var3_history = [], new_var4_history = [], new_var5_history = [], new_var6_history = [], new_var7_history = [], new_var8_history = [], new_var9_history = [];
        let var0_buff, var1_buff, var2_buff, var3_buff, var4_buff, var5_buff, var6_buff, var7_buff, var8_buff, var9_buff, index_buff;

        for (let count = 0; count < raw_label_history.length; count++) {
            let timesplit = String((raw_label_history[count]).split(" ")[0]).split("-");

            if (timesplit[2] != label_split[2]) {

                if (var0_buff || var1_buff || var2_buff || var3_buff || var4_buff || var5_buff || var6_buff || var7_buff || var8_buff || var9_buff || index_buff) {

                    new_var0_history.push(var0_buff / index_buff);
                    new_var1_history.push(var1_buff / index_buff);
                    new_var2_history.push(var2_buff / index_buff);
                    new_var3_history.push(var3_buff / index_buff);
                    new_var4_history.push(var4_buff / index_buff);
                    new_var5_history.push(var5_buff / index_buff);
                    new_var6_history.push(var6_buff / index_buff);
                    new_var7_history.push(var7_buff / index_buff);
                    new_var8_history.push(var8_buff / index_buff);
                    new_var9_history.push(var9_buff / index_buff);
                }

                label_split[0] = timesplit[0];
                label_split[1] = timesplit[1];
                label_split[2] = timesplit[2];
                var0_buff = raw_var0_history[count];
                var1_buff = raw_var1_history[count];
                var2_buff = raw_var2_history[count];
                var3_buff = raw_var3_history[count];
                var4_buff = raw_var4_history[count];
                var5_buff = raw_var5_history[count];
                var6_buff = raw_var6_history[count];
                var7_buff = raw_var7_history[count];
                var8_buff = raw_var8_history[count];
                var9_buff = raw_var9_history[count];
                index_buff = 1;
                new_label_timestamp.push(Date.parse(label_split[0] + "-" + label_split[1] + "-" + label_split[2] + " 00:00") / 1000);
            } else {
                var0_buff += raw_var0_history[count];
                var1_buff += raw_var1_history[count];
                var2_buff += raw_var2_history[count];
                var3_buff += raw_var3_history[count];
                var4_buff += raw_var4_history[count];
                var5_buff += raw_var5_history[count];
                var6_buff += raw_var6_history[count];
                var7_buff += raw_var7_history[count];
                var8_buff += raw_var8_history[count];
                var9_buff += raw_var9_history[count];
                index_buff++;
            }

            if (count == raw_label_history.length - 1) {
                if (var0_buff || var1_buff || var2_buff || var3_buff || var4_buff || var5_buff || var6_buff || var7_buff || var8_buff || var9_buff || index_buff) {

                    new_var0_history.push(var0_buff / index_buff);
                    new_var1_history.push(var1_buff / index_buff);
                    new_var2_history.push(var2_buff / index_buff);
                    new_var3_history.push(var3_buff / index_buff);
                    new_var4_history.push(var4_buff / index_buff);
                    new_var5_history.push(var5_buff / index_buff);
                    new_var6_history.push(var6_buff / index_buff);
                    new_var7_history.push(var7_buff / index_buff);
                    new_var8_history.push(var8_buff / index_buff);
                    new_var9_history.push(var9_buff / index_buff);
                }
            }
        }

        var0_history = new_var0_history;
        var1_history = new_var1_history;
        var2_history = new_var2_history;
        var3_history = new_var3_history;
        var4_history = new_var4_history;
        var5_history = new_var5_history;
        var6_history = new_var6_history;
        var7_history = new_var7_history;
        var8_history = new_var8_history;
        var9_history = new_var9_history;

        label_timestamp = new_label_timestamp;
        console.log(label_timestamp);
        $("#history-rawdata").show();
        if (label_timestamp.length != 0) {
            uplotupdate();
            tablechart();
        }

    });

    $("#history-rawdata").click(function () {
        $("#history-rawdata").hide();
        var0_history = raw_var0_history;
        var1_history = raw_var1_history;
        var2_history = raw_var2_history;
        var3_history = raw_var3_history;
        var4_history = raw_var4_history;
        var5_history = raw_var5_history;
        var6_history = raw_var6_history;
        var7_history = raw_var7_history;
        var8_history = raw_var8_history;
        var9_history = raw_var9_history;
        label_timestamp = raw_label_timestamp;
        if (label_timestamp.length != 0) {
            uplotupdate();
            tablechart();
        }
    });


    $("#edit-var-form").submit(function (e) {

        e.preventDefault();

        var form = $(this);
        var actionUrl = form.attr('action');

        //add disabled
        form.attr('disabled', 'disabled');

        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(), // serializes the form's elements.
            success: function (data) {
                // $('#var-name-1').val();
                // console.log(data);
                // console.log($('#var-name-1').val());

                if (data) {
                    var0_label = $('#var-name-0').val();
                    var1_label = $('#var-name-1').val();
                    var2_label = $('#var-name-2').val();
                    var3_label = $('#var-name-3').val();
                    var4_label = $('#var-name-4').val();
                    var5_label = $('#var-name-5').val();
                    var6_label = $('#var-name-6').val();
                    var7_label = $('#var-name-7').val();
                    var8_label = $('#var-name-8').val();
                    var9_label = $('#var-name-9').val();
                    varUpdate();

                    //remove it
                    form.removeAttr("disabled");

                    $('#editvarname').modal('hide');
                }
            }
        });

    });
});