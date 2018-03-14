<html>
<h2>Identification du votant</h2> 

<!-- vérification du prénom, cursus, année -->

<p>Laquelle de ces personnes le votant est-il/elle ? :</p>
<form action="index.php?view=orga_ajout_paiement" method="post">
	<?php
		foreach($people as $voter){
			$voter_id = $voter['id'];
			$to_print = $voter['prenom'].' '.$voter['nom'].', '.$voter['cursus'];
			echo "<input type=radio name=identification value=$voter_id id=$voter_id />
				<label for=$voter_id>$to_print</label>
				<br/>";
		}
	?>
	<input type="radio" name="identification" value="non" id="non" checked="checked" /> <label for="non">  Aucune</label> 
	<input type="hidden" name="mode" value="cotisant" />
	<br/>
	<br/>
	<input type="submit" value="Valider" />
</form> 
</html>