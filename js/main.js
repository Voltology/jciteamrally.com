$(document).ready(function() {
  $('#file').bind('change', function() {
    var filepath = $(this).val().split(/\\/);
    $('#selected-file').html(filepath[filepath.length - 1]);
    $('#upload-button').show();
  });
});
