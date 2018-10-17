jQuery(document).ready(function ($) {

    $('input').on('input keyup', function (e) {
        if (e.which === 13) {
            $('form').submit();
            return false;
        }
        $parent = $(this).parent();
        if($parent.hasClass('isInvalid')) {
            $parent.removeClass('isInvalid');
            $parent.find('.error').text('');
        }
    });

    $('form .submit').on('click', function () {
        $('form').submit();
    });

});