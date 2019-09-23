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

    // Badge - Ribbon styles

    function drawRibon() {
      var top = jQuery('.fb-badge').outerHeight();
      var width = jQuery('.fb-badge').outerWidth();
      var color = jQuery('.fb-badge').css('background-color');

      jQuery('.fb-badge .ribbon-before').css({'left': '0', 'top': top, 'border-top': '30px solid ' + color, 'border-right': width + 'px solid transparent' });
      jQuery('.fb-badge .ribbon-after').css({'left': '0', 'top': top, 'border-top': '30px solid ' + color, 'border-left': width + 'px solid transparent' });
    }

    drawRibon();

    jQuery(window).resize(function() {
      drawRibon();
    });


    // Add "Register Now" link
    jQuery('.dynamic-cta-block .copy-code-container').each(function() {
      var href = jQuery( this ).find('a.copy-bonus-code').attr('href');
      jQuery( this ).after( "<p class='register_link'><a href='"+ href +"'>Register Now</a></p>" );

    });

  }); // END OF DOCUMENT READY
}); // END OF CHECKREADY
