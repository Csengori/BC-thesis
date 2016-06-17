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

$maxRows_Update = 6;
$pageNum_Update = 0;
if (isset($_GET['pageNum_Update'])) {
  $pageNum_Update = $_GET['pageNum_Update'];
}
$startRow_Update = $pageNum_Update * $maxRows_Update;

mysql_select_db($database_Foglalo, $Foglalo);
$query_Update = "SELECT * FROM rooms";
$query_limit_Update = sprintf("%s LIMIT %d, %d", $query_Update, $startRow_Update, $maxRows_Update);
$Update = mysql_query($query_limit_Update, $Foglalo) or die(mysql_error());
$row_Update = mysql_fetch_assoc($Update);

if (isset($_GET['totalRows_Update'])) {
  $totalRows_Update = $_GET['totalRows_Update'];
} else {
  $all_Update = mysql_query($query_Update);
  $totalRows_Update = mysql_num_rows($all_Update);
}
$totalPages_Update = ceil($totalRows_Update/$maxRows_Update)-1;$maxRows_Update = 6;
$pageNum_Update = 0;
if (isset($_GET['pageNum_Update'])) {
  $pageNum_Update = $_GET['pageNum_Update'];
}
$startRow_Update = $pageNum_Update * $maxRows_Update;

mysql_select_db($database_Foglalo, $Foglalo);
$query_Update = "SELECT * FROM rooms";
$query_limit_Update = sprintf("%s LIMIT %d, %d", $query_Update, $startRow_Update, $maxRows_Update);
$Update = mysql_query($query_limit_Update, $Foglalo) or die(mysql_error());
$row_Update = mysql_fetch_assoc($Update);

if (isset($_GET['totalRows_Update'])) {
  $totalRows_Update = $_GET['totalRows_Update'];
} else {
  $all_Update = mysql_query($query_Update);
  $totalRows_Update = mysql_num_rows($all_Update);
}
$totalPages_Update = ceil($totalRows_Update/$maxRows_Update)-1;

$queryString_Update = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Update") == false && 
        stristr($param, "totalRows_Update") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Update = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Update = sprintf("&totalRows_Update=%d%s", $totalRows_Update, $queryString_Update);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en-AU">
<head>

 <meta http-equiv="content-type" content="application/xhtml; charset=UTF-8" />
 <link rel="stylesheet" type="text/css" href="../style/style.css"s" media="screen, tv, projection" />
</head>
<body>
   <div id="container">
 <div id="logo">
 <h1><span class="pink">Hely</span>foglalo</h1>
 </div>
    
		 
<div class="br"></div>

 <div id="navlist">
<ul>
<li><a href="../index.php" >Home</a></li>
<li><a href="../pages/rooms.php" >Rooms</a></li>
<li><a href="../pages/offices.php">Offices</a></li>
<li><a href="../pages/login.php" >Login</a></li>
<li><a href="../pages/register.php">Register</a></li>
<li><a href="../pages/account.php" class="active">Account </a></li>
<li><a href="../pages/logout.php">Logout</a></li>
<li><a href="../pages/contact.php">contact</a>

 </li></ul></div>
 <div id="content">
 <h3>&rsaquo; Admin Panel</h3>
 <table width="500" align="center">
   <tbody>
     <tr>
       <td align="center" valign="top"><a href="adminUsers.php">USERS</a></td>
       <td align="center" valign="top">BOOKINGS</td>
       <td align="center" valign="top"><a href="addRooms.php">Add Rooms</a></td>
       <td align="center" valign="top" class="pink" style="font-size: 16px"><strong><a href="adminRooms.php">Current rooms</a></strong></td>
     </tr>
   </tbody>
 </table>
 <p>&nbsp;</p>
 <p class="left">&nbsp;</p>
 <form name="form1" id="ListRooms" method="POST">
   <table width="700" align="center">
     <tbody>
       <tr>
         <td width="100">Name</td>
         <td width="100">Type</td>
         <td width="100">Street</td>
         <td width="100">City</td>
         <td width="100">Postcode</td>
         <td width="100">Date added</td>
         <td width="100" align="center">Price</td>
         </tr>
       <tr>
         <td colspan="7"><?php if ($totalRows_Update > 0) { // Show if recordset not empty ?>
             <?php do { ?>
               <table width="700" style="border-bottom: 1px solid white;margin-top:10px;">
                 <tbody>
                   <tr>
                     <td width="100"><?php echo $row_Update['RoomName']; ?></td>
                     <td width="100"><?php echo $row_Update['RoomType']; ?></td>
                     <td width="100"><?php echo $row_Update['Street']; ?></td>
                     <td width="100"><?php echo $row_Update['City']; ?></td>
                     <td width="100"><?php echo $row_Update['Postcode']; ?></td>
                     <td width="100"><?php echo $row_Update['dateAdded']; ?></td>
                     <td width="100" align="center"><?php echo $row_Update['price']; ?></td>
                   </tr>
                 </tbody>
               </table>
               <?php } while ($row_Update = mysql_fetch_assoc($Update)); ?>
             <?php } // Show if recordset not empty ?></td>
         </tr>
       <tr>
         <td colspan="7" align="right" valign="bottom"><?php if ($pageNum_Update < $totalPages_Update) { // Show if not last page ?>
             <a href="<?php printf("%s?pageNum_Update=%d%s", $currentPage, min($totalPages_Update, $pageNum_Update + 1), $queryString_Update); ?>">Next</a>
             <?php } // Show if not last page ?>
           <?php if ($pageNum_Update > 0) { // Show if not first page ?>
             <a href="<?php printf("%s?pageNum_Update=%d%s", $currentPage, max(0, $pageNum_Update - 1), $queryString_Update); ?>">Previous</a>
             <?php } // Show if not first page ?>         </td>
         </tr>
     </tbody>
   </table>
 </form>
 </div>
 <div id="footer">
   <p class="center">Helyseg es irodaberles © 2015  | <a href="#">XHTML</a> | <a href="#">CSS</a> |<a href="../pages/AdminPanel.php"> Admin</a></p> 
<br />
</div>
</div>
</body>
</html>
<?php
mysql_free_result($Update);
?>
