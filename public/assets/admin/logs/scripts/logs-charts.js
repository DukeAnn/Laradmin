/**
 * Created by ADKi on 2017/1/6 0006.
 */

var ChartsAmcharts = function() {

    var initChartLogsAll = function() {
        var chart = AmCharts.makeChart("chart_logs_all", {
            "type": "pie",
            "theme": "light",
            "startDuration": 0,
            "addClassNames": true,
            //空心圆
            "innerRadius": "30%",
            "fontFamily": 'Microsoft YaHei',
            //右侧标注
            "legend":{
                "position":"right",
                "marginRight":100,
                "autoMargins":false
            },
            "color":    '#888',
            //显示主体信息
            "dataProvider": dataobkect,
            //内容
            "valueField": "litres",
            //标题
            "titleField": "log_level",
            "exportConfig": {
                menuItems: [{
                    icon: App.getGlobalPluginsPath() + "amcharts/amcharts/images/export.png",
                    format: 'png'
                }]
            }
        });

        $('#chart_logs_all').closest('.portlet').find('.fullscreen').click(function() {
            chart.invalidateSize();
        });
    };

    return {
        //main function to initiate the module
        init: function() {
            initChartLogsAll();
        }
    };

}();

jQuery(document).ready(function() {
    ChartsAmcharts.init();
});
