<html>
	<p> Il y a eu égalité ! Pour choisir le vainqueur, on utilise la sommes des votes pour les mentions inférieures et la somme 
	des votes pour les mentions supérieures pour chaque liste, et on les compare. </p>
	<p>Si le plus grand total est une somme de votes pour des mentions inférieures, alors la liste concernée gagne, sinon elle perd. </p>
	<p>Ici, nous avons les totaux suivants : </p>
</html>

<?php
	$mention_maj = $resultats[$best_id]->mention_maj;
	foreach ($best_ids as $id) {
		$resultat = $resultats[$id];
		echo 'Liste '. $resultat->nom_liste .' :'; 
		echo 'total des voix pour les mentions ';
		
		echo 'Inférieures : '.round($resultat->votes_inf, 2).' %</br>'; 
		echo 'Supérieures : '.round($resultat->votes_sup, 2).' %</br>'; 
	}
?>