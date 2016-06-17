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

mysql_select_db($database_Foglalo, $Foglalo);
$query_Recordset1 = "SELECT * FROM users";
$Recordset1 = mysql_query($query_Recordset1, $Foglalo) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
<li><a href="../pages/login.php" class="active">Login</a></li>
<li><a href="../pages/register.php">Register</a></li>
<li><a href="../pages/account.php">Account </a></li>
<li><a href="../pages/logout.php">Logout</a></li>
<li><a href="../pages/contact.php">contact</a>

 </li></ul></div>
 <div id="content">
 <h3>&rsaquo; Log in</h3>
 <form method="POST" id="ForgotPw" novalidate="novalidate" autocomplete="on">
   <table width="500" align="center">
     <tbody>
       <tr>
         <td width="100">&nbsp;</td>
         <td width="388">&nbsp;</td>
         <td width="388">&nbsp;</td>
       </tr>
       <tr>
         <td>Email</td>
         <td><input name="username" type="text" autofocus="autofocus" required="required" id="username" autocomplete="on" /></td>
         <td><input type="submit" name="submit" id="submit" value="Submit" /></td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
     </tbody>
   </table>
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
<?php @session_start();
$_SESSION['Recover'] =$_POST['email'];
 ?>

<?php require_once('Connections/helyfoglalo.php'); ?>
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

$colname_ForgotPw = "-1";
if (isset($_GET['Recover'])) {
  $colname_ForgotPw = $_GET['Recover'];
}
mysql_select_db($database_helyfoglalo, $helyfoglalo);
$query_ForgotPw = sprintf("SELECT email, password FROM users WHERE email = %s", GetSQLValueString($colname_ForgotPw, "text"));
$ForgotPw = mysql_query($query_ForgotPw, $helyfoglalo) or die(mysql_error());
$row_ForgotPw = mysql_fetch_assoc($ForgotPw);
$totalRows_ForgotPw = mysql_num_rows($ForgotPw);

mysql_free_result($ForgotPw);
?>

<?php

$from="noreply@mydomain.com";
$email=$_POST['email'];
$subject="Forgotten password";
$message="Your password ".$row_ForgotPw['password'];

if ($totalRows_ForgotPw >0 ) {
mail($$email,$subject,$message ,"from".$from);
}

 if($totalRows_ForgotPw > 0 )
 {
	 echo("user found");
 }else
	 {
		 echo("user not found" );
	 }
	 

?>


<?php
mysql_free_result($Recordset1);
?>
