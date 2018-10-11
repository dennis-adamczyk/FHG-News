jQuery(document).ready(function ($) {

    var infiniteScroll_page = 1;
    var infiniteScroll_loading = false;
    let infiniteScroll_ajaxURL = php_vars.admin_ajax_url;
    let infiniteScroll_max_num_pages = parseInt(php_vars.max_num_pages);

    $(window).scroll(function () {
        if (($(window).scrollTop() >= $(document).height() - $(window).height() - (is_mobile() ? 768 : 384)) && !infiniteScroll_loading) {
            infiniteScroll_loading = true;
            $.ajax({
                url: infiniteScroll_ajaxURL,
                type: 'POST',
                data: {
                    page: infiniteScroll_page,
                    action: 'fhgnewsonline_infinite_scroll_content',
                },
                success: function (response) {
                    $('.main .posts').append(response);
                    infiniteScroll_page++;
                    infiniteScroll_loading = false;

                    if (infiniteScroll_page === infiniteScroll_max_num_pages) {
                        infiniteScroll_loading = true;
                        $('.infiniteScroller').hide();
                    }
                }
            });

        }
    });

});