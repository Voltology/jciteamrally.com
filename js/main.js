$(document).ready(function() {
  $('#file').change(function() {
    alert($(this).val());
    /*
    var filepath = $(this).val().split(/\\/);
    $('#selected-file').html(filepath[filepath.length - 1]);
    $('#upload-button').show();
    $('.fileinput-button').hide();
    */
  });
});
