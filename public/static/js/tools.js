var xima_tools = {
    table: function (option) {

        var table_box = $(option.el);
        var table = '<table id="datatable" class="display dataTable"></table>'
        table = $(table)
        table_box.append(table);

        window.$table = $(table).on('init.dt', function () {
            option.tools.forEach(function (item) {
                $('.dt-buttons').append('<button onclick="(' + item.action + ')()" class="btn ' + item.class + '" type="button">' + item.title + '</button>');
            })
        }).DataTable({
            destroy: true,
            bLengthChange: false,
            iDisplayLength: 15,
            bFilter: true,
            bInfo: true,
            bSort: false,
            oLanguage: {
                "sProcessing": "正在获取数据，请稍后...",
                "sLengthMenu": "显示 _MENU_ 条",
                "sZeroRecords": "暂时没有任何数据",
                "sInfo": "从 _START_ 到  _END_ 条记录 总记录数为 _TOTAL_ 条",
                "sInfoEmpty": "",
                "sInfoFiltered": "(全部记录数 _MAX_ 条)",
                "sInfoPostFix": "",
                "sSearch": "搜索",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "第一页",
                    "sPrevious": "上一页",
                    "sNext": "下一页",
                    "sLast": "最后一页"
                }
            },
            bProcessing: true,
            ajax: '/?do=cleaner.getData',
            aoColumns: option.columns,
            dom: 'Bfrtip',
            buttons: [],
        });

    },

    open: function (option) {
        layer.open({
            type: 1,
            shade: false,
            title: false,
            area: option.area,
            content: $(option.el),
            cancel: function(){
            }
        });
    }
}
