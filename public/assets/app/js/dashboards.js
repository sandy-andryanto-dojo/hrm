$(document).ready(function() {

    var loadDashboard = function() {
        headerRequest();
        $.post(BASE_URL + "/api/dashboard", function(result) {
            if (result) {
                $("#employee").text(result.employee);
                $("#division").text(result.division);
                $("#vacancy").text(result.vacancy);
                $("#mutation").text(result.mutation);
                $("#promotion").text(result.promotion);
                $("#retired").text(result.retired);
                donutChart("#chart_cuti", result.annual);
                donutChart("#chart_dinas", result.travel);
                donutChart("#chart_lembur", result.overtime);
                barChart("#chart_employee", result.employeeChart);
            }
        });
    };

    var barChart = function(content, items) {

        var barChart = {
            labels: items.division,
            datasets: [{
                label: "Jumlah Pegawai",
                backgroundColor: "#188ae2",
                borderColor: "#188ae2",
                borderWidth: 1,
                hoverBackgroundColor: "#188ae2",
                hoverBorderColor: "#7fc1fc",
                data: items.data,
            }]
        };
        var selector = $(content);
        var ctx = selector.get(0).getContext("2d");
        new Chart(ctx, { type: 'bar', data: barChart });
    };

    var donutChart = function(content, items) {

        var totals = new Array();
        var all = parseFloat(items.all);
        totals[0] = ((parseFloat(items.pending) * 100) / all).toFixed(2);
        totals[1] = ((parseFloat(items.approved) * 100) / all).toFixed(2);
        totals[2] = ((parseFloat(items.rejected) * 100) / all).toFixed(2);

        var donutChart = {
            labels: [
                "Pending",
                "Approve",
                "Reject"
            ],
            datasets: [{
                data: totals,
                backgroundColor: [
                    "#f9c851",
                    "#3ac9d6",
                    "#8B0000"
                ],
                hoverBackgroundColor: [
                    "#f9c851",
                    "#3ac9d6",
                    "#8B0000"
                ],
                hoverBorderColor: "#fff"
            }]
        };

        var opt = {
            tooltips: {
                callbacks: {
                    title: function(tooltipItem, data) {
                        return data['labels'][tooltipItem[0]['index']];
                    },
                    label: function(tooltipItem, data) {
                        return data['datasets'][0]['data'][tooltipItem['index']] + " %";
                    },
                }
            }
        };

        var selector = $(content);
        var ctx = selector.get(0).getContext("2d");
        new Chart(ctx, { type: 'doughnut', data: donutChart, options: opt });
    };



    loadDashboard();

});