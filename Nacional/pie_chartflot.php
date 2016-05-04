<script type="text/javascript" src="js/jquery.min.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
<script type="text/javascript" src="js/jquery.flot.min.js"></script>
<script type="text/javascript" src="js/jquery.flot.time.js"></script>    
<script type="text/javascript" src="js/jquery.flot.pie.min.js"></script>
<script>
//******* PIE CHART
var dataSet = [
    {label: "Asia", data: 4119630000, color: "#005CDE" },
    { label: "Latin America", data: 590950000, color: "#00A36A" },
    { label: "Africa", data: 1012960000, color: "#7D0096" },
    { label: "Oceania", data: 35100000, color: "#992B00" },
    { label: "Europe", data: 727080000, color: "#DE000F" },
    { label: "North America", data: 344120000, color: "#ED7B00" }    
];

var options = {
    series: {
        pie: {
            show: true,
            label: {
                show: true,
                radius: 180,
                formatter: function (label, series) {
                    return '<div style="border:1px solid grey;font-size:8pt;text-align:center;padding:5px;color:white;">' +
                    label + ' : ' +
                    Math.round(series.percent) +
                    '%</div>';
                },
                background: {
                    opacity: 0.8,
                    color: '#000'
                }
            }
        }
    },
    legend: {
        show: false
    },
    grid: {
        hoverable: true
    }
};

var options1 = {
    series: {
        pie: {
            show: true,
            tilt: 0.5
        }
    }
};

var options2 = {
    series: {
        pie: {
            show: true,
            innerRadius: 0.5,
            label: {
                show: true
            }
        }
    }
};

$(document).ready(function () {
    $.plot($("#flot-placeholder"), dataSet, options);
    $("#flot-placeholder").showMemo();
});


$.fn.showMemo = function () {
    $(this).bind("plothover", function (event, pos, item) {
        if (!item) { return; }
        console.log(item.series.data)
        var html = [];
        var percent = parseFloat(item.series.percent).toFixed(2);        

        html.push("<div style=\"border:1px solid grey;background-color:",
             item.series.color,
             "\">",
             "<span style=\"color:white\">",
             item.series.label,
             " : ",
             $.formatNumber(item.series.data[0][1], { format: "#,###", locale: "us" }),
             " (", percent, "%)",
             "</span>", 
             "</div>");
        $("#flot-memo").html(html.join(''));
    });
}

</script>
<!-- HTML -->
<div id="flot-placeholder" style="width:550px;height:400px;margin:0 auto"></div>