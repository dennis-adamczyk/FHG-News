jQuery(document).ready(function ($) {

    let $type = $('#type');

    function changeType() {
        let type = $type.val();
        $('.changeable > div').hide();
        $('.changeable .' + type).show(0, function () {
            auto_grow($(this).find('textarea'));
        });
    }

    changeType();

    $type.change(function () {
        changeType();
    });

    function auto_grow(textarea) {
        $(textarea).css('height', '5px');
        $(textarea).css('height', ($(textarea).prop('scrollHeight') - 11) + 'px');
    }

    $('.submit').click(function () {
        var inputsFilled = true;
        $('input, textarea').each(function () {
            if ($(this).parent().parent().css('display') === 'block' && !$(this).val()) {
                inputsFilled = false;
                console.log($(this), $(this).parent().parent());
            }
        });
        if (inputsFilled)
            $('form').submit();
    });

});