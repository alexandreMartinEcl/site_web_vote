			<h2>Merci de t'être inscrit !</h2>
			<p>Tu as bien été enregistré. Tu as à présent 24h pour régler le tarif d'entrée à l'organisateur.</p>
			<?php
				global $LIEN_PAIEMENT;
				global $TARIF_COTISANT;
				global $TARIF_EXTE;
				global $SUPPLEMENT_ALCOOL;
				$tarif_cotis_sans = $TARIF_COTISANT - $SUPPLEMENT_ALCOOL;
				$tarif_exte_sans = $TARIF_EXTE - $SUPPLEMENT_ALCOOL;
				
				if (strlen($LIEN_PAIEMENT) > 0) {
					echo "<p>Pour régler ta place, l'organisateur te propose de régler en ligne via le lien suivant:</p>";
					echo "<p><a href=$LIEN_PAIEMENT target='_blank'>$LIEN_PAIEMENT</a></p>";
				}

				echo "<p>Les tarifs sont :</p>";
				echo "<ul><li>$TARIF_COTISANT € pour la personne cotisante ($tarif_cotis_sans € sans alcool)</li>";
				echo "<li>$TARIF_EXTE € pour une personne non cotisante ($tarif_exte_sans € sans alcool)</li></ul>";

			?>

			<p>Pour que quelqu'un d'autre puisse s'inscrire sur cette machine, <a href="index.php?view=votant_id" style="color:blue";>clique ici</a>.
			</p>
