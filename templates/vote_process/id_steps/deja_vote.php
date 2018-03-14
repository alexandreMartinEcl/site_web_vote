		<?php 

		$name = valider('prenom', 'SESSION'); 
		if (!$view) die("Erreur: la session ne contient pas de prénom"); 
		?>

		<html>
			<h2>Tu as déjà voté !</h2>
			<p>	Tu as déjà voté, <?= $_SESSION['prenom'] ?>, et tu ne pourras pas voter une seconde fois.
				Pour que quelqu'un d'autre puisse voter sur cette machine, 
				<a href="index.php?view=votant_id" style="color:blue";>clique ici</a>.
			</p>
		</html>