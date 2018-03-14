<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();
if (file_exists("libs/maLibUtils.php")){
	include_once "libs/maLibUtils.php";
}
if (file_exists("libs/maLibCA.php")){
	include("libs/maLibCA.php");
}

include("libs/manage_vote_bdx.php");
include("libs/manage_vote_ca.php");
include("libs/manage_inscription.php");

// On commence par constater combien il y a de listes, pour pouvoir régler la suite
$listes = valider($_SESSION['listes']);
if (!$listes){
	// On récupère le nom des liste et leurs id sur la BDD
	$listes = get_candidates_bdx();
	$_SESSION['nb_listes'] = count($listes);
	$_SESSION['listes'] = $listes;
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style.css" />
		<title>Votes BDX</title>
		<meta property="og:image:secure" content="https://elections-asso.centralelille.fr/images/Logo_CA.png" />
		<meta property="og:image:width" content="200" />
		<meta property="og:image:height" content="85" />
		<meta property="og:title" content="Elections assos - CLA" />
	</head>
	
	<body>
		<div id="bloc_page">
			<!-- header -->
			<?php 

			$view = valider("view"); 
			if (!$view) $view = "home"; 

			include("templates/_en_tete_.php");
			//menu
			include("templates/_menu_.php");

			reinit_session_if_need();
			echo "<section id='content'>";
			
//debug
/*
			echo 'session:';
			print_r($_SESSION);
			echo '</br>';
			echo 'post:';
			print_r($_POST);
			echo '</br>';
			echo 'get:';
			print_r($_GET);
			echo '</br>';
*/			
			//ajoute dans le body la page selon l'input $view
			if (file_exists("templates/$view.php")){
				include("templates/$view.php");
			}
			else{
				die("Could not find $view");
			}
			
			echo "</section>";
			
			//footer
			include("templates/_pied_de_page_.php");
			?>

		</div>
	</body>				
</html>