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

    function copyToClipboard(element) {
      var $temp = jQuery("<input>");
      jQuery("body").append($temp);
      $temp.val(jQuery(element).text()).select();
      document.execCommand("copy");
      $temp.remove();
    }

    jQuery('.dynamic-cta-block a.copy-bonus-code').not('.just-copy').click(function(e){
      var bookmaker = jQuery(this).parent().attr('bookmaker');

      var elementToCopy = jQuery(this).parent().find('.bonuscode');

      copyToClipboard(elementToCopy);

      window.open('?blur=remove&bookmaker='+bookmaker,'_blank');
    });

    jQuery('.dynamic-cta-block a.just-copy').click(function(e){
      e.preventDefault();

      var elementToCopy = jQuery(this).parent().find('.bonuscode');

      copyToClipboard(elementToCopy);

      jQuery(this).empty().css('pointer-events', 'none').addClass('copied').prepend('Code Copied!');
    });

  }); // END OF DOCUMENT READY
}); // END OF CHECKREADY
