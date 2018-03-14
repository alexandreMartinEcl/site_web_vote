<?php

/* On ne donne accès au contenu de la page que si l'utilisateur est authentifié membre du CA */
$authen_ca = valider('authentifie_ca', 'SESSION');
if ($authen_ca) {
	echo '<h2>Résultats du vote</h2>';

	// On récupère les données sur les votes
	// $votes[$id_list] = ("a_rejeter"=>nb_vote_rejet, "assez_bien"=>nb_vote_AB, etc.)
	// $columns = (1=>"a_rejeter", 2=>"assez_bien", etc.)
	$nb_votes_total = get_nb_votants();
	$votes = get_resultats_ca();
	$resultats = build_resultats_ca($votes);
	$winners = define_winners_ca($resultats);

	$boo_ega = (count($best_ids) >= 2);
	$best_id = define_winner($best_ids, $resultats);

//debug
/*	foreach($resultats as $i=>$res){
		echo '</br>';
		echo 'base:'.$i;
		print_r($res);
	}
	echo '</br>';
	echo 'to_print_ids:';
	print_r($best_ids);
	echo $best_id;
*/

	// On récupère le nombre de cotisants (pour déterminer le taux de participation) grâce à la longueur de la table 'votants'
	$nb_cotisants = get_nb_cotisants();
	
	$victoire = $resultats[$best_id]->nom_liste;

	// On affiche les statistiques : les nb de votes associés à chaque mention et le total du nb de votes

	include("templates/ca_resultats/afficher_votes_ca.php");

	include("templates/_message_fermer_session_ca.php");
}

// Si l'uilisateur n'est pas passé par 'identification_ca' (et n'a pas saisi le mdp du CA)
else {	
	include('templates/ca_id/ca_id_cheat.php');
} 
?>