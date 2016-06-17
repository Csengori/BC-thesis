<?php require_once('../Connections/Foglalo.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "3";
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
<?php require_once('../Connections/Foglalo.php'); ?>
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

$maxRows_UserList = 10;
$pageNum_UserList = 0;
if (isset($_GET['pageNum_UserList'])) {
  $pageNum_UserList = $_GET['pageNum_UserList'];
}
$startRow_UserList = $pageNum_UserList * $maxRows_UserList;

mysql_select_db($database_Foglalo, $Foglalo);
$query_UserList = "SELECT * FROM users ORDER BY `timestamp` DESC";
$query_limit_UserList = sprintf("%s LIMIT %d, %d", $query_UserList, $startRow_UserList, $maxRows_UserList);
$UserList = mysql_query($query_limit_UserList, $Foglalo) or die(mysql_error());
$row_UserList = mysql_fetch_assoc($UserList);

if (isset($_GET['totalRows_UserList'])) {
  $totalRows_UserList = $_GET['totalRows_UserList'];
} else {
  $all_UserList = mysql_query($query_UserList);
  $totalRows_UserList = mysql_num_rows($all_UserList);
}
$totalPages_UserList = ceil($totalRows_UserList/$maxRows_UserList)-1;

$queryString_UserList = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_UserList") == false && 
        stristr($param, "totalRows_UserList") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_UserList = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_UserList = sprintf("&totalRows_UserList=%d%s", $totalRows_UserList, $queryString_UserList);
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
 <form name="form1" id="Update" method="POST">
   <table width="600" align="center" cellspacing="10">
     <tbody>
       <tr align="center" valign="middle">
         <td width="100">Username</td>
         <td width="100">First name</td>
         <td width="100">Last name</td>
         <td width="100">Current Rank</td>
         <td width="100">Change rank</td>
         <td width="100">&nbsp;</td>
         </tr>
       <tr align="center" valign="middle">
         <td colspan="6"><?php do { ?>
             <?php if ($totalRows_UserList > 0) { // Show if recordset not empty ?>
               <table width="700" align="center" style="border-bottom: 1px solid white;margin-top:10px;">
                 <tbody>
                   <tr align="center" valign="top">
                     <td><?php echo $row_UserList['username']; ?></td>
                     <td width="100"><?php echo $row_UserList['firstname']; ?></td>
                     <td width="100"><?php echo $row_UserList['lastname']; ?></td>
                     <td width="100"><?php echo $row_UserList['lvl']; ?></td>
                     <td width="100"><select name="select" id="select">
                       <option value="1">user</option>
                       <option value="2">staff</option>
                       <option value="3">admin</option>
                       </select>
                       <input name="UserIdHiddenField" type="hidden" id="UserIdHiddenField" value="<?php echo $row_UserList['userID']; ?>" /></td>
                     <td width="100"><input type="submit" name="submit" id="submit" value="Change rank" /></td>
                     </tr>
                   </tbody>
               </table>
               <?php } // Show if recordset not empty ?>
             <?php } while ($row_UserList = mysql_fetch_assoc($UserList)); ?></td>
       </tr>
       <tr align="center" valign="middle">
         <td colspan="6" align="right"><?php if ($pageNum_UserList > 0) { // Show if not first page ?>
             <a href="<?php printf("%s?pageNum_UserList=%d%s", $currentPage, max(0, $pageNum_UserList - 1), $queryString_UserList); ?>">Previous</a>
             <?php } // Show if not first page ?>
           <?php if ($pageNum_UserList < $totalPages_UserList) { // Show if not last page ?>
             <a href="<?php printf("%s?pageNum_UserList=%d%s", $currentPage, min($totalPages_UserList, $pageNum_UserList + 1), $queryString_UserList); ?>">Next</a>
             <?php } // Show if not last page ?>         </td>
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
mysql_free_result($UserList);

?>
