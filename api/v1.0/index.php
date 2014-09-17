<?php
header("Content-type: application/json");
require("../../.local.inc.php");
$json['social'] = array();
$json['errors'] = array();
$json['result'] = "success";
//if ($_SERVER['REQUEST_METHOD'] === "POST") {
if ($_POST['method'] === "getData") {
  $query = sprintf("SELECT * FROM social WHERE authorized='1' AND creation > " . (time() - 43200) . " ORDER BY creation DESC");
  $result = mysql_query($query);
  while ($row = mysql_fetch_assoc($result)) {
    array_push($json['social'], $row);
  }
} else if ($_POST['method'] === "getInstagram") {
  $query = sprintf("SELECT * FROM social WHERE authorized='1' AND type='instagram' AND creation > " . (time() - 43200) . " ORDER BY creation DESC");
  $result = mysql_query($query);
  while ($row = mysql_fetch_assoc($result)) {
    array_push($json['social'], $row);
  }
} else if ($_POST['method'] === "getPhotobooth") {
  $query = sprintf("SELECT * FROM social WHERE authorized='1' AND type='photobooth' AND creation > " . (time() - 43200) . " ORDER BY creation DESC");
  $result = mysql_query($query);
  while ($row = mysql_fetch_assoc($result)) {
    array_push($json['social'], $row);
  }
} else if ($_POST['method'] === "getPhotos") {
  $query = sprintf("SELECT * FROM social WHERE authorized='1' ORDER BY creation DESC");
  $result = mysql_query($query);
  while ($row = mysql_fetch_assoc($result)) {
    array_push($json['social'], $row);
  }
}
echo json_encode($json);
?>
