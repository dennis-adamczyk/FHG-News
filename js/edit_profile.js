jQuery(document).ready(function ($) {
    if (is_mobile())
        $('.header__menu i').html('close');
    else
        $('.header__done').hide();
});