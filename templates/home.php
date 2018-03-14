			<?php

			echo("<h2>Bienvenue sur le site de vote !</h2>\n");

			$creneau = check_login_available();
			switch ($creneau) {
				case "event":
					include("templates/home/event.php");
					break;
				case "ca":
					include("templates/home/ca.php");
					break;
				case "event":
					if ($_SESSION['nb_listes'] <= 2) {
						include("templates/home/two_lists.php");
					} elseif ($_SESSION['nb_listes'] == 3) {
						include("templates/home/three_lists.php");
					}
					break;
				default:
					include("templates/home/nothing.php");
					break;
			}

			include("templates/home/info.php");
			?>

