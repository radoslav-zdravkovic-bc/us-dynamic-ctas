var checkReady = function(callback) {
    if (window.jQuery) {
        callback(jQuery);
    }
    else {
        window.setTimeout(function() { checkReady(callback); }, 100);
    }
};
checkReady(function(jQuery) {
    //Check for complete load of page.
    jQuery(document).ready(function(jQuery) {
        function getParam(name) {
            return (location.search.split(name + '=')[1] || '').split('&')[0];
        }

        var getBookmaker = getParam('bookmaker');

        jQuery('.dynamic-cta-block .copy-code-container').each(function(){
            var bookmaker = jQuery(this).attr('bookmaker');

            if(bookmaker === getBookmaker) {
                jQuery(this).find('.blured').removeClass('blured');
                jQuery(this).find('a.copy-bonus-code').css('pointer-events', 'none').addClass('copied').find('.btn-inner').empty().prepend('Copied!');
            }
        });

    }); // END OF DOCUMENT READY
}); // END OF CHECKREADY
