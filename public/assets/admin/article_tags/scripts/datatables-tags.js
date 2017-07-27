/**
 * datatables 访问数据库数据,复写datatable.js配置
 * Created by ADKi on 2016/12/20 0020.
 */
var DatatablesArticles = function () {
    var initPickers = function () {
        //init date pickers
        $('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
    };

    var handle = function () {

        var grid = new Datatable();

        grid.init({
            src: $("#datatable_ajax"),
            onSuccess: function (grid, response) {
                // grid:        grid object
                // response:    json object of server side ajax response
                // execute some code after table records loaded
            },
            onError: function (grid) {
                // execute some code on network or other general error
            },
            // ajax加载完数据之后的操作
            onDataLoad: function(grid) {
                //初始化弹窗
                SweetAlert.init();
            },
            loadingMessage: '正在加载...',
            dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options

                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js).
                // So when dropdowns used the scrollable div should be removed.
                //"dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",

                // save datatable state(pagination, sort, etc) in cookie.
                "bStateSave": true,

                "language": { // language settings
                    // metronic spesific
                    "metronicGroupActions": "_TOTAL_ 条被选中：  ",
                    "metronicAjaxRequestGeneralError": "无法完成请求。请检查您的互联网连接！",

                    // data tables spesific
                    "lengthMenu": "<span class='seperator'>|</span>每页显示 _MENU_ 条",
                    "info": "<span class='seperator'>|</span>共有 _TOTAL_ 条记录",
                    "infoEmpty": "没有发现显示的记录",
                    "emptyTable": "表中没有可用的数据",
                    "zeroRecords": "没有找到匹配的记录",
                    "search": "搜索:",
                    "searchPlaceholder": "标签名",
                    "infoFiltered": "- _MAX_ 条数据中的搜索结果",
                    "paginate": {
                        "previous": "上一页",
                        "next": "下一页",
                        "last": "最后一页",
                        "first": "第一页",
                        "page": "当前页",
                        "pageOf": "共"
                    }
                },

                "dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'f<'table-group-actions pull-right'>>r><'table-responsive't><'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>", // datatable layout

                // save custom filters to the state
                "fnStateSaveParams":    function ( oSettings, sValue ) {
                    $("#datatable_ajax tr.filter .form-control").each(function() {
                        sValue[$(this).attr('name')] = $(this).val();
                    });

                    return sValue;
                },

                // read the custom filters from saved state and populate the filter inputs
                "fnStateLoadParams" : function ( oSettings, oData ) {
                    //Load custom filters
                    $("#datatable_ajax tr.filter .form-control").each(function() {
                        var element = $(this);
                        if (oData[element.attr('name')]) {
                            element.val( oData[element.attr('name')] );
                        }
                    });

                    return true;
                },

                "lengthMenu": [
                    [10, 20, 50, 100, 150, -1],
                    [10, 20, 50, 100, 150, "All"] // change per page values here
                ],
                "pageLength": 10, // default record count per page
                "ajax": {
                    "url": ajax_url // ajax source
                },
                "columnDefs": [
                    { // 默认禁止第一列排序
                        'targets': [0], //禁止排序的列下标
                        "data": "id",
                        "orderable": false,
                        "searchable": false
                    },
                    {
                        'targets': [1],
                        "data": "name",
                        "orderable": true,
                        "searchable": true
                    },
                    {
                        'targets': [2],
                        "data": "display_name",
                        "orderable": false,
                        "searchable": true
                    },
                    {
                        'targets': [3],
                        "data": "created_at",
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        'targets': [4],
                        "data": "updated_at",
                        "orderable": true,
                        "searchable": false
                    },
                    {
                        'targets': [5],
                        "data": "action",
                        "orderable": false,
                        "searchable": false
                    }
                ],
                "order": [
                    [3, "desc"]
                ]// set first column as a default sort by asc
            }
        });

        // handle group actionsubmit button click
        grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
            e.preventDefault();
            var action = $(".table-group-action-input", grid.getTableWrapper());
            if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
                grid.setAjaxParam("customActionType", "group_action");
                grid.setAjaxParam("customActionName", action.val());
                grid.setAjaxParam("id", grid.getSelectedRows());
                grid.getDataTable().ajax.reload();
                grid.clearAjaxParams();
            } else if (action.val() == "") {
                App.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'Please select an action',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            } else if (grid.getSelectedRowsCount() === 0) {
                App.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'No record selected',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            }
        });

        //grid.setAjaxParam("customActionType", "group_action");
        //grid.getDataTable().ajax.reload();
        //grid.clearAjaxParams();
    };

    return {
        init: function () {
            initPickers();
            handle();
        }
    }
}();

jQuery(document).ready(function() {
    DatatablesArticles.init();
});