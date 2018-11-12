jQuery(document).ready(function ($) {

    /*
    ======================================
        Waves
    ======================================
     */

    Waves.attach('.item--link', ['waves-box']);
    Waves.attach('.item--select .select li', ['waves-box']);
    Waves.init();

    /*
    ======================================
        Link
    ======================================
     */

    $('.item--link').click(function () {
        window.location = $(this).data('link');
    });

    /*
    ======================================
        Toggle
    ======================================
     */

    $('.item--toggle').click(function (e) {
        if ($(e.target).is('input')) return;
        let $checkbox = $(this).find('input');
        $checkbox.attr("checked", !$checkbox.attr("checked"));
        $checkbox.trigger('change');
        return false;
    });

    var xDown = null;
    var yDown = null;
    let $toggle = $('.toggle');

    $toggle.on('touchstart', function (e) {
        xDown = e.originalEvent.touches[0].clientX;
        yDown = e.originalEvent.touches[0].clientY;
    });

    $toggle.on('touchmove', function (e) {
        if (!xDown || !yDown) {
            return;
        }

        var xUp = e.originalEvent.touches[0].clientX;
        var yUp = e.originalEvent.touches[0].clientY;

        var xDiff = xDown - xUp;
        var yDiff = yDown - yUp;

        if (Math.abs(xDiff) > Math.abs(yDiff)) {
            if (xDiff < 0) {
                $(this)
                    .attr("checked", true)
                    .trigger('change');
            } else if (xDiff > 0) {
                $(this)
                    .attr("checked", false)
                    .trigger('change');
            }
        }

        xDown = null;
        yDown = null;
    });

    $toggle.change(function () {
        let $that = $(this);
        let $parent = $that.parent();
        let $checked = $that.attr('checked') !== undefined;
        let $settingsname = $parent.data('settingsname');

        if ($parent.hasClass('loading')) {
            $that.attr("checked", !$checked);
            return;
        }

        $parent
            .append('<div class="progress"><div class="indeterminate"></div></div>')
            .addClass('loading');


        applyChanges($settingsname, $checked);

        $.ajax({
            type: 'POST',
            url: php_info.ajax_url,
            data: {
                action: 'set_setting',
                settingsname: $settingsname,
                value: $checked
            },
            success: function (data) {
                if (!$.isNumeric(data)) {
                    $that.attr("checked", !$checked);
                    showSingleLineSnackBar('Fehler aufgetreten. Versuche es später erneut.');
                }
                $parent.removeClass('loading');
                $parent.find('.progress').remove();
            }
        });
    });

    /*
    ======================================
        Select
    ======================================
     */

    $('.item--select').click(function (e) {
        if ($(e.target).parents('.select').length !== 0 || $(e.target).hasClass('select') || $(this).hasClass('loading')) return;
        let selected = $(this).find('.selected').text();
        let selectedIndex = 0;
        let $select = $(this).find('.select');
        let $selectItems = $select.find('li');

        if (!$select.hasClass('visible')) $('.select.visible').fadeOut(150);

        $selectItems.each(function (index) {
            if ($(this).text() === selected.trim()) {
                selectedIndex = index;
                return false;
            }
        });

        $(this).css('overflow', 'visible');
        $select
            .css('top', (11 - (selectedIndex * 48)) + 'px')
            .fadeIn(150)
            .addClass('visible')
            .attr('data-selectedIndex', selectedIndex);
    });

    $(document).click(function (e) {
        if ($(e.target).hasClass('select') || $(e.target).parents('ul').hasClass('select') || $(e.target).hasClass('item--select') || $(e.target).parents('li').hasClass('item--select')) return;
        $('.select.visible').fadeOut(150).removeClass('visible');
    });

    $('.select li').click(function () {
        let $grandparent = $(this).parents('.item--select');
        let $select = $(this).parents('.select');
        let $selectItems = $select.find('li');
        let $selected = $grandparent.find('.selected');
        let selected = $selected.text();
        let newSelected = $(this).text();
        let newSelectedValue = $(this).data('value');
        let newSelectedIndex = 0;

        let $settingsname = $grandparent.data('settingsname');

        if ($grandparent.hasClass('loading')) return;

        $selectItems.each(function (index) {
            if ($(this).text() === newSelected) {
                newSelectedIndex = index;
                return false;
            }

        });
        $selected.text($(this).text());
        $select.css('top', (11 - (newSelectedIndex * 48)) + 'px');


        if (newSelected.trim() === selected.trim()) {
            $('.select.visible').fadeOut(150).removeClass('visible').removeAttr('data-selectedIndex');
            $grandparent.css('overflow', 'hidden');
            return;
        }

        setTimeout(function () {
            $select
                .fadeOut(150, function () {
                    $grandparent.css('overflow', 'hidden');
                })
                .removeClass('visible')
                .removeAttr('data-selectedIndex');
        }, 50);

        $grandparent
            .addClass('loading')
            .append('<div class="progress"><div class="indeterminate"></div></div>');

        applyChanges($settingsname, newSelectedValue);

        $.ajax({
            type: 'POST',
            url: php_info.ajax_url,
            data: {
                action: 'set_setting',
                settingsname: $settingsname,
                value: newSelectedValue
            },
            success: function (data) {
                if (!$.isNumeric(data)) {
                    $selected.text(selected);
                    showSingleLineSnackBar('Fehler aufgetreten. Versuche es später erneut.');
                }
                $grandparent.find('.progress').remove();
                $grandparent.removeClass('loading');
            }
        });

    });

    /*
    ======================================
        Apply Changes
    ======================================
     */

    function applyChanges(settingsname, value) {
        switch (settingsname) {
            case 'settings-push_notifications':
                if (value) {
                    OneSignal.registerForPushNotifications();
                } else {
                    OneSignal.setSubscription(false);
                }
                break;

            case 'settings-email_newsletter':
                if (value) {
                    let $newsletterAlert = $('.emailNewsletterAlert');
                    overlayFadeIn('newsletterAlert');
                    $newsletterAlert.attr('open', true);

                    $newsletterAlert.find('.button.abort').click(function () {
                        $('#emailNewsletter')
                            .attr('checked', false)
                            .change();
                        $newsletterAlert.removeAttr('open');
                        overlayFadeOut('newsletterAlert');
                    });

                    $newsletterAlert.find('.button.done').click(function () {
                        $('#cr_login').submit();
                        $('.emailNewsletterAlert').removeAttr('open');
                        overlayFadeOut('newsletterAlert');
                    });

                    let $htmlContent = $newsletterAlert.find('.htmlContent');
                    console.log($htmlContent.find('#text4347480'));
                    $htmlContent.find('#text4347480').val(php_info.user_email);
                    $htmlContent.find('#text4347524').val(php_info.display_name);
                } else {
                    $('#text4347481').val(php_info.user_email);
                    $('#cr_logout').submit();
                }
        }
    }

    /*
    ======================================
        OneSignal
    ======================================
     */

    window.addEventListener('load', function () {
        if ('OneSignal' in window) {
            OneSignal.on('subscriptionChange', function (status) {
                console.log(status);
                $('#pushNotifications')
                    .attr('checked', status);
                $.ajax({
                    type: 'POST',
                    url: php_info.ajax_url,
                    data: {
                        action: 'set_setting',
                        settingsname: 'settings-push_notifications',
                        value: status
                    },
                    success: function (data) {
                        console.log(data);
                    }
                });
            });
        }
    });

    /*
    ======================================
        Install Web App
    ======================================
     */

    if (!window.matchMedia('(display-mode: standalone)').matches && !window.navigator.standalone === true) {
        $('#settings').append(`
        <section class="install section">
            <h2 class="section__title">WebApp</h2>
            <ul class="section__list">
              <li class="installWebApp section__list__item item--link">
                <span>WebApp installieren</span>
              </li>
            </ul>
        </section>
        `);

        let deferredPrompt;
        let $install = $('#settings').find('.install');
        let $addBtn = $install.find('.installWebApp');
        $install.css('display', 'none');

        window.addEventListener('beforeinstallprompt', (e) => {
            // Prevent Chrome 67 and earlier from automatically showing the prompt
            e.preventDefault();
            // Stash the event so it can be triggered later.
            deferredPrompt = e;
            // Update UI to notify the user they can add to home screen
            $install.css('display', 'block');

            $addBtn.get(0).addEventListener('click', (e) => {
                // Show the prompt
                deferredPrompt.prompt();
                // Wait for the user to respond to the prompt
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted the A2HS prompt');
                    } else {
                        console.log('User dismissed the A2HS prompt');
                    }
                    deferredPrompt = null;
                });
            });
        });
    }

});
