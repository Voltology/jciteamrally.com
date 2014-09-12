$(document).ready(function() {
  $('#file').change(function() {
    var filepath = $(this).val().split(/\\/);
    $('#selected-file').show();
    $('#selected-file-name').html(filepath[filepath.length - 1]);
    $('#upload-button').show();
    $('.fileinput-button').hide();
  });

  var fileSupported = (function () {
    if (navigator.userAgent.match(/(Android (1.0|1.1|1.5|1.6|2.0|2.1))|(Windows Phone (OS 7|8.0))|(XBLWP)|(ZuneWP)|(w(eb)?OSBrowser)|(webOS)|(Kindle\/(1.0|2.0|2.5|3.0))/)) {
      return false;
    }
    var el = document.createElement("input");
    el.type = "file";
    return !el.disabled;
  })();

  if (!fileSupported) {
    $('.error').show();
    $('.fileinput-button').hide();
  }
});

