var checkReady = function (callback) {
    if (window.jQuery) {
        callback(jQuery);
    } else {
        window.setTimeout(function () {
            checkReady(callback);
        }, 100);
    }
};
checkReady(function (jQuery) {
    //Check for complete load of page.
    jQuery(document).ready(function (jQuery) {

        function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
        }

        if (window.location.href.indexOf("bookmaker") > -1) {

            var bookmakerValue = getUrlParameter('bookmaker');
            var ctaBlock = jQuery('.copy-code-container[bookmaker="' + bookmakerValue + '"]').parent('.dynamic-cta-block');
            var bonuscode = jQuery('.copy-code-container[bookmaker="' + bookmakerValue + '"]').find('.bonuscode-container').find('.bonuscode');

            bonuscode.removeClass("blured");
        }


        jQuery('html, body').animate({
            scrollTop: ctaBlock.offset().top
        }, 2000);

    }); // END OF DOCUMENT READY
}); // END OF CHECKREADY
