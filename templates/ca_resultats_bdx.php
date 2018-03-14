<?php

/* On ne donne accès au contenu de la page que si l'utilisateur est authentifié membre du CA */
$authen_ca = valider('authentifie_ca', 'SESSION');
if ($authen_ca) {
	echo '<h2>Résultats du vote</h2>';

	// On récupère les données sur les votes
	// $votes[$id_list] = ("a_rejeter"=>nb_vote_rejet, "assez_bien"=>nb_vote_AB, etc.)
	// $columns = (1=>"a_rejeter", 2=>"assez_bien", etc.)

	// On récupère le nombre de cotisants (pour déterminer le taux de participation) grâce à la longueur de la table 'votants'
	$votes = get_resultats_bdx();
	$nb_cotisants = get_nb_cotisants();
	$nb_votes_total = get_nb_votants();	
	
	$columns = build_values();
	$cols_to_print = build_choices();
	$resultats = build_resultats_bdx($votes, $columns, $nb_votes_total);
	
	// On change les données de votes pour obtenir des pourcentages plutôt que des nombres de voix
	$best_ids = get_best_ids($resultats);
	$boo_ega = (count($best_ids) >= 2);
	$best_id = define_winner($best_ids, $resultats);

//debug
	foreach($resultats as $i=>$res){
		echo '</br>';
		echo 'base:'.$i;
		print_r($res);
	}
	echo '</br>';
	echo 'to_print_ids:';
	print_r($best_ids);
	echo $best_id;


	
	$victoire = $resultats[$best_id]->nom_liste;

	// On affiche les statistiques : les nb de votes associés à chaque mention et le total du nb de votes

	include("templates/ca_resultats/afficher_votes_bdx.php");

	if ($boo_ega) {
		include("templates/ca_resultats/egalite.php");
	}
	echo "</br>La liste victorieuse est donc : <b>". $victoire ."</b>. Félicitation à eux !</p>";

	include("templates/_message_fermer_session_ca.php");
}

// Si l'uilisateur n'est pas passé par 'identification_ca' (et n'a pas saisi le mdp du CA)
else {	
	include('templates/ca_id/ca_id_cheat.php');
} 
?>