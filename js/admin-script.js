jQuery(document).ready(function ($) {

    $('.button--blue').click(function () {
        if($(this).hasClass('button--flat')) {
            window.open('https://docs.google.com/document/d/e/2PACX-1vTnKZQqswvZx24J_CVc9ktyl5CP6DIRsOFqPkd0bicEnOyXUe4euVuWgy5kRu6x42ROKg2bz_GsB3hQ/pub', '_blank');
        } else {
            window.open('https://docs.google.com/document/d/1LMeFsfvCd46F_88NPeWPwBIK5HY1g4YdMP3uFZJqorI/edit', '_blank');
        }
    });

});