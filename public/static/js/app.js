$(function () {
    // tooltip init
    $('[data-toggle="tooltip"]').tooltip();
    // sidebar
    $(".sidebar a[data-toggle='nav-submenu']")
        .on('click', function () {
            var $link = jQuery(this);
            var $parentLi = $link.parent('li');
            if ($parentLi.hasClass('open')) {
                $parentLi.removeClass('open');
            } else {
                $link
                    .closest('ul')
                    .find('> li')
                    .removeClass('open');
                $parentLi
                    .addClass('open');
            }
            return false;
        });

    // check-all
    $('#check-all').on('click', function () {
        var bischecked = $(this).is(':checked');
        bischecked ? $('.sub-checkbox').prop('checked', true) : $('.sub-checkbox').prop('checked', false)
    });

    // confirm
    $('.confirm').on('click', function (e) {
        var href = $(this).attr('href');
        e.preventDefault();
        layer.confirm('你真的要操作吗？', {
            icon:3,
            btn: ['确认','取消'],
            scrollbar: false,
        }, function(){
            $('form[name="toolbar-form"]').attr('action', href).submit();
        }, function(){
        });
    })


});
