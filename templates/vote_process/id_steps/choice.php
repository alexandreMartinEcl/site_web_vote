<html>
<h2>Identification</h2> 

<!-- vérification du prénom, cursus, année -->

<p>Etes-vous cette personne ? (ou laquelle de ces personnes ?) :</p>
<form action="index.php?view=votant_id" method="get">
	<input type='hidden' name='view' value='votant_id' />
	<?php
		foreach($people as $voter){
			$voter_id = $voter['id'];
			$to_print = $voter['prenom'].' '.$voter['nom'].', '.$voter['cursus'];
			echo "<input type=radio name=identification value=$voter_id id=$voter_id />
				<label for=$voter_id>$to_print</label>
				<br/>";
		}
	?>
	<input type="radio" name="identification" value="non" id="non" checked="checked" /> <label for="non">  Non</label> 
	<br/>
	<br/>
	<input type="submit" value="Valider" />
</form> 
</html>