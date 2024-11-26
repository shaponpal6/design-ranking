var options = {
    series: [{ name: "Total Order", data: [4, 10, 25, 12, 25, 18, 40, 22, 7] }],
    chart: { height: 105, type: "area", sparkline: { enabled: !0 }, zoom: { enabled: !1 } },
    dataLabels: { enabled: !1 },
    stroke: { width: 2, curve: "smooth" },
    fill: { type: "gradient", gradient: { shade: "dark", gradientToColors: ["#20b799"], shadeIntensity: 1, type: "vertical", opacityFrom: 0.75, opacityTo: 0.1 } },
    colors: ["#20b799"],
    tooltip: {
        fixed: { enabled: !1 },
        x: { show: !1 },
        y: {
            title: {
                formatter: function () {
                    return "";
                },
            },
        },
        marker: { show: !1 },
    },
    xaxis: { categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep"] },
},
chart = new ApexCharts(document.querySelector("#total-order"), options),
options =
    (chart.render(),
    {
        series: [{ name: "Total Sale", data: [35, 65, 47, 35, 44, 32, 27, 54, 44, 61] }],
        chart: { height: 105, type: "area", sparkline: { enabled: !0 }, zoom: { enabled: !1 } },
        dataLabels: { enabled: !1 },
        stroke: { width: 1.5, curve: "smooth" },
        fill: { type: "gradient", gradient: { shade: "dark", gradientToColors: ["#8b5cf6"], shadeIntensity: 1, type: "vertical", opacityFrom: 0.75, opacityTo: 0.1 } },
        colors: ["#8b5cf6"],
        plotOptions: { bar: { horizontal: !1, borderRadius: 3, columnWidth: "48%" } },
        tooltip: {
            fixed: { enabled: !1 },
            x: { show: !1 },
            y: {
                title: {
                    formatter: function (e) {
                        return "";
                    },
                },
            },
            marker: { show: !1 },
        },
        xaxis: { categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep"] },
    }),
options =
    ((chart = new ApexCharts(document.querySelector("#total-sale"), options)).render(),
    {
        series: [{ name: "Total Visits", data: [4, 10, 25, 12, 25, 18, 40, 22, 7] }],
        chart: { height: 105, type: "area", sparkline: { enabled: !0 }, zoom: { enabled: !1 } },
        dataLabels: { enabled: !1 },
        stroke: { width: 2, curve: "smooth" },
        fill: { type: "gradient", gradient: { shade: "dark", gradientToColors: ["#3cbade"], shadeIntensity: 1, type: "vertical", opacityFrom: 0.75, opacityTo: 0.1 } },
        colors: ["#3cbade"],
        tooltip: {
            fixed: { enabled: !1 },
            x: { show: !1 },
            y: {
                title: {
                    formatter: function () {
                        return "";
                    },
                },
            },
            marker: { show: !1 },
        },
        xaxis: { categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep"] },
    }),
options =
    ((chart = new ApexCharts(document.querySelector("#total-visits"), options)).render(),
    {
        chart: { height: 260, type: "donut" },
        legend: { show: !1, position: "bottom", horizontalAlign: "center", offsetX: 0, offsetY: -5, markers: { width: 9, height: 9, radius: 6 }, itemMargin: { horizontal: 10, vertical: 0 } },
        stroke: { width: 0 },
        plotOptions: { pie: { donut: { size: "70%", labels: { show: !0, total: { showAlways: !0, show: !0 } } } } },
        series: [150, 135, 90, 56],
        labels: ["Agency", "In-House", "Creative", "Student"],
        colors: ["#22c55e", "#efb540", "#6366f1", "#fa5944"],
        dataLabels: { enabled: !1 },
    }),
options =
    ((chart = new ApexCharts(document.querySelector("#month-sales-chart"), options)).render(),
    {
        series: [
            { name: "Agency", data: [52, 14, 11, 99] },
            { name: "In-House", data: [65, 44, 68, 44] },
            { name: "Creative", data: [52, 34, 68, 45] },
            { name: "Student", data: [52, 34, 68, 45] }
        ],
        chart: { 
            height: 313, 
            type: "bar",
            toolbar: { show: false },
            stacked: false
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: ["2021/22", "2022/23", "2023/24", "2024/25"],
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        },
        yaxis: {
            title: {
                text: 'Rankings'
            }
        },
        fill: {
            opacity: 1
        },
        colors: ["#22C55E", "#EAB308", "#6366F1", "#FA5944"],
        legend: {
            position: 'bottom',
            horizontalAlign: 'center'
        },
    });
(chart = new ApexCharts(document.querySelector("#revenue-chart"), options)).render();
