	<?php 
	echo "\n<p>Voici les statistiques concernant les résultats du vote : </p>";
	echo "\n<p>Il y a eu ". $nb_votes_total ." votes pour ". $nb_cotisants ." cotisants, soit un taux de participation";
	echo "de ". round($nb_votes_total/$nb_cotisants * 100, 2) ."%.</p></br>";

	foreach($winners as $college=>$liste_winners) {
		echo "\n<p>Pour le collège <i>". $college ."</i> voici les gagnants :</p>";
		foreach($liste_winners as $name => $nb_votes){
			echo "\n<p>".$name ." avec ". $nb_votes ." votes.</p>";
		}
		
		if(count($liste_winners) > 5){
			echo "\n<p style='color:red;' >Attention, il y a eu égalité, les plus jeunes des candidats à égalité sont élus.</p>";
		}
		echo "<br>";
	}
	
	?>