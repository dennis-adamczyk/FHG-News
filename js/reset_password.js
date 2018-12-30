jQuery(document).ready(function ($) {

    $('input').on('input keyup', function (e) {
        if (e.which === 13) {
            $('form').submit();
            return false;
        }
        $parent = $(this).parent();
        if ($parent.hasClass('isInvalid')) {
            $parent.removeClass('isInvalid');
            $parent.find('.error').text('');
        }
        if ($parent.hasClass('input--strength')) {
            let $red = '#F44336', $orange = '#FF9800', $green = '#4CAF50', $blue = '#2196F3';
            let $strength = $parent.find(".strength");
            let strength = strengthMeter($(this).val());
            $strength.css('width', Math.min(100 * strength / 15, 100) + '%');
            if (0 <= strength && strength <= 5) {
                console.log(strength);
                $strength.css('background-color', $red);
            } else if (6 <= strength && strength <= 10) {
                $strength.css('background-color', $orange);
            } else if (11 <= strength && strength <= 14) {
                $strength.css('background-color', $green);
            } else {
                $strength.css('background-color', $blue);
            }
        }
    });

    $('form .submit').on('click', function () {
        $('form').submit();
    });

});