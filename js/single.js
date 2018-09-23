const $ = jQuery;

function displayComments($icon) {
    let $parent = $icon.parents('.comments__list__commentParent');
    let $children = $parent.find('.children');
    if ($children.length !== 0 && !$icon.hasClass('active')) {
        $icon.addClass('active');
        $children.slideDown(200);
    } else {
        if (is_mobile()) {
            replyTo(parseInt($parent.children('.depth-1.comment').data('comment-id')), 0, $parent.children('.depth-1.comment').data('author'));
        } else {
            $icon.removeClass('active');
            $children.slideUp(200);
        }
    }
}

function writeNewComment() {
    if (!is_logged_in()) {
        overlayFadeIn('comment');
        showAlertDialog('Du musst angemeldet sein, um zu kommentieren', ['Abbrechen', 'Login']).then((res) => {
            if (res === 'Login') {
                window.location = php_vars.login_url;
            }
            overlayFadeOut('comment');
        });
        return;
    }
    if (is_mobile()) {
        let $overlay = $('overlay');
        let $respond = $('.comments__respond.global');
        let $textarea = $respond.find('textarea#comment-global');
        let $submit = $respond.find('.comments__respond__submit input[type=submit]');
        overlayFadeIn('comment');
        $respond.addClass('active');
        $textarea.focus();
        $respond.find('.input__label').text('Öffentlich kommentieren...');

        $textarea.keyup(function (evt) {
            if ($.trim($(this).val())) {
                $(this).addClass('hasValue');
                $submit.addClass('show');
            } else {
                $(this).removeClass('hasValue');
                $submit.removeClass('show');
            }
        });

        optimizeCommentarea();

        $overlay.on('mouseup touchend click', function () {
            if (!$(this).hasClass('active--comment'))
                return;
            if ($.trim($textarea.val())) {
                showAlertDialog('Kommentar verwerfen?', ['Fortfahren', 'Verwerfen']).then((res) => {
                    if (res === 'Verwerfen') {
                        $textarea.val('');
                        $textarea.removeAttr('style');
                        $respond.removeClass('active');
                        overlayFadeOut('comment', function () {
                            $textarea.removeClass('hasValue');
                            $submit.removeClass('show');
                        });
                    }
                });
            } else {
                $respond.removeClass('active');
                overlayFadeOut('comment', function () {
                    $textarea.removeClass('hasValue');
                    $submit.removeClass('show');
                });
            }

        });
    } else {
        let $respond = $('.comments__respond:not(.global)');
        let $textarea = $respond.find('textarea#comment');
        let $submit = $respond.find('.comments__respond__submit');
        let $submit_button = $respond.find('.comments__respond__submit input[type=submit]');
        let $submit_cancel = $respond.find('.comments__respond__submit__cancel');

        $submit.addClass('active');
        $textarea.focus();

        $textarea.keyup(function (evt) {
            if ($.trim($(this).val())) {
                $(this).addClass('hasValue');
                $submit_button.addClass('show');
            } else {
                $(this).removeClass('hasValue');
                $submit_button.removeClass('show');
            }
        });

        $submit_button.click(function () {
            if (!$(this).hasClass('show')) return false;
        });

        $submit_cancel.click(function () {
            $textarea.val('');
            $textarea.trigger('keyup');
            $submit.removeClass('active');
            $respond.find('.input__label').text('Öffentlich kommentieren...');
            $respond.find('.btn-success').val('Kommentieren');
            $respond.detach().insertAfter('#comments h3');
            $respond.removeAttr('style');
        });

        optimizeCommentarea();
    }
}

function replyTo(comment_id, parent_id, reply_user) {
    if (!is_logged_in()) {
        overlayFadeIn('comment');
        showAlertDialog('Du musst angemeldet sein, um zu kommentieren', ['Abbrechen', 'Login']).then((res) => {
            if (res === 'Login') {
                window.location = php_vars.login_url;
            }
            overlayFadeOut('comment');
        });
        return;
    }

    if (is_mobile()) {
        let $respond = $('.comments__respond.global');
        let $comment_parent = $respond.find('#comment_parent');
        let $input_label = $respond.find('.input__label');
        let $textarea = $respond.find('textarea#comment-global');

        $input_label.text('Öffentlich antworten...');
        if (parent_id === 0) {
            $comment_parent.attr('value', comment_id);
        } else {
            $comment_parent.attr('value', parent_id);
            $textarea.val(reply_user + ' ');
            $textarea.addClass('hasValue');
        }
    } else {
        let $respond = $('.comments__respond:not(.global)');
        let $comment_parent = $respond.find('#comment_parent');
        let $input_label = $respond.find('.input__label');
        let $textarea = $respond.find('textarea#comment');

        $input_label.text('Öffentlich antworten...');
        $respond.find('.btn-success').val('Antworten');
        $respond.detach().appendTo($('#comment-' + comment_id));
        if (parent_id === 0) {
            $comment_parent.attr('value', comment_id);
            $respond.css('padding-left', '40px');
        } else {
            $comment_parent.attr('value', parent_id);
            $textarea.val(reply_user + ' ');
            $textarea.addClass('hasValue');
            $respond.removeAttr('style');
        }
    }
    writeNewComment();
}

