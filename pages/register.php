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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="register.php";
  $loginUsername = $_POST['username'];
  $LoginRS__query = sprintf("SELECT username FROM users WHERE username=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_Foglalo, $Foglalo);
  $LoginRS=mysql_query($LoginRS__query, $Foglalo) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "RegisterForm")) {
  $insertSQL = sprintf("INSERT INTO users (username, firstname, lastname, email, password) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['lastname'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['password'], "text"));

  mysql_select_db($database_Foglalo, $Foglalo);
  $Result1 = mysql_query($insertSQL, $Foglalo) or die(mysql_error());

  $insertGoTo = "registerPos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_Foglalo, $Foglalo);
$query_RegisterUser = "SELECT * FROM users";
$RegisterUser = mysql_query($query_RegisterUser, $Foglalo) or die(mysql_error());
$row_RegisterUser = mysql_fetch_assoc($RegisterUser);
$totalRows_RegisterUser = mysql_num_rows($RegisterUser);
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
<li><a href="../pages/rooms.php">Rooms</a></li>
<li><a href="../pages/offices.php">Offices</a></li>
<li><a href="../pages/login.php" >Login</a></li>
<li><a href="../pages/register.php"class="active">Register</a></li>
<li><a href="../pages/account.php">Account </a></li>
<li><a href="../pages/logout.php">Logout</a></li>
<li><a href="../pages/contact.php">contact</a>

 </li></ul></div>
 <div id="content">
 <h3>&rsaquo; Register </h3>
 <form name="RegisterForm" id="RegisterForm" method="POST" action="<?php echo $editFormAction; ?>">
   <table width="500" align="center">
     <tbody>
       <tr>
         <td width="115" align="center" valign="middle" class="small">&nbsp;</td>
         <td width="130">&nbsp;</td>
         <td width="239">&nbsp;</td>
       </tr>
       <tr>
         <td align="center" valign="middle">*Username</td>
         <td><input name="username" type="text" autofocus="autofocus" required="required" id="username" /></td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td align="center" valign="middle">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td align="center" valign="middle">First name</td>
         <td><input type="text" name="firstname" id="firstname" /></td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td align="center" valign="middle">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td align="center" valign="middle">Last name</td>
         <td><input type="text" name="lastname" id="lastname" /></td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td align="center" valign="middle">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td align="center" valign="middle">*E-mail</td>
         <td><input name="email" type="email" required="required" id="email" autocomplete="off" /></td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td align="center" valign="middle">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td align="center" valign="middle">*Password</td>
         <td><input type="password" name="password" id="password" /></td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td align="center" valign="middle">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td align="center" valign="middle" class="small">*<span style="text-align: right">required</span></td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td align="center" valign="middle"><input name="submit" type="submit" id="submit" value="register" /></td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td align="center" valign="middle">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td align="center" valign="middle">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
     </tbody>
   </table>
   <input type="hidden" name="MM_insert" value="RegisterForm" />
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
mysql_free_result($RegisterUser);
?>
