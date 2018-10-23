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

        $textarea.on('input', function () {
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

        $textarea.on('input', function () {
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

    $textarea.on('input', function () {
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

    Waves.attach('.wp-block-button a');
    Waves.init({
        duration: 200,
        delay: 0
    });

    infiniteScrollRecommended(php_vars.post);

    /* ===== POLLS ===== */

    let $poll = $('.post__content poll');
    let $pollAnswer = $poll.find('.poll_answer');
    let $pollAnswerRadio = $pollAnswer.find('input:radio');
    let $pollAnswerCheckbox = $pollAnswer.find('input:checkbox');


    $pollAnswerRadio.mousedown(function () {
        if ($(this).find('input[type="radio"]').attr('disabled') !== undefined) return false;
        var $self = $(this);
        if ($self.is(':checked')) {
            var uncheck = function () {
                setTimeout(function () {
                    $self
                        .removeAttr('checked')
                        .trigger('change');
                }, 0);
            };
            var unbind = function () {
                $self.unbind('mouseup', up);
            };
            var up = function () {
                uncheck();
                unbind();
            };
            $self.bind('mouseup', up);
            $self.one('mouseout', unbind);
        }
    });


    $pollAnswer.on('click', function (e) {
        if ($(e.target).is($('input')) || $(this).find('input').attr('disabled') !== undefined) return;
        if ($(this).parents('poll').attr('multi') === undefined) {
            let $radioState = $(this).find('input[type="radio"]').attr('checked') !== undefined;
            $pollAnswerRadio.filter('[name=' + $(this).attr('name') + ']').removeAttr('checked');
            $(this).find('input[type="radio"]')
                .attr('checked', !$radioState)
                .trigger('change');
        } else {
            let $checkState = $(this).find('input[type="checkbox"]').attr('checked') !== undefined;
            $(this).find('input[type="checkbox"]')
                .attr('checked', !$checkState)
                .trigger('change');
        }
        e.preventDefault();
        return false;
    });

    $pollAnswer.find('input').change(function () {
        let $that = $(this);
        const $poll = $(this).parents('poll');
        let $poll_id = $poll.data('id');
        let $inputGroup = $pollAnswer.find('input[name="' + $that.attr('name') + '"]');
        var $answer = 0;

        if ($that.attr('checked') !== undefined) {
            if ($poll.attr('multi') === undefined) {
                $poll.find('.poll_answer').each(function (index) {
                    if ($that.parents('.poll_answer')[0] === $(this)[0]) {
                        $answer = index;
                        return false;
                    }
                });
            } else {
                $answer = [];
                $poll.find('.poll_answer').each(function (index) {
                    if ($(this).children('input:checkbox').attr('checked') !== undefined) {
                        $answer.push(index);
                    }
                });
            }
        } else {
            $answer = -1;
            if ($poll.attr('multi') !== undefined) {
                $answer = [];
                $poll.find('.poll_answer').each(function (index) {
                    if ($(this).children('input:checkbox').attr('checked') !== undefined) {
                        $answer.push(index);
                    }
                });
                if ($answer.length === 0) {
                    $answer = -1;
                }
            }
        }

        if ($(this).attr('disabled') !== undefined) return false;
        $inputGroup.attr('disabled', true);

        $poll.find('.poll_answer .result').fadeOut(150, function () {
            $(this).remove();
        });

        // TODO: LOADING INDICATOR

        $.ajax({
            type: 'POST',
            url: php_info.ajax_url,
            data: {
                action: 'update_poll_vote',
                post_id: php_vars.post_id,
                poll_id: $poll_id,
                answer: $answer
            },
            success: function (data) {
                if (data.startsWith('F')) {
                    showSingleLineSnackBar('Fehler aufgetreten. Versuche es später erneut.');
                } else {
                    $data = data.substr(1);
                    $info = $data.split('|');
                    $votesText = $info[0];
                    $results = $info[1] ? JSON.parse($info[1]) : false;
                    $votesCount = $info[2];

                    $poll.find('.poll_votes').text($votesText);
                    if ($results) {
                        for(var index in $results) {
                            val = $results[index];
                            $percentage = 100 * val / $votesCount;
                            $poll.find('.poll_answer:eq(' + index + ') label').append('<div class="result" style="width: ' + $percentage +  '%"><span>' + $percentage + '%</span></div>');
                            $poll.find('.poll_answer:eq(' + index + ') label .result span').css('margin-left', $poll.find('.poll_answer:eq(' + index + ') label > span').outerWidth(true) + 8 + 'px');
                            $poll.find('.poll_answer:eq(' + index + ')').append('<div class="result"><span style="width: ' + $percentage +  '%"></span></div>');
                        }
                        $poll.find('.poll_answer label .result').hide().fadeIn(150);
                    }
                }
                $inputGroup.removeAttr('disabled');
            }
        });

    });

    load_results_if_voted();

    function load_results_if_voted() {
        $polls = $('.post__content poll');
        $polls.each(function() {
            const $poll = $(this);
            const $poll_id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: php_info.ajax_url,
                data: {
                    action: 'get_poll_results',
                    post_id: php_vars.post_id,
                    poll_id: $poll_id,
                },
                success: function (data) {
                    if (data.startsWith('S')) {
                        $data = data.substr(1);
                        $info = $data.split('|');
                        $voted = $info[0];
                        $results = $info[1] ? JSON.parse($info[1]) : false;
                        $votesCount = $info[2];

                        if($.isNumeric($voted)) {
                            $poll.find('.poll_answer:eq(' + $voted + ') input').attr('checked', true);
                        } else {
                            $voted = JSON.parse($voted);
                            for(var voteI in $voted) {
                                $poll.find('.poll_answer:eq(' + $voted[voteI] + ') input').attr('checked', true);
                            }
                        }
                        if ($results) {
                            for(var index in $results) {
                                val = $results[index];
                                $percentage = 100 * val / $votesCount;
                                $poll.find('.poll_answer:eq(' + index + ') label').append('<div class="result" style="width: ' + $percentage +  '%"><span>' + $percentage + '%</span></div>');
                                $poll.find('.poll_answer:eq(' + index + ') label .result span').css('margin-left', $poll.find('.poll_answer:eq(' + index + ') label > span').outerWidth(true) + 8 + 'px');
                                $poll.find('.poll_answer:eq(' + index + ')').append('<div class="result"><span style="width: ' + $percentage +  '%"></span></div>');
                            }
                            $poll.find('.poll_answer label .result').hide().fadeIn(150);
                        }
                    }
                }
            });
        });
    }

    /* ===== LIGHT BOX ===== */

    const $images = jQuery('p > img:not(.emoji), .wp-caption, .wp-block-image > figure, .blocks-gallery-item > figure');

    $images.stop().click(function () {
        showLightBox($(this).children('img').length === 0 ? ($(this).attr('srcset') ? $(this).attr('srcset') : $(this).attr('src')) : ($(this).children('img').attr('srcset') ? $(this).children('img').attr('srcset') : $(this).children('img').attr('src')), jQuery(this), $images);
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

})
;