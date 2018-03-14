<html>
<h2>Identification de l'inscrit</h2> 

<!-- vérification du prénom, cursus, année -->

<p>Laquelle de ces personnes le votant est-il/elle ? :</p>
<form action="index.php?view=orga_ajout_paiement" method="post">
	<?php
		foreach($people as $inscrit){
			$inscrit_id = $inscrit['id'];
			$to_print = $inscrit['prenom'].' '.$inscrit['nom'].', '.$inscrit['cursus'].', '. ($inscrit['id_garant'] == 0 ? "Cotisant" : "Extérieur");
			echo "<input type=radio name=identification value=$inscrit_id id=$inscrit_id />
				<label for=$inscrit_id>$to_print</label>
				<br/>";
		}
	?>
	<input type="radio" name="identification" value="non" id="non" checked="checked" /> <label for="non">  Aucune</label> 
	<br/>
	<br/>
	<input type="submit" value="Valider" />
</form> 
</html>