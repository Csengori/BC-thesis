<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_Foglalo = "localhost";
$database_Foglalo = "helyfoglalo";
$username_Foglalo = "root";
$password_Foglalo = "";
$Foglalo = mysql_pconnect($hostname_Foglalo, $username_Foglalo, $password_Foglalo) or trigger_error(mysql_error(),E_USER_ERROR); 
?>