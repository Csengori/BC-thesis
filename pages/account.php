<?php @session_start();  ?>
<?php require_once('../Connections/Foglalo.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1,2,3";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "PersonalDetails")) {
  $updateSQL = sprintf("UPDATE users SET username=%s, firstname=%s, lastname=%s, email=%s, Street=%s, City=%s, PostCode=%s, PhoneNumber=%s WHERE userID=%s",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['lastname'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['street'], "text"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['postcode'], "text"),
                       GetSQLValueString($_POST['phonenumber'], "text"),
                       GetSQLValueString($_POST['UserIdHiddenField'], "int"));

  mysql_select_db($database_Foglalo, $Foglalo);
  $Result1 = mysql_query($updateSQL, $Foglalo) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "Change PW")) {
  $insertSQL = sprintf("INSERT INTO users (password) VALUES (%s)",
                       GetSQLValueString($_POST['password2'], "text"));

  mysql_select_db($database_Foglalo, $Foglalo);
  $Result1 = mysql_query($insertSQL, $Foglalo) or die(mysql_error());
}

mysql_select_db($database_Foglalo, $Foglalo);
$query_Details = "SELECT * FROM users";
$Details = mysql_query($query_Details, $Foglalo) or die(mysql_error());
$row_Details = mysql_fetch_assoc($Details);
$totalRows_Details = mysql_num_rows($Details);
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
 <h3>&rsaquo; Welcome,<a style="padding-left:5px;"> <?php echo $row_Details['username']; ?></a> </h3>
 <form name="PersonalDetails" id="PersonalDetails" method="POST" action="<?php echo $editFormAction; ?>">
   <table width="500" align="center">
     <tbody>
       <tr>
         <td width="125">&nbsp;</td>
         <td width="317">&nbsp;</td>
         <td width="42">&nbsp;</td>
       </tr>
       <tr>
         <td>Username</td>
         <td><input name="username" type="text" id="username" value="<?php echo $row_Details['username']; ?>" /></td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>First name</td>
         <td><input name="firstname" type="text" id="firstname" value="<?php echo $row_Details['firstname']; ?>" /></td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>Last name</td>
         <td><input name="lastname" type="text" id="lastname" value="<?php echo $row_Details['lastname']; ?>" /></td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>E-mail</td>
         <td><input name="email" type="email" id="email" value="<?php echo $row_Details['email']; ?>" /></td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>Street</td>
         <td><input name="street" type="text" id="street" value="<?php echo $row_Details['Street']; ?>" /></td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>City</td>
         <td><input name="city" type="text" id="city" value="<?php echo $row_Details['City']; ?>" /></td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>Postcode</td>
         <td><input name="postcode" type="text" id="postcode" value="<?php echo $row_Details['PostCode']; ?>" /></td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>Phone number</td>
         <td><input name="phonenumber" type="tel" id="phonenumber" value="<?php echo $row_Details['PhoneNumber']; ?>" /></td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr align="center" valign="middle">
         <td><input type="submit" name="submit" id="submit" value="Submit" />
           <input name="UserIdHiddenField" type="hidden" id="UserIdHiddenField" value="<?php echo $row_Details['userID']; ?>" /></td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
     </tbody>
   </table>
   <input type="hidden" name="MM_update" value="PersonalDetails" />
 </form>
 <form name="Change PW" id="Change PW" method="POST" action="<?php echo $editFormAction; ?>">
   <table width="412" align="center">
     <tbody>
       <tr>
         <td width="200">Current Password :</td>
         <td width="200"><input type="password" name="password" id="password" /></td>
       </tr>
       <tr>
         <td height="21">&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>New Password :</td>
         <td><input type="password" name="password2" id="password2" /></td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td><input type="submit" name="submit2" id="submit2" value="Change password" /></td>
       </tr>
     </tbody>
   </table>
   <input type="hidden" name="MM_insert" value="Change PW" />
 </form>
 <p>&nbsp;</p>
 
 
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
mysql_free_result($Details);
?>
