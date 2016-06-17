<?php require_once('../Connections/Foglalo.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "2,3";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

mysql_select_db($database_Foglalo, $Foglalo);
$query_addRoom = "SELECT * FROM rooms";
$addRoom = mysql_query($query_addRoom, $Foglalo) or die(mysql_error());
$row_addRoom = mysql_fetch_assoc($addRoom);
$totalRows_addRoom = mysql_num_rows($addRoom);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "addRooms")) {
  $insertSQL = sprintf("INSERT INTO rooms (RoomName, City, Street, Postcode, RoomType, `Description`, img, price) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['roomname'], "text"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['street'], "text"),
                       GetSQLValueString($_POST['postcode'], "text"),
                       GetSQLValueString($_POST['roomtype'], "text"),
                       GetSQLValueString($_POST['textarea'], "text"),
                       GetSQLValueString($_POST['img'], "text"),
                       GetSQLValueString($_POST['number'], "int"));

  mysql_select_db($database_Foglalo, $Foglalo);
  $Result1 = mysql_query($insertSQL, $Foglalo) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "addRooms")) {
	
	
	
  $insertSQL = sprintf("INSERT INTO rooms (RoomName, City, Street, Postcode, RoomType, `Description`, img) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['roomname'], "text"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['street'], "text"),
                       GetSQLValueString($_POST['postcode'], "text"),
                       GetSQLValueString($_POST['roomtype'], "text"),
                       GetSQLValueString($_POST['textarea'], "text"),
                       GetSQLValueString($_POST['img'], "text"));

  mysql_select_db($database_Foglalo, $Foglalo);
  $Result1 = mysql_query($insertSQL, $Foglalo) or die(mysql_error());
}
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
 <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="addRooms" id="addRooms">
   <table width="600" align="center" class="TableRightBorder">
     <tbody>
       <tr>
         <td width="120">Room name</td>
         <td width="217"><input name="roomname" type="text" required="required" id="roomname" /></td>
         <td colspan="2">&nbsp;</td>
       </tr>
       <tr>
         <td height="20">&nbsp;</td>
         <td>&nbsp;</td>
         <td colspan="2">&nbsp;</td>
         </tr>
       <tr>
         <td height="20">City</td>
         <td><input name="city" type="text" required="required" id="city" /></td>
         <td colspan="2">&nbsp;</td>
         </tr>
       <tr>
         <td height="20">&nbsp;</td>
         <td>&nbsp;</td>
         <td colspan="2">&nbsp;</td>
         </tr>
       <tr>
         <td height="20">Street</td>
         <td><input name="street" type="text" required="required" id="street" /></td>
         <td colspan="2">&nbsp;</td>
         </tr>
       <tr>
         <td height="20">&nbsp;</td>
         <td>&nbsp;</td>
         <td colspan="2">&nbsp;</td>
         </tr>
       <tr>
         <td height="20">Postcode</td>
         <td><input name="postcode" type="text" required="required" id="postcode" /></td>
         <td colspan="2">&nbsp;</td>
         </tr>
       <tr>
         <td height="20">&nbsp;</td>
         <td>&nbsp;</td>
         <td colspan="2">&nbsp;</td>
         </tr>
       <tr>
         <td height="20">Room type</td>
         <td><select name="roomtype" required="required" id="roomtype">
           <option value="room">Room</option>
           <option value="office">Office</option>
         </select></td>
         <td width="85">Price</td>
         <td width="158"><input name="number" type="number" required="required" id="number" min="0" /></td>
         </tr>
       <tr>
         <td height="20">&nbsp;</td>
         <td>&nbsp;</td>
         <td colspan="2">&nbsp;</td>
         </tr>
       <tr>
         <td height="20">Room image</td>
         <td><input type="file" name="img" id="img" /></td>
         <td colspan="2">&nbsp;</td>
         </tr>
       <tr>
         <td height="20">&nbsp;</td>
         <td>&nbsp;</td>
         <td colspan="2">&nbsp;</td>
         </tr>
       <tr>
         <td height="20">Description</td>
         <td><textarea name="textarea" id="textarea" cols="30" rows="5"></textarea></td>
         <td colspan="2">&nbsp;</td>
         </tr>
       <tr>
         <td height="20">&nbsp;</td>
         <td>&nbsp;</td>
         <td colspan="2">&nbsp;</td>
       </tr>
       <tr>
         <td height="20">&nbsp;</td>
         <td><input name="submit" type="submit" class="right" id="submit" value="Add room" /></td>
         <td colspan="2">&nbsp;</td>
       </tr>
       </tbody>
   </table>
   <input type="hidden" name="MM_insert" value="addRooms" />
 </form>
 </div>
<div class="br"></div>
<div id="footer">
<p class="center">Helyseg es irodaberles © 2015  | <a href="#">XHTML</a> | <a href="#">CSS</a> |<a href="../pages/AdminPanel.php"> Admin</a></p> 
<br />
</div>
</div>
</body>
</html>
<?php
mysql_free_result($addRoom);
?>
