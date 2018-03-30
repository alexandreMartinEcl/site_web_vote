<?php
session_start();
include_once("libs/maLibCA.php");
include_once("libs/config.php");

GLOBAL $CONFIG_MDP_ORGA;

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$authen_orga = valider('authentifie_orga', 'SESSION');
$mdp_orga = valider('mdp', 'POST') ? valider('mdp', 'POST') : $obj['mdp'];
$output_type = valider('type', 'POST') ? valider('type', 'POST') : $obj['type'];

if($authen_orga || ($mdp_orga && $mdp_orga === $CONFIG_MDP_ORGA)){
	if ($output_type == 'json') {

		$data = array();
		$data["success"] = true;
		$data["result"] = sql_select_inscrits();

		echo json_encode($data);
	} else {
	
		$key = generate_res_key();
		$files = scandir("res");
	
		for($i=2; $i<count($files); $i++){
			unlink("res/".$files[$i]);
		}
	
		$filename = "res/temp_inscrits_" . $key . ".csv";
		sql_select_inscrits_csv($filename);
		header("Location: $filename");
	}
}
else{
	include('templates/ca_id/orga_id_cheat.php');
}
?>
