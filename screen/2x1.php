<!DOCTYPE html>
<html>
  <head>
    <title>Populous Digital Social Hub</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="css/styles-wave-2.css" />
    <link rel="stylesheet" href="css/font-awesome.css" />
    <script src="js/jquery.js"></script>
    <script>
      var ajax = {
        get : function(url, query, callback) {
          jQuery.ajax({
            type: 'POST',
            url: url,
            data: query,
            dataType: 'json',
            success: function(response) {
              callback(response);
            }
          });
        }
      };
      var rotation = ['flipped-vertical-bottom', 'flipped-vertical-top', 'flipped-horizontal-left', 'flipped-horizontal-right'];
      $(window).ready(function() {
        var $grid = $('#grid');
        //LED 3x3
        //for (var i = 1; i <= 9; i++) {
        //WAVE 3x2
        //for (var i = 1; i <= 6; i++) {
        //WAVE 2x1
        for (var i = 1; i <= 2; i++) {
          var rand = Math.floor(Math.random() * 2) + 1;
          $grid.append('<li id="panel' + i + '"></li>');
        }
        getData();
        randFlip();
      });
      var data;
      function getData() {
        ajax.get('api/v1.0/', '&method=getPhotos', function(response) {
          data = response.social;
        });
        setTimeout(function() {
          getData();
        }, 60000);
      }

      function flipPanel(id) {
        var $panel = $('#' + id);
        var random = Math.floor(Math.random() * (3 - 0 + 1));
        var animation = rotation[random];
        $panel.addClass('animated ' + animation);
        setTimeout(function() {
          var bgcolors = ['ffffff', 'ddaa00', '77aadd'];
          var rand = bgcolors[Math.floor(Math.random() * bgcolors.length)];
          $panel.css({
            'background-color' : '#' + rand,
            'background-image' : 'none',
            'visibility' : 'visible'
          });
          if (rand === 'ffffff') {
            $panel.css('color', '#000');
            $panel.css('text-shadow', 'none');
          } else {
            $panel.css('color', '#fff');
            $panel.css('text-shadow', '2px 2px 2px rgba(50, 50, 50, 1)');
          }
          var social = data[Math.floor(Math.random() * data.length)];
          if (social.type === 'instagram' || social.type === 'photobooth') {
            $panel.css('background-image', 'url(' + social.text + ')');
            //Uncomment for LED and WAVE
            //$panel.css('background-size', '100%');
            $panel.css('color', '#fff');
            $panel.css('text-shadow', '2px 2px 2px rgba(0, 0, 0, 1)');
            $panel.html('<span class="author">@' + social.username + '</span><span class="social-icon"><i class="fa fa-' + social.type + '"></i></span>');
          } else if (social.type === 'twitter') {
            $panel.html(social.text + '<span class="author">@' + social.username + '</span><span class="social-icon"><i class="fa fa-' + social.type + '"></i></span>');
          }
        }, 590);
        setTimeout(function() {
          $panel.removeClass('animated ' + animation);
        }, 1000);
      }
      function randFlip() {
        setTimeout(function() {
          //LED 3x3
          //var rand = Math.floor(Math.random() * 9) + 1;
          //WAVE 3x2
          //var rand = Math.floor(Math.random() * 6) + 1;
          //WAVE 2x1
          var rand = Math.floor(Math.random() * 2) + 1;
          flipPanel('panel' + rand);
          randFlip();
        }, 12000);
      }
    </script>
  </head>
  <body>
    <ul id="grid">
    </ul>
    <!--
    <h1><img src="img/logo.png" /></h1>
    <span class="right">Powered By:</span>
    <p>
      <strong>70% of Instragram accounts are private.  To participate in the BMA social wall, authorize your Instagram at http://bit.ly/bmaconf14</strong>
    </p>-->
  </body>
</html>
