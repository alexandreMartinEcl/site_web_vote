<?php

	$id = valider('id', 'GET');
	$text_path = "motivations/$id.txt";
	$pic_path = "images/cand_$id";
	
	$myfile = fopen($text_path, "r") or die("Motivations introuvable, $id est un mauvais id");

	echo "<h3 style='text-align:center'>". fgets($myfile) . "</h3>";
	echo "<div>";
	echo '<img src='.$pic_path.' width=200 height=200 style="float:left" />';
	while(!feof($myfile)){
		echo '<div>'. fgets($myfile) .'</div>';
	}   
	echo "</div>";
	
	fclose($myfile);


?>

