	<h2>Cet inscrit n'a pas encore réglé sa place</h2>
	<p>Vous pouvez l'encaisser et indiquer qu'il a payé pour sa soirée dansante.</p>

<?php
	global $TARIF_COTISANT;
	global $TARIF_EXTE;
	global $SUPPLEMENT_ALCOOL;

	$tarif_inscrit = ($inscrit['id_garant'] == 0 ? $TARIF_COTISANT : $TARIF_EXTE);
	$tarif_inscrit = $tarif_inscrit - ($inscrit['alcool'] === "sans" ? $SUPPLEMENT_ALCOOL : 0);
	$tarif_inscrit = $tarif_inscrit;

	$id_cotisant = ($inscrit['id_cotisant'] == 0 ? $inscrit['id_garant'] : $inscrit['id_cotisant']); 

	echo "<p>Le tarif pour cette personne est : $tarif_inscrit € ($inscrit[alcool] alcool)</p>";
	
	if (!empty($exte)){
		$tarif_exte = $TARIF_EXTE - ($exte['alcool'] === "sans" ? $SUPPLEMENT_ALCOOL : 0);

		if($exte['a_paye'] == 1){
			echo "<p>Il se porte également garant pour une personne extérieure à CLA: $exte[prenom] $exte[nom]. Sa place est déjà réglée, $exte[alcool] alcool.</p>";
		} 
		else{
			echo "<p>Il se porte également garant pour une personne extérieure à CLA: $exte[prenom] $exte[nom]. Il peut donc régler $tarif_exte € de plus pour sa place, $exte[alcool] alcool.</p>";
		}
	}

	echo '<form action="index.php?view=orga_ajout_paiement" method="post">';

	echo "<input type=checkbox name=payer_cotisant id=cb_cotis value=$inscrit[id] />";
	echo "<label for=cb_cotis>Régler pour l'inscrit</label>";

	if (!empty($exte) && $exte['a_paye'] == 0){
		echo "<input type=checkbox name=payer_exte id=cb_exte value=$exte[id] />";
		echo "<label for=cb_exte>Régler pour la personne extérieure</label>";
	}

	echo '<input type="submit" value="Payer" />';
	echo '</form>';
	
?>


	<p>Passez à un autre inscrit en <a href="index.php?view=orga_ajout_paiement" style="color:blue";>cliquant ici</a>. </p>
