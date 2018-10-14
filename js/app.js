jQuery(document).ready(function ($) {

    /*
    ======================================
        Local Storage
    ======================================
     */

    const localStorage = window.localStorage;
    const searchHis = 'search-history';
    if (localStorage.getItem(searchHis) === null) {
        localStorage.setItem(searchHis, '[]');
    }

    function addSearchHistory(key) {
        key = key.trim();
        var history = JSON.parse(localStorage.getItem(searchHis));
        if (history.includes(key) || history.filter((e) => e.toLowerCase() === key)) {
            history = history.filter(function (e) {
                return e.toLowerCase() !== key.toLowerCase();
            });
            history.unshift(key);
        } else {
            history.unshift(key);
        }
        history = history.slice(0, 64);
        localStorage.setItem(searchHis, JSON.stringify(history));
    }

    function removeSearchHistory(key) {
        key = key.trim();
        var history = JSON.parse(localStorage.getItem(searchHis));
        history = history.filter(function (e) {
            return e !== key
        });
        localStorage.setItem(searchHis, JSON.stringify(history));
    }

    function getSearchHistory() {
        return JSON.parse(localStorage.getItem(searchHis));
    }

    /*
    ======================================
        Waves
    ======================================
     */

    Waves.attach('.ripple');
    Waves.attach('.ripple--icon', ['waves-circle']);
    Waves.attach('.ripple--box', ['waves-box']);
    Waves.attach('.ripple--icon--light', ['waves-circle', 'waves-light']);
    Waves.attach('div.button:not(.button--flat):not(.button--light)', ['waves-float', 'waves-light']);
    Waves.attach('div.button--light', ['waves-float']);
    Waves.attach('div.button--flat');
    if ($(window).width() < 800)
        Waves.attach('.ripple--mobile');
    Waves.init({
        duration: 200,
        delay: 0
    });

    /*
    ======================================
        Infinite Scroll
    ======================================
     */

    if (window.location.hash)
        history.replaceState(null, null, window.location.href.replace(/(page\/\S*(?=\?)|page\/(\S*))|#\S*(?=\?)|#\S*/g, ''));

    /*
    ======================================
        Inputs
    ======================================
     */

    let $input = $('.input input, .input--textarea:not(.input--line) textarea');
    let $inputGroup = $('.input');
    let $inputCancel = $($inputGroup.find('i:not(.leadingIcon)'));

    $inputGroup.click(function () {
        $(this).find('input, textarea').focus();
    });

    $inputCancel.click(function () {
        if (!$(this).parent().hasClass('isInvalid'))
            $(this).parent().find('input, textarea').val('');
    });

    $input.each(function () {
        changeInputState($(this));
        if ($(this).is('textarea'))
            auto_grow(this);
    });

    $input.focusout(function () {
        changeInputState($(this));
        if ($(this).is('textarea'))
            auto_grow(this);
    });

    $('.input--textarea:not(.input--line) textarea').on('input', function () {
        auto_grow(this);
    });

    function changeInputState($inputControl) {
        if ($inputControl.val().length > 0) {
            $inputControl.addClass('hasValue');
        } else {
            $inputControl.removeClass('hasValue');
        }
    }

    function auto_grow(textarea) {
        $(textarea).css('height', '5px');
        $(textarea).css('height', ($(textarea).prop('scrollHeight') - 11) + 'px');
    }

    jQuery.support.placeholder = (function () {
        var i = document.createElement('input');
        return 'placeholder' in i;
    })();

    try {
        if (!jQuery.support.placeholder) {
            $input.attr('placeholder', '');
        }
    } catch (e) {
        $input.attr('placeholder', '');
    }

    /*
    ======================================
        Snackbar
    ======================================
     */

    let snackbarPost = php_info.snackbar_post ? JSON.parse(php_info.snackbar_post) : false;
    let snackbarStorage = JSON.parse(localStorage.getItem('snackbar'));

    if (snackbarPost) {
        snackbarPost.forEach(function (obj) {

            if (obj.type === 'singleLine') {
                showSingleLineSnackBar(obj.message);
            } else if (obj.type === 'singleLineWithAction') {
                showSingleLineWithActionSnackbar(obj.message, obj.action, function () {
                    eval(obj.actionHandler)
                });
            }
        });
    }

    if (snackbarStorage) {
        snackbarStorage.forEach(function (obj) {
            if (obj.type === 'singleLine') {
                showSingleLineSnackBar(obj.message)
            } else if (obj.type === 'singleLineWithAction') {
                showSingleLineWithActionSnackbar(obj.message, obj.action, obj.actionHandler);
            }
        });
    }

    jQuery.ajax({
        type: 'POST',
        url: php_info.template_directory_uri + '/includes/snackbar.php',
        data: {
            method: 'reset'
        }
    });
    localStorage.removeItem('snackbar');

    /*
    ======================================
        Navigation
    ======================================
     */

    let $menu_button = $('.header__menu--menu');
    let $back_button = $('.header__menu--arrow_back');
    let $nav = $('.nav');
    let $overlay = $('overlay');

    $menu_button.click(function () {
        $nav.addClass('active');
        overlayFadeIn('nav');

    });

    $overlay.on('mousedown touchstart click', function () {
        if (!$(this).hasClass('active--nav'))
            return;
        $nav.removeClass('active');
        overlayFadeOut('nav');

    });

    $back_button.click(function () {
        window.history.back();
    });

    $(window).resize(function () {
        if ($(this).width() >= 1480 && $overlay.hasClass('active--nav')) {
            $overlay.removeAttr('class');
            $overlay.removeAttr('style');
            $nav.removeClass('active');
        }
    });

    document.addEventListener('touchstart', handleTouchStart, false);
    document.addEventListener('touchmove', handleTouchMove, false);

    var xDown = null;
    var yDown = null;

    function handleTouchStart(evt) {
        xDown = evt.touches[0].clientX;
        yDown = evt.touches[0].clientY;
    }

    function handleTouchMove(evt) {
        if (!xDown || !yDown) {
            return;
        }

        if (xDown > 50) {
            return;
        }

        var xUp = evt.touches[0].clientX;
        var yUp = evt.touches[0].clientY;

        var xDiff = xDown - xUp;
        var yDiff = yDown - yUp;

        if (Math.abs(xDiff) > Math.abs(yDiff)) {
            if (xDiff < 0) {
                $nav.addClass('active');
                overlayFadeIn('nav');
            }
        }

        xDown = null;
        yDown = null;
    }

    /*
    ======================================
        Header
    ======================================
     */

    var lastScroll;
    var scrollUp = 0;
    var scrollDown = 0;

    $(window).scroll(function () {
        currentScroll = $(this).scrollTop();
        if (lastScroll > currentScroll) {
            scrollUp += lastScroll - currentScroll;
            scrollDown = 0;
        } else if (lastScroll < currentScroll) {
            scrollDown += currentScroll - lastScroll;
            scrollUp = 0;
        }
        lastScroll = currentScroll;

        handleHeaderOnScroll(currentScroll);
    });

    let $appbar = $('.header');

    function handleHeaderOnScroll(currentScroll) {
        if (currentScroll <= 0) {
            $appbar.addClass('header--top');
        } else {
            $appbar.removeClass('header--top');

            if (scrollDown >= 50) {
                $appbar.addClass('header--collapsed');
            } else if (scrollUp >= 50) {
                $appbar.removeClass('header--collapsed');
            }
        }
    }

    handleHeaderOnScroll($(window).scrollTop());

    /* HEADER ADD  */
    $($appbar.find('.header__add')).on('mouseup', function (e) {
        switch (e.button) {
            case 1:
            case 4:
                window.open(php_info.admin_url + '/post-new.php', '_blank').focus();
                break;

            case 0:
                window.location = php_info.admin_url + '/post-new.php';
                break;
        }
    });

    $($appbar.find('.header__profile')).click(showUserOptions);

    /* HEADER SEARCH */

    const $content = $('content');

    const showSearchSuggestions = function (filter) {
        if (is_mobile()) {
            if ($content.find('.searchSuggestions').length === 0)
                $content.prepend('<div class="searchSuggestions"><ul></ul></div>');

            let $searchSugs = $($content.find('.searchSuggestions'));
            let $searchSugsList = $($searchSugs.find('ul'));

            $searchSugsList.empty();

            if (!filter) {
                getSearchHistory().forEach(function (elem) {
                    $searchSugsList.append(`
                    <li data-val="` + elem + `">
                      <div class="searchSuggestions__icon"><i class="material-icons">history</i></div>
                      <p>` + elem + `</p>
                      <div class="searchSuggestions__insert"><img src="` + php_info.template_directory_uri + `/img/icons/insert.svg"></div>
                    </li>`);
                });
            } else {
                getSearchHistory().filter((suggestion) => suggestion.toLowerCase().startsWith(filter.toLowerCase())).forEach(function (elem) {
                    $searchSugsList.append(`
                    <li data-val="` + elem + `">
                      <div class="searchSuggestions__icon"><i class="material-icons">history</i></div>
                      <p>` + elem + `</p>
                      <div class="searchSuggestions__insert"><img src="` + php_info.template_directory_uri + `/img/icons/insert.svg"></div>
                    </li>`);
                });
            }

            Waves.attach('.searchSuggestions ul li');
            Waves.attach('.searchSuggestions__insert');
            Waves.init();

            let $searchSug = $($searchSugsList.find('li'));
            let $insert = $($searchSugsList.find('.searchSuggestions__insert'));
            let $input = $($appbar.find('.header--search__input'));

            $searchSug.click(function () {
                $input.val($(this).data('val'));
                search($(this).data('val'));
            });

            $insert.click(function (e) {
                $input.val($(this).parents('li').data('val'));
                $input.focus();
                showSearchSuggestions($input.val());
                e.stopPropagation();
            });

            var timer;
            let touchduration = 500;
            var ontaphold;
            var selectedSug;
            $searchSug.on('touchstart', function () {
                selectedSug = $(this).data('val');
                timer = setTimeout(ontaphold, touchduration);
            });
            $searchSug.on('touchend', function () {
                if (timer)
                    clearTimeout(timer);
            });
            ontaphold = function () {
                let value = selectedSug;
                overlayFadeIn('deleteSearchSug');
                showAlertDialog('"' + value + '" aus Suchverlauf entfernen?', ['Abbrechen', 'Entfernen']).then((res) => {
                    if (res === "Entfernen") {
                        removeSearchHistory(value);
                        if ($input.val()) {
                            showSearchSuggestions($input.val());
                        } else {
                            showSearchSuggestions();
                        }
                    }
                    overlayFadeOut('deleteSearchSug');
                });
            };

            jQuery('body').css('overflow', 'hidden');
        } else {
            if ($content.find('.searchSuggestions').length === 0)
                $content.prepend('<div class="searchSuggestions"><ul></ul></div>');

            let $searchSugs = $($content.find('.searchSuggestions'));
            let $searchSugsList = $($searchSugs.find('ul'));

            $searchSugsList.empty();

            if (!filter) {
                getSearchHistory().slice(0, 6).forEach(function (elem) {
                    $searchSugsList.append(`
                    <li data-val="` + elem + `">
                      <p>` + elem + `</p>
                      <div class="searchSuggestions__delete"><i class="material-icons">close</i></div>
                    </li>`);
                });
            } else {
                getSearchHistory().filter((suggestion) => suggestion.toLowerCase().startsWith(filter.toLowerCase())).slice(0, 6).forEach(function (elem) {
                    $searchSugsList.append(`
                    <li data-val="` + elem + `">
                      <p>` + elem + `</p>
                      <div class="searchSuggestions__delete"><i class="material-icons">close</i></div>
                    </li>`);
                });
            }

            Waves.attach('.searchSuggestions ul li');
            Waves.attach('.searchSuggestions ul li .searchSuggestions__delete');
            Waves.init();

            let $searchSug = $($searchSugsList.find('li'));
            let $delete = $($searchSug.find('.searchSuggestions__delete'));
            let $input = $($appbar.find('.header--search__input'));

            if ($searchSug.length === 0)
                $searchSugs.remove();

            var li = $searchSug;
            var liSelected;
            $(window).keydown(function (e) {
                if (e.which === 40) {
                    if (liSelected) {
                        liSelected.removeClass('selectedSug');
                        next = liSelected.next();
                        if (next.length > 0) {
                            liSelected = next.addClass('selectedSug');
                        } else {
                            liSelected = li.eq(0).addClass('selectedSug');
                        }
                    } else {
                        liSelected = li.eq(0).addClass('selectedSug');
                    }
                    $input.val(liSelected.find('p').text());
                } else if (e.which === 38) {
                    if (liSelected) {
                        liSelected.removeClass('selectedSug');
                        next = liSelected.prev();
                        if (next.length > 0) {
                            liSelected = next.addClass('selectedSug');
                        } else {
                            liSelected = li.last().addClass('selectedSug');
                        }
                    } else {
                        liSelected = li.last().addClass('selectedSug');
                    }
                    $input.val(liSelected.find('p').text());
                }
            });

            $searchSug.click(function () {
                $input.val($(this).data('val'));
                search($(this).data('val'));
            });

            $delete.click(function (e) {
                let value = $(this).parent('li').data('val');
                overlayFadeIn('deleteSearchSug');
                showAlertDialog('"' + value + '" aus Suchverlauf entfernen?', ['Abbrechen', 'Entfernen']).then((res) => {
                    if (res === "Entfernen") {
                        removeSearchHistory(value);
                        if ($input.val()) {
                            showSearchSuggestions($input.val());
                        } else {
                            showSearchSuggestions();
                        }
                    }
                    overlayFadeOut('deleteSearchSug');
                });
                e.stopPropagation();
            });
        }
    };

    const hideSearchSuggestions = function () {
        $content.find('.searchSuggestions').remove();
        jQuery('body').css('overflow', 'auto');
    };

    const search = function (searchkey) {
        addSearchHistory(searchkey);
        if ($('body').hasClass('search')) {
            window.location.replace(php_info.home_url + '/?s=' + searchkey);
        } else {
            window.location = php_info.home_url + '/?s=' + searchkey;
        }
    };


    $($appbar.find('.header__search')).click(function () {
        $appbar.addClass('header--search');

        $appbar.prepend(`
          <div class="header--search__back ripple--icon"><i class="material-icons">arrow_back</i></div>
          <input type="text" placeholder="Suchen" name="s" autocomplete="off" class="header--search__input" id="search_input">
          <div class="header--search__voice ripple--icon"><i class="material-icons">keyboard_voice</i></div>
          <div class="header--search__delete ripple--icon"><i class="material-icons">close</i></div>`);

        let $back = $($appbar.find('.header--search__back'));
        let $input = $($appbar.find('.header--search__input'));
        let $voice = $($appbar.find('.header--search__voice'));
        let $delete = $($appbar.find('.header--search__delete'));

        $input.focus();
        showSearchSuggestions();

        $back.click(function () {
            hideSearchSuggestions();
            $appbar.removeClass('header--search');
            $('*[class^="header--search__"]').remove();
        });

        $voice.click(function () {
            try {
                var SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                new SpeechRecognition();
            } catch (e) {
                console.error(e);
                overlayFadeIn('error-voice');
                showAlertDialog('Dein Browser unterstützt die Spracheingabe nicht.', ['OK']).then((res) => overlayFadeOut('error-voice'));
                return;
            }
            const recognition = new SpeechRecognition();
            recognition.interimResults = true;

            recognition.addEventListener('result', function (e) {
                const transcript = Array.from(e.results)
                    .map(result => result[0])
                    .map(result => result.transcript)
                    .join('');

                $input.val(transcript);
                showSearchSuggestions(transcript);
            });

            recognition.addEventListener('end', function () {
                search($input.val());
            });

            $delete.click(function () {
                recognition.abort();
            });

            recognition.start();
            $voice.hide();
            $delete.show();
        });

        $input.keyup(function (e) {
            if (e.keyCode === 38 || e.keyCode === 40) return;
            if ($(this).val()) {
                $voice.hide();
                $delete.show();
                showSearchSuggestions($(this).val());
            } else {
                $voice.show();
                $delete.hide();
                showSearchSuggestions();
            }

            if (e.keyCode === 13 && $(this).val().trim() !== '') {
                search($(this).val());
            }
        });

        $delete.click(function () {
            $input.val('');
            $voice.show();
            $delete.hide();
            $input.focus();
            showSearchSuggestions();
        });

        Waves.attach('.header--search__back');
        Waves.attach('.header--search__voice');
        Waves.attach('.header--search__delete');
        Waves.init();
    });


    /* SEARCH RESULTS PAGE HEADER */
    if ($('body').hasClass('search')) {
        $appbar.addClass('header--search');

        $appbar.prepend(`
          <div class="header--search__back ripple--icon"><i class="material-icons">arrow_back</i></div>
          <input type="text" placeholder="Suchen" name="s" autocomplete="off" class="header--search__input" id="search_input">
          <div class="header--search__voice ripple--icon"><i class="material-icons">keyboard_voice</i></div>
          <div class="header--search__delete ripple--icon"><i class="material-icons">close</i></div>`);

        let $back = $($appbar.find('.header--search__back'));
        let $input = $($appbar.find('.header--search__input'));
        let $voice = $($appbar.find('.header--search__voice'));
        let $delete = $($appbar.find('.header--search__delete'));

        $input.val(new URL(window.location).searchParams.get('s'));
        $voice.hide();
        $delete.show();

        $back.click(function () {
            window.history.back();
        });

        $voice.click(function () {
            try {
                var SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                new SpeechRecognition();
            } catch (e) {
                console.error(e);
                overlayFadeIn('error-voice');
                showAlertDialog('Dein Browser unterstützt die Spracheingabe nicht.', ['OK']).then((res) => overlayFadeOut('error-voice'));
                return;
            }
            const recognition = new SpeechRecognition();
            recognition.interimResults = true;

            recognition.addEventListener('result', function (e) {
                const transcript = Array.from(e.results)
                    .map(result => result[0])
                    .map(result => result.transcript)
                    .join('');

                $input.val(transcript);
                showSearchSuggestions(transcript);
            });

            recognition.addEventListener('end', function () {
                search($input.val());
            });

            $delete.click(function () {
                recognition.abort();
            });

            recognition.start();
            $voice.hide();
            $delete.show();
        });

        $input.keyup(function (e) {
            if (e.keyCode === 38 || e.keyCode === 40) return;
            if ($(this).val()) {
                $voice.hide();
                $delete.show();
                showSearchSuggestions($(this).val());
            } else {
                $voice.show();
                $delete.hide();
                showSearchSuggestions();
            }

            if (e.keyCode === 13 && $(this).val().trim() !== '') {
                search($(this).val());
            }
        });

        $input.on('focusin', function () {
            showSearchSuggestions($(this).val());
        });

        $delete.click(function () {
            $input.val('');
            $voice.show();
            $delete.hide();
            $input.focus();
            showSearchSuggestions();
        });

        Waves.attach('.header--search__back');
        Waves.attach('.header--search__voice');
        Waves.attach('.header--search__delete');
        Waves.init();
    }

    /* ==============================
    *   Category Widget
    *   ============================= */

    $('content .wrapper .sidebar .sidebar__widget.widget_categories h2 ul li:not(.current-cat) a').each(function (index, value) {
        get_rl_color($(value).text()).success(function (data) {
            data = data.substr(0, 7);
            $(value).css('color', data);
        });
    });

    $('content .wrapper .sidebar .sidebar__widget.widget_categories h2 ul li.current-cat a').each(function (index, value) {
        get_rl_color($(value).text()).success(function (data) {
            data = data.substr(0, 7);
            $(value).css('background-color', data);
        });
    });

});

window.onpopstate = function (e) {
    if (e.state !== 'lightBox')
        hideLightBox();
};

var lightBox_active_img = null;
var lightBox_GUI_active = true;

function showLightBox(srcset, $image, $images) {
    if (!new URLSearchParams(window.location.search).has('lightBox'))
        history.pushState('lightBox', null, '?lightBox');

    const $lightBox = jQuery('.lightBox');
    index = null;
    $lightBox.find('.lightBox__captionBox, .lightBox__header, .lightBox__left, .lightBox__right').show();
    $lightBox.find('.lightBox__captionBox__caption').text('');

    $lightBox.find('.lightBox__image').attr('srcset', srcset);
    $lightBox.find('.lightBox__header__page__index').text(jQuery($images).index($image) + 1);
    $lightBox.find('.lightBox__header__page__total').text($images.length);
    if ($image.children('figcaption').length !== 0) {
        $lightBox.find('.lightBox__captionBox__caption').text($image.children('figcaption').text());
    } else {
        $lightBox.find('.lightBox__captionBox').hide();
    }

    $lightBox.find('.lightBox__left').off().bind('click', function (e) {
        active_container = null;
        if (jQuery($images).index($image) === 0) {
            active_container = jQuery($images.get($images.length - 1));
            lightBox_active_img = jQuery($images.get($images.length - 1)).children('img').length === 0 ? jQuery($images.get($images.length - 1)) : jQuery($images.get($images.length - 1)).children('img');
        } else {
            active_container = jQuery($images.get(jQuery($images).index($image) - 1));
            lightBox_active_img = jQuery($images.get(jQuery($images).index($image) - 1)).children('img').length === 0 ? jQuery($images.get(jQuery($images).index($image) - 1)) : jQuery($images.get(jQuery($images).index($image) - 1)).children('img');
        }
        showLightBox(lightBox_active_img.attr('srcset'), active_container, $images);
        e.stopPropagation();
    });

    $lightBox.find('.lightBox__right').off().bind('click', function (e) {
        active_container = null;
        if (jQuery($images).index($image) === $images.length - 1) {
            active_container = jQuery($images.get(0));
            lightBox_active_img = jQuery($images.get(0)).children('img').length === 0 ? jQuery($images.get(0)) : jQuery($images.get(0)).children('img');
        } else {
            active_container = jQuery($images.get(jQuery($images).index($image) + 1));
            lightBox_active_img = jQuery($images.get(jQuery($images).index($image) + 1)).children('img').length === 0 ? jQuery($images.get(jQuery($images).index($image) + 1)) : jQuery($images.get(jQuery($images).index($image) + 1)).children('img');
        }
        showLightBox(lightBox_active_img.attr('srcset'), active_container, $images);
        e.stopPropagation();
    });

    $lightBox.off().bind('click', function () {
        if (lightBox_GUI_active) {
            $lightBox.find('.lightBox__header, .lightBox__left, .lightBox__right, .lightBox__captionBox').fadeOut(180);
            lightBox_GUI_active = false;
        } else {
            $lightBox.find('.lightBox__header, .lightBox__left, .lightBox__right').fadeIn(150);
            if ($lightBox.find('.lightBox__captionBox__caption').text() !== '') $lightBox.find('.lightBox__captionBox').fadeIn(150);
            lightBox_GUI_active = true;
        }
    });

    $lightBox.fadeIn(150);
    jQuery('body').css('overflow', 'hidden');
    lightBox_active_img = $image;
}

function hideLightBox() {
    if (new URLSearchParams(window.location.search).has('lightBox'))
        history.back();
    let $lightBox = jQuery('.lightBox');
    $lightBox.fadeOut(180);
    jQuery('body').css('overflow', 'auto');
    lightBox_GUI_active = true;
    if (event) event.stopPropagation();
}

/*
    ======================================
        Dialogs
    ======================================
     */

/**
 * Shows an Alert Dialog
 * @param question Label
 * @param buttons Labels of Bottons
 */

function showAlertDialog(question, buttons = ['Abbrechen', 'OK']) {
    return new Promise((resolve) => {
        const $ = jQuery;
        if ($('dialogbox').attr('open'))
            return;
        $('dialogbox').addClass('alert');
        let $dialog = $('dialogbox.alert');

        var $buttonsHTML = '';
        $(buttons).each(function (index, elem) {
            $buttonsHTML += '<div class="button button--flat"><span>' + elem + '</span></div>';
        });

        $dialog.html(`
            <p class="label">` + question + `</p>
            <div class="buttons">
              ` + $buttonsHTML + `
            </div>
        `);

        $dialog.fadeIn(200, function () {
            $dialog.attr('open', '');
            Waves.attach('dialogbox .buttons .button');
            Waves.init();
            $($dialog.find('.button')).on('click', function () {
                resolve($(this).find('span').text());
                $dialog.fadeOut(180, function () {
                    $dialog.html('');
                    $dialog.removeClass('alert');
                    $dialog.removeAttr('open');
                });
            });
        });

    });
}

/**
 * Shows the Share Dialog
 * @param url Link of Article
 * @param title Title of Article
 * @returns {Promise<any>} callback
 */
function showShareDialog(url, title) {
    return new Promise((resolve, reject) => {

        const $ = jQuery;
        if ($('dialogbox').attr('open'))
            return;
        $('dialogbox').addClass('share');
        let $dialog = $('dialogbox.share');

        $dialog.html(`
            <div class="close"><i class="material-icons">close</i></div>
            <p class="label">Teilen via</p>
            <ul>
              <li data-val="whatsapp">
                <i><img src="` + php_info.template_directory_uri + `/img/icons/whatsapp.svg"></i>
                <p>WhatsApp</p>
              </li>
              <li data-val="facebook">
                <i><img src="` + php_info.template_directory_uri + `/img/icons/facebook.svg"></i>
                <p>Facebook</p>
              </li>
              <li data-val="twitter">
                <i><img src="` + php_info.template_directory_uri + `/img/icons/twitter.svg"></i>
                <p>Twitter</p>
              </li>
              <li data-val="email">
                <i class="material-icons">email</i>
                <p>E-Mail</p>
              </li>
              <li data-val="link">
                <i class="material-icons">link</i>
                <p>Link kopieren</p>
              </li>
            </ul>
        `);

        overlayFadeIn('share');
        $dialog.fadeIn(200, function () {
            $dialog.attr('open', '');
            Waves.attach('dialogbox ul li');
            Waves.attach('dialogbox .close');
            Waves.init();

            var closeShareDialog = function () {
                resolve();
                overlayFadeOut('share');
                $dialog.fadeOut(180, function () {
                    $dialog.html('');
                    $dialog.removeClass('alert');
                    $dialog.removeClass('share');
                    $dialog.removeAttr('open');
                });
            };

            $($dialog.find('div.close')).on('click', closeShareDialog);
            $('overlay').on('click', closeShareDialog);
            $($dialog.find('li')).on('click', function () {
                switch ($(this).data('val')) {
                    case 'whatsapp':
                        window.open('https://api.whatsapp.com/send?text=Habe%20diesen%20Beitrag%20namens%20%22' + encodeURI(title) + '%22%20auf%20FHG%20News%20online%20gefunden,%20vielleicht%20k%C3%B6nnte%20er%20dich%20interessieren:%0A' + encodeURI(url), '_blank');
                        break;

                    case 'facebook':
                        window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURI(url), '_blank');
                        break;

                    case 'twitter':
                        window.open('https://twitter.com/intent/tweet?url=' + encodeURI(url) + '&text=Ich%20habe%20gerade%20diesen%20Beitrag%20namens%20%22' + encodeURI(title) + '%22%20auf%20FHG%20News%20online%20gelesen%2C%20vielleicht%20k%C3%B6nnte%20er%20euch%20interessieren.', '_blank');
                        break;

                    case 'email':
                        window.open('mailto:empfaenger@domain.de?body=Ich%20habe%20gerade%20diesen%20Beitrag%20namens%20%22' + encodeURI(title) + '%22%20auf%20FHG%20News%20online%20gelesen%2C%20vielleicht%20k%C3%B6nnte%20er%20euch%20interessieren:%0A' + encodeURI(url), '_blank');
                        break;

                    case 'link':
                        const el = document.createElement('textarea');
                        el.value = url;
                        el.setAttribute('readonly', '');
                        el.style.position = 'absolute';
                        el.style.left = '-9999px';
                        document.body.appendChild(el);
                        el.select();
                        document.execCommand('copy');
                        document.body.removeChild(el);
                        showSingleLineSnackBar('Link in Zwischenablage kopiert');
                        break;
                }
                closeShareDialog();
            });
        });

    });
}

function is_logged_in() {
    return jQuery('body').hasClass('logged-in');
}

function is_mobile() {
    return jQuery(window).width() < 800;
}

function overlayFadeIn(clazz, callback = false) {
    jQuery('overlay').fadeIn(150, function () {
        jQuery('body').css('overflow', 'hidden');
        if (callback) callback(this);
        jQuery(this).addClass('active active--' + clazz);
    });
}

function overlayFadeOut(clazz, callback = false) {
    jQuery('body').css('overflow', 'auto');
    jQuery('overlay').fadeOut(180, function () {
        if (callback) callback(this);
        jQuery(this).removeClass('active active--' + clazz);
    });
}

function showUserOptions(e) {
    if (e.button === 2)
        return;

    if (!is_logged_in()) {
        if (e.button === 0)
            window.location = php_info.login_url;
        else
            window.open(php_info.login_url, '_blank').focus();
        return;
    }

    if (is_mobile()) {
        overlayFadeIn('userOptions', function (overlay) {
            jQuery(overlay).bind('click', hideUserOptions);
        });
        jQuery('.userOptions').fadeIn(150);
    } else if (e.button === 0) {
        jQuery('.userOptions').slideDown(150, function () {
            jQuery(window).bind('click scroll', hideUserOptions);
        });
    }
}

function hideUserOptions() {
    jQuery('overlay').unbind('click', hideUserOptions);
    jQuery(window).unbind('click scroll', hideUserOptions);
    if (is_mobile()) {
        jQuery('.userOptions').fadeOut(180);
        overlayFadeOut('userOptions');
    } else {
        jQuery('.userOptions').slideUp(180);
    }

}

function showSingleLineSnackBar($message) {
    jQuery('.snackBox').show().append('<div class="snackBar"><p>' + $message + '</p></div>');
    jQuery('.snackBar:last').fadeIn(180, function () {
        const self = this;
        setTimeout(function () {
            jQuery(self).fadeOut(180, function () {
                jQuery(self).remove();
            });
        }, 5000);
    });
}

function addNextSingleLineSnackbar($message) {
    var snackbar = window.localStorage.getItem('snackbar');
    if (snackbar !== null && snackbar !== '' && snackbar !== undefined) {
        snackbar = JSON.parse(snackbar);
        snackbar.push({
            'type': 'singleLine',
            'message': $message
        });
    } else {
        snackbar = [
            {
                'type': 'singleLine',
                'message': $message
            }
        ];
    }
    window.localStorage.setItem('snackbar', JSON.stringify(snackbar));
}

function showSingleLineWithActionSnackbar($message, $action, $actionHandler) {
    jQuery('.snackBox').show().append('<div class="snackBar snackBar--action"><p>' + $message + '</p><div class="button button--flat"><span>' + $action + '</span></div></div>');
    jQuery('.snackBar:last').fadeIn(180, function () {
        const self = this;
        jQuery(self).find('.button').click($actionHandler);
        Waves.attach('.snackBar .button', ['waves-light']);
        Waves.init();
        setTimeout(function () {
            jQuery(self).fadeOut(180, function () {
                jQuery(self).remove();
            });
        }, 5000);
    });
}

function addNextSingleLineWithActionSnackbar($message, $action, $actionHandler) {
    var snackbar = window.localStorage.getItem('snackbar');
    if (snackbar !== null && snackbar !== '' && snackbar !== undefined) {
        snackbar = JSON.parse(snackbar);
        snackbar.push({
            'type': 'singleLineWithAction',
            'message': $message,
            'action': $action,
            'actionHandler': $actionHandler
        });
    } else {
        snackbar = [
            {
                'type': 'singleLineWithAction',
                'message': $message,
                'action': $action,
                'actionHandler': $actionHandler
            }
        ];
    }
    window.localStorage.setItem('snackbar', JSON.stringify(snackbar));
}

function current_user_like_post($post_id) {
    return jQuery.ajax({
        type: 'POST',
        url: php_info.template_directory_uri + '/includes/likeRequest.php',
        data: {
            method: 'add_like_current_user',
            post_id: $post_id
        }
    });
}

function openURL(url, e) {
    if (e.button === 2)
        return;

    if (is_mobile() && e.button === 0)
        return window.location = url;

    if (e.button === 1 || e.button === 4)
        return window.open(url, '_blank').focus();

    window.location = url;
}

function current_user_unlike_post($post_id) {
    return jQuery.ajax({
        type: 'POST',
        url: php_info.template_directory_uri + '/includes/likeRequest.php',
        data: {
            method: 'remove_like_current_user',
            post_id: $post_id
        }
    });
}

function current_user_like_comment($comment_id) {
    return jQuery.ajax({
        type: 'POST',
        url: php_info.template_directory_uri + '/includes/likeRequest.php',
        data: {
            method: 'add_comment_like_current_user',
            comment_id: $comment_id
        }
    });
}

function current_user_unlike_comment($comment_id) {
    return jQuery.ajax({
        type: 'POST',
        url: php_info.template_directory_uri + '/includes/likeRequest.php',
        data: {
            method: 'remove_comment_like_current_user',
            comment_id: $comment_id
        }
    });
}

function get_rl_color($category) {
    return jQuery.ajax({
        type: 'POST',
        url: php_info.ajax_url,
        data: {
            action: 'get_rl_color',
            cat: $category
        }
    });
}

function infiniteScroll(type = 'blog', details = {}) {
    let $ = jQuery;

    var infiniteScroll_page = php_info.paged;
    var infiniteScroll_loading = false;
    let infiniteScroll_ajaxURL = php_info.ajax_url;
    let infiniteScroll_max_num_pages = parseInt(php_info.max_num_pages);

    infiniteScroll_deactivateIfMaxPage();

    $(window).scroll(function () {
        if (($(window).scrollTop() >= $(document).height() - $(window).height() - (is_mobile() ? 768 : 384)) && !infiniteScroll_loading) {
            infiniteScroll_loading = true;
            $.ajax({
                url: infiniteScroll_ajaxURL,
                type: 'POST',
                data: {
                    page: infiniteScroll_page,
                    type: type,
                    details: details,
                    action: 'fhgnewsonline_infinite_scroll_content',
                },
                success: function (response) {
                    $('content .posts').append(response);
                    infiniteScroll_page++;
                    infiniteScroll_loading = false;
                    infiniteScroll_deactivateIfMaxPage();
                    $('content').find('.post').unbind('click', infiniteScroll_replacePage).bind('click', infiniteScroll_replacePage);
                }
            });

        }
    });

    $('.post').unbind('click', infiniteScroll_replacePage).bind('click', infiniteScroll_replacePage);

    function infiniteScroll_replacePage() {
        $id = $(this).attr('id');
        history.replaceState(null, null, window.location.href.replace(/(page\/\S*(?=\?)|page\/(\S*))|#\S*(?=\?)|#\S*/g, '') + 'page/' + Math.max(Math.ceil($id / 4), 1) + '/#' + $id);
    }

    function infiniteScroll_deactivateIfMaxPage() {
        if (infiniteScroll_page >= infiniteScroll_max_num_pages) {
            infiniteScroll_loading = true;
            $('.infiniteScroller').hide();
        }
    }
}

function infiniteScrollRecommended(post) {
    let $ = jQuery;

    var infiniteScroll_page = 1;
    var infiniteScroll_loading = false;
    let infiniteScroll_ajaxURL = php_info.ajax_url;
    let type = 'recommended';

    infiniteScroll_deactivateIfMaxPage();

    $(window).scroll(function () {
        if (($(window).scrollTop() >= $(document).height() - $(window).height() - (is_mobile() ? 384 : 256)) && !infiniteScroll_loading) {
            infiniteScroll_loading = true;
            $.ajax({
                url: infiniteScroll_ajaxURL,
                type: 'POST',
                data: {
                    page: infiniteScroll_page,
                    type: type,
                    details: {'post': post},
                    action: 'fhgnewsonline_infinite_scroll_content',
                },
                success: function (response) {
                    infiniteScroll_loading = false;
                    if (!infiniteScroll_deactivateIfMaxPage(response))
                        $('.recommended .recommended__posts').append(response);
                    infiniteScroll_page++;
                }
            });

        }
    });

    function infiniteScroll_deactivateIfMaxPage(response = '') {
        if ($('.recommended .recommended__posts').html().trim().startsWith('<div class="recommended__error">') || response.trim().startsWith('<div class="recommended__error">')) {
            infiniteScroll_loading = true;
            $('.infiniteScroller').hide();
            return true;
        }
        return false;
    }
}