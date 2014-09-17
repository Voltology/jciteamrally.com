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
      $allowedExts = array("gif", "jpeg", "jpg", "png");
      $temp = explode(".", $_FILES["file"]["name"]);
      $extension = end($temp);

      if ((($_FILES["file"]["type"] == "image/gif")
      || ($_FILES["file"]["type"] == "image/jpeg")
      || ($_FILES["file"]["type"] == "image/jpg")
      || ($_FILES["file"]["type"] == "image/pjpeg")
      || ($_FILES["file"]["type"] == "image/x-png")
      || ($_FILES["file"]["type"] == "image/png"))
      && in_array($extension, $allowedExts)) {
        if (!file_exists("uploads/" . $_FILES["file"]["name"])) {
          move_uploaded_file($_FILES["file"]["tmp_name"],
          "uploads/" . $_FILES["file"]["name"]);
        }
        $query = sprintf("INSERT INTO social SET post_id='%s', type='JCI Selfie', `text`='%s', username='%s', full_name='%s', profile_image='%s', post_date='%s', authorized='0', creation='%s'",
          mysql_real_escape_string(md5(time())),
          mysql_real_escape_string("http://www.jciteamrally.com/uploads/" . $_FILES["file"]["name"]),
          mysql_real_escape_string("JCI Selfie"),
          mysql_real_escape_string("JCI Selfie"),
          mysql_real_escape_string(""),
          mysql_real_escape_string(""),
          mysql_real_escape_string(time()));
        mysql_query($query);
        resizeImage("uploads/" . $_FILES["file"]["name"], "uploads/" . $_FILES["file"]["name"]);
        echo "<div id=\"upload-container\"><strong>Thank you!<br />Your photo has been uploaded!</strong></div>";
      } else {
        echo "<div style=\"color: #d00; font-size: 20px;\"><strong>Invalid file.<br />Please try again.</strong></div><br />";
      }
    }
    ?>
    <form method="post" action="./" enctype="multipart/form-data">
    <?php if ($_SERVER["REQUEST_METHOD"] !== "POST") { ?>
      <strong style="font-size: 20px;" id="select-selfie-container">Select a "Selfie" to Upload<br /></strong>
      <strong style="font-size: 20px;" id="click-upload-container" style="display: none;">Click the Button Below<br />To Begin Upload<br /><br /></strong>
      <?php } ?>
      <div id="selected-file-container">
        <strong>Selected File:&nbsp;</strong>
        <span id="selected-file"></span>
        <br />(<a href="./">Choose a Different Image</a>)
      </div>
      <div class="error">Your device is not supported.</div>
      <div class="fileinput-button button">
        <span>Select Photo</span>
        <input type="file" name="file" id="file" />
      </div>
      <button type="submit" class="button" id="upload-button">Start Upload</button>
    </form>
  </body>
</html>
