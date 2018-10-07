jQuery(document).ready(function ($) {
    if (is_mobile()) {
        $('.header__menu i').html('close');
        $('.header__done').click(function () {
            $('#edit_profile').submit();
        });
    } else {
        $('.header__done').hide();
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
                }
            }
        );
        return false;
    });
});