<?php
require("../.local.inc.php");
$password = "teamrally2014";
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  if ($_POST['password'] === $password) {
    setcookie("password", $password);
    $loggedin = true;
  }
}
$action = $_GET['a'];
if ($action === "approve") {
  $query = sprintf("UPDATE social SET authorized='1' WHERE id='%s'", mysql_real_escape_string($_GET['id']));
  mysql_query($query);
} else if ($action === "remove") {
  $query = sprintf("UPDATE social SET deleted='1' WHERE id='%s'", mysql_real_escape_string($_GET['id']));
  mysql_query($query);
} else if ($action === "unapprove") {
  $query = sprintf("UPDATE social SET authorized='0' WHERE id='%s'", mysql_real_escape_string($_GET['id']));
  mysql_query($query);
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>JCI Team Rally Admin</title>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="/css/admin.css" />
  </head>
  <body>
    <table width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2" valign="middle" class="header">
          <div class="header-logo">
            <a href="http://www.jciteamrally.com"><img src="..//img/logo.gif" height="80" /></a>
          </div>
          <div class="header-admin">Administration Area</div>
        </td>
      </tr>
      <tr>
        <td valign="top" class="sidebar-cell" width="120">
          <div id="sidebar" style="line-height: 1.3em;">
            <?php if ($_COOKIE['password'] === $password || $_POST['password'] === $password) { ?>
             <div class="menuitem"><a href="./"><i class="fa fa-refresh"></i> &nbsp;Refresh</a></div>
             <div class="menuitem"><a href="logout.php"><i class="fa fa-sign-out"></i> &nbsp;Log Out</a></div>
            <?php } ?>
          </div>
        </td>
        <td valign="top" align="left" class="page">
          <?php if ($_COOKIE['password'] !== $password && $_POST['password'] !== $password) { ?>
            <?php if ($_SERVER['REQUEST_METHOD'] === "POST") { ?>
              <div class="error">Password incorrect.</div>
            <?php } ?>
            <h1>Log In</h1>
            <form method="post" action="./">
              <table border="0" cellpadding="0" cellspacing="0" class="edit-table">
                <tr class="tableheader">
                  <th>Enter Password</th>
                </tr>
                <tr>
                  <td class="edit-field"><input type="password" name="password" style="width: 100%;" /></td>
                </tr>
                <tr>
                  <td class="edit-field" colspan="2" align="right">
                    <input type="hidden" name="logintype" value="admin" />
                    <button type="submit" class="button"><i class="icon-arrow-up"></i> Log In</button>
                  </td>
                </tr>
              </table>
            </form>
          <?php } else { ?>
            <table cellpadding="4" cellspacing="0" border="0" width="100%">
              <tr>
                <td width="50%" valign="top">
                  <h2>Unapproved</h2>
                  <?php
                  $query = sprintf("SELECT * FROM social WHERE authorized='0' AND deleted!='1' ORDER BY creation DESC");
                  $result = mysql_query($query);
                  ?>
                  <table width="100%" border="0" cellpadding="4" cellspacing="0" class="edit-table">
                    <tr class="tableheader">
                      <th class="header"></th>
                      <th class="header">Body</th>
                      <th class="header">Platform</th>
                      <th class="header">Date (CST)</th>
                      <th class="header">Delete</th>
                    </tr>
                    <?php
                    while ($row = mysql_fetch_assoc($result)) {
                      echo "<tr>";
                      echo "<td valign=\"top\"><input type=\"checkbox\" onclick=\"document.location='?a=approve&id=" . $row['id'] . "'\" /></td>";
                      echo "<td valign=\"top\"><a href=\"" . $row['text'] . "\" target=\"_blank\"><img src=\"" . $row['text'] . "\" width=\"80\" /></a></td>";
                      echo "<td valign=\"top\">" . ucwords($row['type']) . "</td>";
                      echo "<td valign=\"top\" width=\"120\">" . date("m-d-y, g:i a", $row['creation'] + 7200) . "</td>";
                      echo "<td align=\"right\" valign=\"top\"><a href=\"?a=remove&id=" . $row['id'] . "\" alt=\"Delete\" title=\"Delete\"><img src=\"../img/cross.png\" /></a></td>";
                      echo "</tr>";
                    }
                    if (mysql_num_rows($result) === 0) {
                      echo "<tr><td colspan=\"5\" align=\"center\">There is currently nothing in this queue.</td></tr>";
                    }
                    ?>
                  </table>
                </td>
                <td width="50%" valign="top">
                  <h2>Approved</h2>
                  <?php
                  $query = sprintf("SELECT * FROM social WHERE authorized='1' AND deleted!='1' ORDER BY creation DESC");
                  $result = mysql_query($query);
                  ?>
                  <table width="100%" border="0" cellpadding="4" cellspacing="0" class="edit-table">
                    <tr class="tableheader">
                      <th class="header"></th>
                      <th class="header">Body</th>
                      <th class="header">Platform</th>
                      <th class="header">Date (CST)</th>
                    </tr>
                    <?php
                    while ($row = mysql_fetch_assoc($result)) {
                      echo "<tr>";
                      echo "<td valign=\"top\"><input type=\"checkbox\" onclick=\"document.location='?a=unapprove&id=" . $row['id'] . "'\" checked /></td>";
                      echo "<td valign=\"top\"><a href=\"" . $row['text'] . "\" target=\"_blank\"><img src=\"" . $row['text'] . "\" width=\"80\" /></a></td>";
                      echo "<td valign=\"top\">" . ucwords($row['type']) . "</td>";
                      echo "<td valign=\"top\" width=\"120\">" . date("m-d-y, g:i a", $row['creation'] + 7200) . "</td>";
                      echo "</tr>";
                    }
                    ?>
                  </table>
                </td>
              </tr>
            </table>
          <?php } ?>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <div id="footer">&copy; <?php echo date("Y"); ?> <a href="http://populousdigital.com">Populous Digital</a>, All Rights Reserved.<br />Powered by CCMS.</div>
        </td>
      </tr>
    </table>
    <br />
    <br />
    <br />
  </body>
</html>

