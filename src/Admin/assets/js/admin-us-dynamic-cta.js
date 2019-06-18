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


  }); // END OF DOCUMENT READY
}); // END OF CHECKREADY
