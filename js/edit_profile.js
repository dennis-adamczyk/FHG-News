jQuery(document).ready(function ($) {

    window.onbeforeunload = function () {
        return "Deine Änderungen wurden noch nicht gespeichert. Bist du sicher, dass du die Änderungen verwerfen möchtest?";
    };

    if (is_mobile()) {
        $('.header__menu i').html('close');
        $('.header__done').click(function () {
            $(this).addClass('loading');
            $('#edit_profile').submit();
        }).append(
            '<div class="material-loader">' +
            '   <svg class="material-loader__circular" viewBox="25 25 50 50">' +
            '       <circle class="material-loader__circular__path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>' +
            '   </svg>' +
            '</div>'
        );
    } else {
        $('.header__done').hide();
        $('.submit').click(function () {
            $(this).addClass('loading');
            $('#edit_profile').submit();
        });
    }

    $('.header__menu').off().on('click', function () {
        overlayFadeIn('dialog-edit_profile-unsaved_changes');
        showAlertDialog('Deine Änderungen wurden noch nicht gespeichert. Bist du sicher, dass du die Änderungen verwerfen möchtest?', ['Ja', 'Abbrechen']).then((res) => {
            if (res === 'Ja') {
                window.history.back();
            }
            overlayFadeOut('dialog-edit_profile-unsaved_changes');
        });
    });

    $('#edit_profile').submit(function () {
        $.ajax({
                type: "POST",
                data: $(this).serialize(),
                success: function (data) {
                    eval(data);
                    $('.loading').removeClass('loading');
                }
            }
        );
        return false;
    });
});