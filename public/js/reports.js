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





var options = {
    series: [75],
    chart: {
        height: 350,
        type: 'radialBar',
        toolbar: {
            show: true
        }
    },
    plotOptions: {
        radialBar: {
            startAngle: -135,
            endAngle: 225,
            hollow: {
                margin: 0,
                size: '70%',
                background: '#fff',
                image: undefined,
                imageOffsetX: 0,
                imageOffsetY: 0,
                position: 'front',
                dropShadow: {
                    enabled: true,
                    top: 3,
                    left: 0,
                    blur: 4,
                    opacity: 0.24
                }
            },
            track: {
                background: '#fff',
                strokeWidth: '67%',
                margin: 0, // margin is in pixels
                dropShadow: {
                    enabled: true,
                    top: -3,
                    left: 0,
                    blur: 4,
                    opacity: 0.35
                }
            },

            dataLabels: {
                show: true,
                name: {
                    offsetY: -10,
                    show: true,
                    color: '#888',
                    fontSize: '17px'
                },
                value: {
                    formatter: function (val) {
                        return parseInt(val);
                    },
                    color: '#111',
                    fontSize: '36px',
                    show: true,
                }
            }
        }
    },
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'dark',
            type: 'horizontal',
            shadeIntensity: 0.5,
            gradientToColors: ['#ABE5A1'],
            inverseColors: true,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100]
        }
    },
    stroke: {
        lineCap: 'round'
    },
    labels: ['Credit Score'],
};

var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();

var options2 = {
    series: [{
        name: 'Mortgage Payments',
        data: [34, 54, 65, 44, 55, 57, 56, 61, 58, 63, 60, 66]
    }, {
        name: 'Bills',
        data: [76, 21, 22, 34, 85, 101, 98, 87, 105, 91, 114, 94]
    }, {
        name: 'Cash Flow',
        data: [35, 41, 36, 26, 43, 65, 56, 45, 48, 52, 53, 41]
    }],
    chart: {
        type: 'bar',
        height: 350
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
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    },
    yaxis: {
        title: {
            text: '$ (Hundreds)'
        }
    },
    fill: {
        opacity: 1
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return "$ " + val + " thousands"
            }
        }
    }
};

var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
chart2.render();