function optimizeCommentarea() {
    let $respond = $('.comments__respond' + (is_mobile() ? '.global' : ':not(.global)'));
    let $textarea = $respond.find('textarea#comment' + (is_mobile() ? '-global' : ''));

    $textarea.on('paste keyup keydown', function (evt) {
        $textarea.css({'height': '35px', 'line-height': '19px'});
        var newHeight = this.scrollHeight;
        if (newHeight > 35) {
            $textarea.css('height', newHeight + 'px');
            if (newHeight > $textarea.height())
                $textarea.css('overflow', 'auto');
        } else {
            $textarea.removeAttr('style');
        }
    });
}

$(document).ready(function () {

    /* ===== LIGHT BOX ===== */

    const $images = jQuery('p > img, .wp-caption');

    $images.stop().click(function () {
        showLightBox($(this).children('img').length === 0 ? $(this).attr('srcset') : $(this).children('img').attr('srcset'), jQuery(this), jQuery('p > img, .wp-caption'));
    });


    if (window.location.hash) {
        $('header').addClass('header--collapsed');
        $('ul.children').css('display', 'block');
        showSingleLineSnackBar('Kommentar erfolgreich gesendet');
    }

    $('.comments__list__comment').click(function (evt) {
        if ($(evt.target).parents('.comments__list__comment__box__foot').length !== 0)
            return;

        if (!is_mobile())
            return;

        replyTo(parseInt($(this).data('comment-id')), parseInt($(this).data('parent-id')), $(this).data('author'));
    });

    $('.comments__respond:not(.global) .comments__respond__commentInput').click(function (evt) {
        writeNewComment();
    });

    $('.post__foot__like').one().click(function () {
        let $parent = $(this);
        let $count = $parent.find('.post__foot__like__count');

        if (!is_logged_in()) {
            overlayFadeIn('dialog-like-not_logged_in');
            showAlertDialog('Zum Liken anmelden oder einfach ein kostenloses Konto erstellen', ['Abbrechen', 'Registrieren', 'Anmelden']).then((res) => {
                if (res === 'Registrieren') {
                    window.location = php_vars.registration_url;
                } else if (res === 'Anmelden') {
                    window.location = php_vars.login_url;
                }
                overlayFadeOut('dialog-like-not_logged_in');
            });
            return;
        }

        if ($parent.hasClass('active')) {
            current_user_unlike_post(php_vars.post_id).done(function (success) {
                if (success != 'false' && success) {
                    $count.text(parseInt($count.text()) - 1);
                }
            });
            $parent.removeClass('active');
        } else {
            current_user_like_post(php_vars.post_id).done(function (success) {
                if (success != 'false' && success) {
                    $count.text(parseInt($count.text()) + 1);
                }
            });
            $parent.addClass('active');
        }
    });

    $('.comments__list__comment__box__foot__like').one().click(function () {
        let $parent = $(this);
        let $comment_id = $parent.parents('.comments__list__comment').data('comment-id');
        let $count = $parent.find('.comments__list__comment__box__foot__like__count');

        if (!is_logged_in()) {
            overlayFadeIn('dialog-like-not_logged_in');
            showAlertDialog('Zum Liken anmelden oder einfach ein kostenloses Konto erstellen', ['Abbrechen', 'Registrieren', 'Anmelden']).then((res) => {
                if (res === 'Registrieren') {
                    window.location = php_vars.registration_url;
                } else if (res === 'Anmelden') {
                    window.location = php_vars.login_url;
                }
                overlayFadeOut('dialog-like-not_logged_in');
            });
            return;
        }

        if ($parent.hasClass('active')) {
            current_user_unlike_comment($comment_id).done(function (success) {
                console.log(success);
                if (success != 'false' && success) {
                    $count.text(parseInt($count.text()) - 1);
                }
            });
            $parent.removeClass('active');
        } else {
            current_user_like_comment($comment_id).done(function (success) {
                console.log(success);
                if (success != 'false' && success) {
                    $count.text(parseInt($count.text()) + 1);
                }
            });
            $parent.addClass('active');
        }
    });

    $('.comments__list__comment__box__foot__reply').click(function () {
        replyTo(parseInt($(this).parents('.comments__list__comment').data('comment-id')), parseInt($(this).parents('.comments__list__comment').data('parent-id')), $(this).parents('.comments__list__comment').data('author'));
    });

});