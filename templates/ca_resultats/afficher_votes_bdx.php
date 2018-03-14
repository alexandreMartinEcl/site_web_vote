	<?php 
	echo "\n<p>Voici les statistiques concernant les résultats du vote : </p>";
	echo "\n<p>Il y a eu ". $nb_votes_total ." votes pour ". $nb_cotisants ." cotisants, soit un taux de participation";
	echo " de ". round($nb_votes_total/$nb_cotisants * 100, 2) ."%.</p></br>";

	foreach($resultats as $resultat) {
		echo "\n<p>La liste <i>". $resultat->nom_liste ."</i> a reçu les votes suivants :</p>";
		foreach($columns as $id => $column){
			echo "\n<p>mention ". $cols_to_print[$id] ." :  ". round($resultat->perc_votes[$id], 2) ." % (". round($resultat->base_votes[$id], 2) ."), </p>";
		}

		echo "\n<p>Sa mention majoritaire est : <b>". $columns[$resultat->mention_maj] ."</b>.</p></br>";
	}
	
	echo "\n<p>[On essaiera d'afficher des graphiques pour visualiser la répartition des voix]</br></br></p>";
	?>