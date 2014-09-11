<?php
require(".local.inc.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <title>JCI Team Rally</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="./css/style.css" />
    <script src="./js/jquery-2.1.1.min.js"></script>
    <script src="./js/main.js"></script>
  </head>
  <body>
    <img src="./img/logo.gif" class="logo" />
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
    ?>
      <div>Your photo has been uploaded!</div>
    <?php
    }
    ?>
    <form method="post" action="./" enctype="multipart/form-data">
      <div>
        <strong>Selected File:&nbsp;</strong>
        <span id="selected-file"></span>
      </div>
      <div class="fileinput-button">
        <span>Select Photo</span>
        <input type="file" name="files[]" id="file" />
      </div>
      <button type="submit" id="upload-button">Start Upload</button>
    </form>
  </body>
</html>
