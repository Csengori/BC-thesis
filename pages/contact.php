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
<li><a href="login.php" >Login</a></li>
<li><a href="../pages/register.php">Register</a></li>
<li><a href="account.php">Account </a></li>
<li><a href="../pages/logout.php">Logout</a></li>
<li><a href="../pages/contact.php"class="active">contact</a>

 </li></ul></div>
 <div id="content">
 <h3>&rsaquo; Contact</h3>
 <p>&nbsp;</p>
 <form id="form1" method="post" action="">
   <table width="600" align="center">
     <tbody>
       <tr>
         <td width="130">Name</td>
         <td width="558"><input name="name" type="text" autofocus="autofocus" required="required" id="name" /></td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>E-mail</td>
         <td><input name="email" type="email" required="required" id="email" /></td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>Subject</td>
         <td><input name="subject" type="text" required="required" id="subject" /></td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>Message</td>
         <td><textarea name="message" cols="40" rows="7" required="required" id="message"></textarea></td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td><input type="submit" name="submit" id="submit" value="Send message" /></td>
       </tr>
     </tbody>
   </table>
 </form>
 <p>&nbsp;</p>
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

$from=$_POST['email'];
$email="mymail@test.com";
$subject=$_POST['subject'];
$message=$_POST['message'];


mail($email,$subject,$message ,$from);


?>
