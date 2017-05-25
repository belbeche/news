<?php 
session_start();
require_once ('classes.php'); 
$mini = false;
$nonav = false;
error_reporting(0);
/*
*	# admin/config.php
*/
?>
<?php 
	/*
	* Je défini ma connexion à la base de donnés via les paramètre 
	*/

	// Parametre Connexion

	define('DB_SERVER', 'db683412430.db.1and1.com');
	define('DB_USER' , 'dbo683412430');
	define('DB_PASSWORD', 'dubosson123');
	define('DB_NAME', 'db683412430');

	define('FROM_EMAIL', 'belbeche.W@gmail.com');
	define('FROM_NAME', 'Votre email !');
