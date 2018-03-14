	<h2>Cet inscrit a déjà payé</h2>
	<p>Vous pouvez le désinscrire si la personne le désire et si vous le remboursez. Il ne pourra pas le faire lui-même. 
	Passez à l'inscrit suivant en <a href="index.php?view=orga_ajout_paiement" style="color:blue";>cliquant ici</a>.

	<?php
	global $TARIF_COTISANT;
	global $TARIF_EXTE;
	global $SUPPLEMENT_ALCOOL;

	echo "<p>Sa place est $inscrit[alcool] alcool.</p>";

	$id_cotisant = ($inscrit['id_cotisant'] == 0 ? $inscrit['id_garant'] : $inscrit['id_cotisant']); 
	$is_cotisant = 	($inscrit['id_garant'] == 0 ? 1 : 0);

	$a_rembourser = ($inscrit['id_garant'] == 0 ? $TARIF_COTISANT + (empty($exte) || $exte['a_paye'] == 0 ? 0 : $TARIF_EXTE) : $TARIF_EXTE);
	$a_rembourser = $a_rembourser - ($inscrit['alcool'] === "sans" ? $SUPPLEMENT_ALCOOL : 0);
	
	if (!empty($exte)){
		if($exte['a_paye'] == 1){
			$a_rembourser = $a_rembourser + $TARIF_EXTE - ($exte['alcool'] === "sans" ? $SUPPLEMENT_ALCOOL : 0);

			echo "<p>Elle se porte également garant pour une personne extérieure à CLA: $exte[prenom] $exte[nom]. Sa place est déjà réglée, $exte[alcool] alcool.</p>";
		} 
		else{
			echo "<p>Elle se porte également garant pour une personne extérieure à CLA: $exte[prenom] $exte[nom], qui n'a pas encore payé sa place, $exte[alcool] alcool. Refaite la démarche avec son nom pour régler à sa place.</p>";
		}
	}

	echo '<form action="index.php?view=orga_ajout_paiement" method="post">';
	echo "<input type=hidden name=annuler_inscrit value=$id_cotisant />";
	echo "<input type=hidden name=is_cotisant value=$is_cotisant />";
	echo "<label for=cb_inscrit>Désinscrire la personne (après remboursement physique de $a_rembourser €) 
	(désinscrira automatiquement la personne pour laquelle elle se porte garant le cas échéant)</label>";

	echo '<input type="submit" value="Désinscrire" />';
	echo '</form>';
	
	?>

