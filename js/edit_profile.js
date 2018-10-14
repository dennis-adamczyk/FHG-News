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

    // $('.header__menu').off().on('click', function () {
    //     overlayFadeIn('dialog-edit_profile-unsaved_changes');
    //     showAlertDialog('Deine Änderungen wurden noch nicht gespeichert. Bist du sicher, dass du die Änderungen verwerfen möchtest?', ['Ja', 'Abbrechen']).then((res) => {
    //         if (res === 'Ja') {
    //             window.history.back();
    //         }
    //         overlayFadeOut('dialog-edit_profile-unsaved_changes');
    //     });
    // });

    var submitted = false;
    let $input = $('.input input, .input textarea');

    $input.on('input', function () {
        if (submitted) {
            let $parent = $(this).parent();
            $parent.find('label.error').text('');
            $parent.removeClass('isInvalid');
        }
    });

    $input.focusout(function () {
        if (submitted)
            submitEditProfile();
    });

    $('#edit_profile').submit(function () {
        submitEditProfile(1);
        return false;
    });

    function submitEditProfile($enter = 0) {
        let form = $('#edit_profile');
        $.ajax({
                type: "POST",
                data: $(form).serialize() + '&enter=' + $enter,
                success: function (data) {
                    console.log(data);
                    if (data.startsWith("E")) { // [E]RRORS
                        var $errors = JSON.parse(data.substr(1));
                    } else if (data === "F") { // [F]AILURE
                        showSingleLineWithActionSnackbar('Fehler aufgetreten', 'Erneut versuchen', function () {
                            submitEditProfile(1);
                        });
                    } else if (data === "S") { // [S]UCCESS
                        addNextSingleLineSnackbar('Profil aktualisiert');
                        window.onbeforeunload = undefined;
                        window.history.back();
                    } else {
                        eval(data);
                    }

                    submitted = true;
                    $('.input.isInvalid label.error').text('');
                    $('.input').removeClass('isInvalid');
                    for (var $id in $errors) {
                        var $msg = $errors[$id];

                        let $parent = $('#' + $id).parent();

                        $parent.addClass('isInvalid');
                        $parent.find('label.error').text($msg);
                        if (is_mobile() && $enter === 1)
                            $(window).scrollTop($parent.offset().top - 128);
                    }

                    $('.loading').removeClass('loading');
                }
            }
        );
    }
});