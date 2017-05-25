<?php

$dsn = 'mysql:host=db683412430.db.1and1.com;dbname=db683412430';
$utilisateur = 'dbo683412430';
$mdp = 'dubosson123';

# admin/classes.php 

/**
* Authentification 
* inscription_user = de l'utilisateur stoquer dans les variables user et pw 
* connecte = Si la $_SESSION existe et valide alors on renvoi true sinon erreur
* connexion_oblige = Si y'a authentification sinon login.php 
envoi des données à notre fonction check_user (qui vérifie $user, $pw)
*/

function inscription_user($user, $pw) {
	if (check_username_and_pw($user, $pw)) {
		header('Location: index.php');
	} else {
		$_SESSION['error'] = "Identifiant incorrect.";
		header('Location: login.php');
	}
}

function connecte() {
	if ($_SESSION['authorized'] == true) {
		return true;
	} else {
		return false;
	}
}

/*
* Connexion oblige 
* Vérification si on est connétés sinon envoi de la page connexion
*/

function connexion_oblige() {
	if (connecte()) {
		return true;
	} else {
		header('Location: login.php');
	}
}

/* 
*Connexion
*	préparation de la requet préparé
*	Pour chaque valeur récuperer par ligne sous email qui vaut $val, je les 
*	récupere dans la variable total qui contient un tableau avec mes valeurs
*/

function recherche($sql) {
/* Je stoque dans mes 3 variables les informations pour la connexion à la base*/
/* je test la connexion depuis la variable $bdd la quelle qui init mon objet qui est la connexion*/
try {
	$lien = new PDO($dsn, $utilisateur, $mdp); 
} catch  (PDOException $e) {
	echo "Une erreur s'est produite lors de la connexion : " . '<strong>' .  $e->getMessage() .'</strong>';
	/* Je récupère les erreur en cas de problèmes et j'affiche l'etat de la connexion*/
}
if (isset($lien)) {
	echo '<center>'.'Connexion - OK'.'</center>';
}

	//$lien = new PDO('mysql:host=db683412430.db.1and1.com;dbname=db683412430') or die('Une erreur s\'est produite lors de la connexion à la BDD');
	
	$stmt = $lien->prepare($sql) or die('erreur');
	$stmt->execute();

	$meta = $stmt->result_metadata();

	while ($champ = $meta->fetch_field()) {
		$parameters[] = &$ligne[$champ->name];
	}
	$resultat = array();
		call_user_func_array(array($stmt, 'bind_result'), $parameters);

		while ($stmt->fetch()) {
			foreach ($ligne as $email => $val) {
				$total[$email] = $val;
			}
			$resultat[] = $total;
		}
	return $resultat;
	$resultat->close();
	$lien->close();
}

function calcul_request($query){
	$lien = new PDO($dsn, $utilisateur, $mdp) or die('erreur');

	if ($stmt = $lien->prepare($query)) {
		$stmt->execute();
		$stmt->bind_result($resultat);
		$stmt->fetch();
		return $resultat;
		$stmt->close();
	}
	$lien->close();
}

/*
* Verification des utilisateurs
*/

function check_inscription_user($u, $pw) {
	$lien = new PDO($dsn, $utilisateur, $mdp) or die('erreur');

	$query = "SELECT * FROM enregistrer WHERE pseudo = ? AND mdp = ?";

	$mail->$query;

	if ($stmt = $lien->prepare->($mail)) {
		$mdp = mdp($pw);
		$stmt->bind_param('ss', $u ,$p);
		$stmt->execute();
		$stmt->bind_result($id, $user, $pw);

		if ($stmt->fetch()) {
			$_SESSION['authorized'] = true;
			$_SESSION['username'] = $user;
			return true;
		} else {
			return false;
		}
		$stmt->close();
	}
	$lien->close();
}