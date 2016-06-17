<?php require_once('../Connections/Foglalo.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_users = 1;
$pageNum_users = 0;
if (isset($_GET['pageNum_users'])) {
  $pageNum_users = $_GET['pageNum_users'];
}
$startRow_users = $pageNum_users * $maxRows_users;

mysql_select_db($database_Foglalo, $Foglalo);
$query_users = "SELECT * FROM users";
$query_limit_users = sprintf("%s LIMIT %d, %d", $query_users, $startRow_users, $maxRows_users);
$users = mysql_query($query_limit_users, $Foglalo) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);

if (isset($_GET['totalRows_users'])) {
  $totalRows_users = $_GET['totalRows_users'];
} else {
  $all_users = mysql_query($query_users);
  $totalRows_users = mysql_num_rows($all_users);
}
$totalPages_users = ceil($totalRows_users/$maxRows_users)-1;

$maxRows_Rooms = 1;
$pageNum_Rooms = 0;
if (isset($_GET['pageNum_Rooms'])) {
  $pageNum_Rooms = $_GET['pageNum_Rooms'];
}
$startRow_Rooms = $pageNum_Rooms * $maxRows_Rooms;

mysql_select_db($database_Foglalo, $Foglalo);
$query_Rooms = "SELECT * FROM rooms";
$query_limit_Rooms = sprintf("%s LIMIT %d, %d", $query_Rooms, $startRow_Rooms, $maxRows_Rooms);
$Rooms = mysql_query($query_limit_Rooms, $Foglalo) or die(mysql_error());
$row_Rooms = mysql_fetch_assoc($Rooms);

if (isset($_GET['totalRows_Rooms'])) {
  $totalRows_Rooms = $_GET['totalRows_Rooms'];
} else {
  $all_Rooms = mysql_query($query_Rooms);
  $totalRows_Rooms = mysql_num_rows($all_Rooms);
}
$totalPages_Rooms = ceil($totalRows_Rooms/$maxRows_Rooms)-1;

$queryString_users = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_users") == false && 
        stristr($param, "totalRows_users") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_users = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_users = sprintf("&totalRows_users=%d%s", $totalRows_users, $queryString_users);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en-AU">
<head>

 <meta http-equiv="content-type" content="application/xhtml; charset=UTF-8" />
 <link rel="stylesheet" type="text/css" href="../style/style.css"s" media="screen, tv, projection" />
 <link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css" />
 <link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css" />
<script src="../jQueryAssets/jquery-1.11.1.min.js" type="text/javascript"></script>
</head>
<body>
   <div id="container">
 <div id="logo">
 <h1><span class="pink">Hely</span>foglalo</h1>
 
		 
<div class="br"></div>

 <div id="navlist">
<ul>
<li><a href="../index.php" >Home</a></li>
<li><a href="rooms.php" class="active">Rooms</a></li>
<li><a href="offices.php">Offices</a></li>
<li><a href="login.php" >Login</a></li>
<li><a href="register.php">Register</a></li>
<li><a href="account.php">Account </a></li>
<li><a href="logout.php">Logout</a></li>
<li><a href="contact.php">contact</a>

 </li></ul></div>
 <div id="content">
   <h3>&rsaquo; Rooms (long term booking)</h3><br>
 <form id="RoomBook" method="post" action="">
   <?php do { ?>
     <table width="600" align="center">
       <tbody>
         <tr>
           <td><table width="600" >
             <tbody>
               <tr>
                 <td width="172" rowspan="5" class="table" >//image here</td>
                 <td width="182" rowspan="5"><table width="130" align="left">
                   <tbody>
                     <tr>
                       <td width="100" align="left" valign="top"><?php echo $row_Rooms['RoomName']; ?></td>
                       </tr>
                     <tr>
                       <td align="left" valign="top"><?php echo $row_Rooms['City']; ?></td>
                       </tr>
                     <tr>
                       <td align="left" valign="top"><?php echo $row_Rooms['Street']; ?></td>
                       </tr>
                     <tr>
                       <td align="left" valign="top"><?php echo $row_Rooms['Postcode']; ?></td>
                       </tr>
                     <tr>
                       <td align="left" valign="top" height="100"><?php echo $row_Rooms['Description']; ?></td>
                       </tr>
                     </tbody>
                   </table></td>
                 <td height="47" colspan="2"><?php echo $row_Rooms['price']."€ / day"; ?></td>
                 </tr>
               <tr>
                 <td width="177" height="23">From</td>
                 <td width="49"><input name="DateFrom" type="date" required="required" id="DateFrom" /></td>
                 </tr>
               <tr>
                 <td height="23">To</td>
                 <td height="23"><input name="dateTo" type="date" required="required" id="dateTo" /></td>
                 </tr>
               <tr>
                 <td colspan="2"><input type="submit" name="book" id="book" value="Book " /></td>
                 </tr>
               <tr>
                 <td colspan="2"><input name="HiddenFname" type="hidden" id="HiddenFname" value="<?php echo $row_users['firstname']; ?>" />
                   <input name="HiddenLastname" type="hidden" id="HiddenLastname" value="<?php echo $row_users['lastname']; ?>" />
                   <input name="HiddenRoomId" type="hidden" id="HiddenRoomId" value="<?php echo $row_Rooms['id']; ?>" /></td>
                 </tr>
               </tbody>
             </table></td>
         </tr>
         <tr>
           <td align="right"><?php if ($pageNum_users < $totalPages_users) { // Show if not last page ?>
               <a href="<?php printf("%s?pageNum_users=%d%s", $currentPage, min($totalPages_users, $pageNum_users + 1), $queryString_users); ?>">Next</a>
               <?php } // Show if not last page ?>
             <?php if ($pageNum_users > 0) { // Show if not first page ?>
               <a href="<?php printf("%s?pageNum_users=%d%s", $currentPage, max(0, $pageNum_users - 1), $queryString_users); ?>">Previous</a>
               <?php } // Show if not first page ?>         </td>
         </tr>
       </tbody>
     </table>
     <?php } while ($row_Rooms = mysql_fetch_assoc($Rooms)); ?>
 </form>
 <h3>&nbsp; </h3>
 </div>
<div class="br"></div>
<div id="footer">
<p class="center">Helyseg es irodaberles © 2015  | <a href="#">XHTML</a> | <a href="#">CSS</a> |<a href="AdminPanel.php"> Admin</a></p> 
<br />
</div>
</div>

</body>
</html>
<?php
mysql_free_result($users);

mysql_free_result($Rooms);
?>
