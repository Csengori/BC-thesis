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

mysql_select_db($database_Foglalo, $Foglalo);
$query_Recordset1 = "SELECT * FROM rooms";
$Recordset1 = mysql_query($query_Recordset1, $Foglalo) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_Foglalo, $Foglalo);
$query_Users = "SELECT * FROM users";
$Users = mysql_query($query_Users, $Foglalo) or die(mysql_error());
$row_Users = mysql_fetch_assoc($Users);
$totalRows_Users = mysql_num_rows($Users);

$maxRows_repeat = 1;
$pageNum_repeat = 0;
if (isset($_GET['pageNum_repeat'])) {
  $pageNum_repeat = $_GET['pageNum_repeat'];
}
$startRow_repeat = $pageNum_repeat * $maxRows_repeat;

mysql_select_db($database_Foglalo, $Foglalo);
$query_repeat = "SELECT * FROM rooms";
$query_limit_repeat = sprintf("%s LIMIT %d, %d", $query_repeat, $startRow_repeat, $maxRows_repeat);
$repeat = mysql_query($query_limit_repeat, $Foglalo) or die(mysql_error());
$row_repeat = mysql_fetch_assoc($repeat);

if (isset($_GET['totalRows_repeat'])) {
  $totalRows_repeat = $_GET['totalRows_repeat'];
} else {
  $all_repeat = mysql_query($query_repeat);
  $totalRows_repeat = mysql_num_rows($all_repeat);
}
$totalPages_repeat = ceil($totalRows_repeat/$maxRows_repeat)-1;

$queryString_repeat = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_repeat") == false && 
        stristr($param, "totalRows_repeat") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_repeat = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_repeat = sprintf("&totalRows_repeat=%d%s", $totalRows_repeat, $queryString_repeat);
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
 </div>
 
<div class="br"></div>

 <div id="navlist">
<ul>
<li><a href="../index.php" >Home</a></li>
<li><a href="rooms.php" >Rooms</a></li>
<li><a href="offices.php"class="active">Offices</a></li>
<li><a href="login.php" >Login</a></li>
<li><a href="register.php">Register</a></li>
<li><a href="account.php">Account </a></li>
<li><a href="logout.php">Logout</a></li>
<li><a href="contact.php">contact</a>

 </li></ul></div>
 <div id="content">
 <h3>&rsaquo; Offices </h3>
 <br>
 <form name="form1" id="form1" method="POST">
   <?php do { ?>
     <table width="600" align="center">
       <tbody>
         <tr>
           <td colspan="2"><table width="600" >
             <tbody>
               <tr>
                 <td rowspan="5" class="table" >//image here</td>
                 <td rowspan="5"><table width="130">
                   <tbody>
                     <tr>
                       <td align="left" valign="top"><?php echo $row_Recordset1['RoomName']; ?></td>
                       </tr>
                     <tr>
                       <td align="left" valign="top"><?php echo $row_Recordset1['City']; ?></td>
                       </tr>
                     <tr>
                       <td align="left" valign="top"><?php echo $row_Recordset1['Street']; ?></td>
                       </tr>
                     <tr>
                       <td align="left" valign="top"><?php echo $row_Recordset1['Postcode']; ?></td>
                       </tr>
                     <tr>
                       <td align="left" valign="top" height="100"><?php echo $row_Recordset1['Description']; ?></td>
                       </tr>
                     </tbody>
                   </table></td>
                 <td height="47" colspan="2"><?php echo $row_Recordset1['price']; ?></td>
                 </tr>
               <tr>
                 <td height="23">From</td>
                 <td><input name="dateFrm" type="date" required="required" id="dateFrm" /></td>
                 </tr>
               <tr>
                 <td height="23">To</td>
                 <td height="23"><input name="DateTo" type="date" required="required" id="DateTo" /></td>
                 </tr>
               <tr>
                 <td>special request:</td>
                 <td><textarea name="txtAreaXtra" id="txtAreaXtra" cols="30" rows="1"></textarea></td>
                 </tr>
               <tr>
                 <td colspan="2"><input type="submit" name="book" id="book" value="Book " />
                   <select name="Interval" required="required" id="Interval">
                     <option value="1">8:00-9:00</option>
                     <option value="2">9:00-10:00</option>
                     <option value="3">10:00-11:00</option>
                     <option value="4">11:00-12:00</option>
                     <option value="5">12:00-13:00</option>
                     <option value="6">13:00-14:00</option>
                     <option value="7">14:00-15:00</option>
                     <option value="8">15:00-16:00</option>
                     <option value="9">16:00-17:00</option>
                     <option value="10">17:00-18:00</option>
                   </select>
                   <input name="HiddenFname" type="hidden" id="HiddenFname" value="<?php echo $row_Users['firstname']; ?>" />
                   <input name="HiddenLastname" type="hidden" id="HiddenLastname" value="<?php echo $row_Users['lastname']; ?>" />
                   <input name="HiddenRoomId" type="hidden" id="HiddenRoomId" value="<?php echo $row_Rooms['id']; ?>" /></td>
                 </tr>
               </tbody>
           </table></td>
           </tr>
         <tr>
           <td width="186">&nbsp;</td>
           <td width="410">&nbsp;</td>
         </tr>
         <tr align="right" valign="middle">
           <td colspan="2"><?php if ($pageNum_repeat < $totalPages_repeat) { // Show if not last page ?>
  <a href="<?php printf("%s?pageNum_repeat=%d%s", $currentPage, min($totalPages_repeat, $pageNum_repeat + 1), $queryString_repeat); ?>">Next</a>
  <?php } // Show if not last page ?>
             <?php if ($pageNum_repeat > 0) { // Show if not first page ?>
               <a href="<?php printf("%s?pageNum_repeat=%d%s", $currentPage, max(0, $pageNum_repeat - 1), $queryString_repeat); ?>">Previous</a>
               <?php } // Show if not first page ?></td>
         </tr>
       </tbody>
     </table>
     <?php } while ($row_repeat = mysql_fetch_assoc($repeat)); ?>
 </form>
 <p>&nbsp;</p>
 
 
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
mysql_free_result($Recordset1);

mysql_free_result($Users);

mysql_free_result($repeat);
?>
