<?php

// MySQL Verbindungsdaten
define( 'MYSQL_HOST', 'localhost');
define( 'MYSQL_USER', '2fast4you');
define( 'MYSQL_PASS', '2fast4you');
define( 'MYSQL_DABA', '2fast4you');

/*

// Locale Verbindungsdaten
define( 'MYSQL_HOST', 'localhost');
define( 'MYSQL_USER', 'admin');
define( 'MYSQL_PASS', 'admin');
define( 'MYSQL_DABA', '2f4y');

// Locale Verbindungsdaten
define( 'MYSQL_HOST', 'localhost');
define( 'MYSQL_USER', 'root');
define( 'MYSQL_PASS', '');
define( 'MYSQL_DABA', 'd006bfeb');

*/
// MySQL Datenbankverbindung aufbauen ..
$tmp_connection = @mysql_connect( MYSQL_HOST, MYSQL_USER, MYSQL_PASS );
if(!$tmp_connection) {echo 'MySQL connection error ..<BR />';}
if(!@mysql_select_db( MYSQL_DABA )) {echo 'MySQL database error ..<BR />';}
?>