<?php 

function envoi_mail($mdp, $addr){

	// On crée aléatoirement un mot de passe pour la personne

	////$new_password = generate_password($_SESSION['prenom'], $_SESSION['nom']);
	////$_SESSION['mot_de_passe'] = $new_password ;

	// On enregistre ce nouveau mdp dans la BDD
	////update_mdp($new_password, $_SESSION['id']);

	// On travaille maintenant sur le mail à proprement parler 

	// Construction de l'adresse de destination.
	////$mail = $_SESSION['mail'] ;


	// On filtre les serveurs qui rencontrent des bogues.
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) 
	{
		$passage_ligne = "\r\n";
	}
	else
	{
		$passage_ligne = "\n";
	}
	//=====Déclaration des messages au format texte et au format HTML.
	$message_txt = "Bonjour brave cotisant !";
	$message_txt.= "\nAfin de pouvoir t'authentifier et t'inscrire, rentre ce mot de passe dans le site de vote : ".$mdp;
//	$message_txt.= "\nAfin de pouvoir t'authentifier et voter, rentre ce mot de passe dans le site de vote : ".$mdp;
	$message_txt.= "\nMerci d'utiliser le systeme de vote informatique !";

	$message_html = "<html><head></head><body>Bonjour brave cotisant !</br>";
	$message_html.= "<p>Afin de pouvoir t'authentifier et t'inscrire, rentre ce mot de passe dans le site de vote : ".$mdp . "</p>";
//	$message_html.= "<p>Afin de pouvoir t'authentifier et voter, rentre ce mot de passe dans le site de vote : ".$mdp . "</p>";
	$message_html.= "<p>Merci d'utiliser le systeme de vote informatique !</p>";
	//==========

	//=====Création de la boundary
	$boundary = "-----=".md5(rand());
	//==========

	//=====Définition du sujet.
	$sujet = "Ton mot de passe pour l'inscription";
//	$sujet = "Ton mot de passe pour le vote CA élèves";
	//=========

	//=====Création du header de l'e-mail.
	$header = "From: \"CA Eleves\" <alexandre.martin.16@centrale.centralelille.fr>".$passage_ligne;
	$header.= "Reply-to: \"CA Eleves\" <alexandre.martin.16@centrale.centralelille.fr>".$passage_ligne;
	$header.= "MIME-Version: 1.0".$passage_ligne;
	$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
	//==========

	//=====Création du message.
	$message = $passage_ligne."--".$boundary.$passage_ligne;
	//=====Ajout du message au format texte.
	$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_txt.$passage_ligne;
	//==========
	$message.= $passage_ligne."--".$boundary.$passage_ligne;
	//=====Ajout du message au format HTML
	$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_html.$passage_ligne;
	//==========
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	//==========

	//=====Envoi de l'e-mail.
	mail($addr,$sujet,$message,$header);
	//==========
}
?>