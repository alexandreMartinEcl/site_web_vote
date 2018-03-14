<?php
session_start();
include_once("libs/maLibCA.php");
include_once("libs/config.php");

GLOBAL $CONFIG_MDP_ORGA;

$authen_orga = valider('authentifie_orga', 'SESSION');
$mdp_orga = valider('mdp', 'POST');
if($authen_orga || ($mdp_orga && $mdp_orga === $CONFIG_MDP_ORGA)){
	$key = generate_res_key();

	$files = scandir("res");

	for($i=2; $i<count($files); $i++){
		unlink("res/".$files[$i]);
	}

	$filename = "res/temp_inscrits_" . $key . ".csv";
	sql_select_inscrits_csv($filename);
	header("Location: $filename");
}
else{
	include('templates/ca_id/orga_id_cheat.php');
}
?>