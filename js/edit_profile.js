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
    let $changeProfilePictureBtn = $('.general__profilePicture__change');
    let $avatar = $('#avatar');

    $changeProfilePictureBtn.click(function () {
        showSelectDialog('Profilbild ändern', ['Neues Profilbild', 'Profilbild entfernen']).then(function (res) {
            if (res === 'Neues Profilbild') {
                $avatar.click();
            } else if (res === 'Profilbild entfernen') {
                deleteProfilePic();
            }
        });
    });

    $avatar.change(function (e) {
        if (e.target.files.length === 1)
            showCropDialog(this);
    });

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

    function deleteProfilePic() {
        overlayFadeIn('deleteProfilePicture');
        setTimeout(function () {
            showAlertDialog('Profilbild unwiderruflich löschen?', ['Abbrechen', 'Löschen']).then(function (res) {
                if (res === 'Löschen') {
                    $.ajax({
                        method: 'POST',
                        data: {"_wpnonce": $('#_wpnonce').val(), "profilePic": "delete"},
                        success: function (data) {
                            console.log(data);
                            if (data.startsWith("S")) {
                                showSingleLineSnackBar('Profilbild entfernt');
                                $('.avatar').attr('src', data.substr(1));
                            } else {
                                showSingleLineWithActionSnackbar('Fehler aufgetreten', 'Erneut versuchen', deleteProfilePic);
                            }
                        }
                    });
                }
                overlayFadeOut('deleteProfilePicture');
            });
        }, 300);
    }

    function submitEditProfile($enter = 0) {
        let form = $('#edit_profile');
        $.ajax({
                type: "POST",
                data: $(form).serialize() + '&enter=' + $enter,
                success: function (data) {
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

    function showCropDialog(that) {

        return new Promise((resolve, reject) => {

            if ($('dialogbox').attr('open'))
                return;
            $('dialogbox').addClass('cropProfilePic');
            let $dialog = $('dialogbox.cropProfilePic');

            let $html = `
            <div class="cropContainer">
                <div class="close"><i class="material-icons">close</i></div>
                <div class="done"><i class="material-icons">done</i></div>
                <p class="label">Neues Profilbild</p>
                <div id="croppie">
                  <div class="options">
                    <div class="zoom_in"><i class="material-icons">zoom_in</i></div>
                    <div class="zoom_out"><i class="material-icons">zoom_out</i></div>
                    <div class="rotate_left"><i class="material-icons">rotate_left</i></div>
                    <div class="rotate_right"><i class="material-icons">rotate_right</i></div>
                  </div>
                </div>
                <div class="material-loader material-loader--small uploadImage">
                  <svg class="material-loader__circular" viewBox="25 25 50 50">
                    <circle class="material-loader__circular__path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
                            stroke-miterlimit="10"></circle>
                  </svg>
                </div>
            </div>`;

            $dialog.html($html);
            overlayFadeIn('cropProfilePic');

            const $croppieElem = $dialog.find('#croppie');
            const croppie = $croppieElem.croppie({
                enableOrientation: true,
                showZoomer: false,
                viewport: {
                    width: 128,
                    height: 128
                }
            });
            var reader = new FileReader();
            reader.onload = function (event) {
                croppie.croppie('bind', {
                    url: event.target.result
                }).then(function () {
                    console.log('jQuery bild complete');
                });
            };
            reader.readAsDataURL(that.files[0]);

            $dialog.fadeIn(200, function () {
                $dialog.prop('open', '');
                Waves.attach('dialogbox .close');
                Waves.attach('dialogbox .done');
                Waves.init();

                let uploadImage = function () {
                    $croppieElem.fadeTo(150, 0);
                    $dialog.find('.uploadImage').fadeIn(150);
                    croppie.croppie('result', {
                        type: 'canvas',
                        size: {width: 1024, height: 1024},
                    }).then(function (response) {
                        $.ajax({
                            method: 'POST',
                            data: {"_wpnonce": $('#_wpnonce').val(), "profilePic": response},
                            success: function (data) {
                                console.log(data);
                                $dialog.find('.uploadImage').fadeOut(150, function () {
                                    closeCropDialog();

                                    if (data.startsWith("S")) {
                                        showSingleLineSnackBar('Profilbild aktualisiert');
                                        $(".avatar").attr("src", data.substr(1) + "?" + new Date().getTime());
                                    } else {
                                        showSingleLineWithActionSnackbar('Fehler aufgetreten', 'Erneut versuchen', function () {
                                            $avatar.click();
                                        });
                                    }
                                });
                            }
                        });
                    });
                };

                let closeCropDialog = function () {
                    resolve();
                    overlayFadeOut('cropProfilePic');
                    $dialog.fadeOut(180, function () {
                        $dialog.html('');
                        $dialog.removeClass('cropProfilePic');
                        $dialog.removeProp('open');
                        $avatar.val('');
                    });
                };

                let zoomIn = function () {
                    croppie.croppie('setZoom', croppie.croppie('get').zoom + 0.1);
                };

                let zoomOut = function () {
                    croppie.croppie('setZoom', croppie.croppie('get').zoom - 0.1);
                };

                let rotateLeft = function () {
                    croppie.croppie('rotate', 90);
                };

                let rotateRight = function () {
                    croppie.croppie('rotate', -90);
                };

                $($dialog.find('div.close')).on('click', closeCropDialog);
                $($dialog.find('div.done')).on('click', uploadImage);
                $($croppieElem.find('.options .zoom_in')).on('click', zoomIn);
                $($croppieElem.find('.options .zoom_out')).on('click', zoomOut);
                $($croppieElem.find('.options .rotate_left')).on('click', rotateLeft);
                $($croppieElem.find('.options .rotate_right')).on('click', rotateRight);
                $('overlay').on('click', closeCropDialog);
                $($dialog.find('li')).on('click', function () {
                    resolve($(this).find('span').text());
                    closeCropDialog();
                });
            });

        });

    }
});