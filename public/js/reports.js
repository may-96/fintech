function showtable() {

    let graph=document.getElementById("graphical");

    let table = document.getElementById("tabular");

    if(table.classList.contains('d-none') || graph.classList.contains('d-flex'))
    {
        toggle_class(table,"d-none","d-block");
        toggle_class(graph,"d-flex","d-none");
    }
}
function showgraph() {

    let graph=document.getElementById("graphical");

    let table = document.getElementById("tabular");

    if(graph.classList.contains('d-none') || table.classList.contains('d-block'))
    {
        toggle_class(graph,"d-none","d-flex");
        toggle_class(table,"d-block","d-none");
    }
}

function toggle_class(elem, class_to_remove, class_to_add)
{
    if (elem.classList.contains(class_to_remove))
    {
        elem.classList.remove(class_to_remove);
    }
    if (!elem.classList.contains(class_to_add))
    {
        elem.classList.add(class_to_add);
    }
}


var options1 = {
    series: [44, 55, 41, 17, 15],
    chart: {
        width: 450,
        type: 'donut',
    },
    plotOptions: {
        pie: {
            startAngle: -90,
            endAngle: 270
        }
    },
    dataLabels: {
        enabled: true
    },
    fill: {
        type: 'gradient',
    },
    legend: {
        formatter: function(val, opts) {
            return val + " - " + opts.w.globals.series[opts.seriesIndex]
        }
    },
    title: {
        text: ''
    },
    responsive: [{
        breakpoint: 480,
        options: {
            // chart: {
            //     width: 200
            // },
            legend: {
                position: 'bottom'
            }
        }
    }]
};

var chart1 = new ApexCharts(document.querySelector("#Incomechart"), options1);
chart1.render();


var options2 = {
    series: [44, 55, 41, 17, 15],
    chart: {
        width: 450,
        type: 'donut',
    },
    plotOptions: {
        pie: {
            startAngle: -90,
            endAngle: 270
        }
    },
    dataLabels: {
        enabled: true
    },
    fill: {
        type: 'gradient',
    },
    legend: {
        formatter: function(val, opts) {
            return val + " - " + opts.w.globals.series[opts.seriesIndex]
        }
    },
    title: {
        text: ''
    },
    responsive: [{
        breakpoint: 480,
        options: {
            // chart: {
            //     width: 200
            // },
            legend: {
                position: 'bottom'
            }
        }
    }]
};

var chart2 = new ApexCharts(document.querySelector("#Expensechart"), options2);
chart2.render();


var options3 = {
    series: [{
        name: 'Cash Out',
        data: [76, 21, 22, 34, 85, 101, 98, 87, 105, 91, 114, 94]
    }, {
        name: 'Cash In',
        data: [35, 41, 36, 26, 43, 65, 56, 45, 48, 52, 53, 41]
    }],
    colors: ['#6bbea3', '#e2626b'],
    chart: {
        type: 'bar',
        height: 350
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '80%',
            endingShape: 'rounded'
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['#6bbea3', '#e2626b'],
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    },
    yaxis: {
        title: {
            text: '$ (Hundreds)'
        }
    },
    fill: {
        opacity: 1,
        colors: ['#6bbea3', '#e2626b'],
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return "$" + val
            }
        }
    }
};

var chart3 = new ApexCharts(document.querySelector("#cashflowchart"), options3);
chart3.render();
