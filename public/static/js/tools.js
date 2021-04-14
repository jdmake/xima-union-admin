var xima_tools = {
    table: function (option) {
        var that = $(option.el)
        var table = ''

        table += '<div class="table-content">'
        table += '<table class="table table-hover table-condensed">'
        table += '<thead><tr>'

        option.columns.forEach(function (item) {
            var width = item.width ? 'style="width:' + item.width + 'px"' : ''
            switch (item.type) {
                case 'checkbox':
                    table += '<th ' + width + '> <label class="checkbox-primary"> <input type="checkbox" id="check-all"> <span></span> </label> </th>'
                    break;
                default:
                    table += '<th ' + width + '>' + item.name + '</th>'
                    break;
            }
        })



        table += '</tr></thead>'
        table += '<tbody>'
        table += '<tr>'

        table += '<td></td>'
        table += '<td></td>'
        table += '<td></td>'

        table += '</tr>'
        table += '</tbody>'
        table += '</table>'
        table += '</div>'
        that.append(table)
    }
}
