<script>
	function checkBoxClicked($card_id, $cb_id){
		var checkBox = document.getElementById($cb_id);
		var background = document.getElementById($card_id);
		if(checkBox.checked){
			background.className = "cb_unselected";
			background.style.backgroundcolor = '#FFFFFF';
			checkBox.checked = false;
		}
		else if(chck_form()){
			background.className = "cb_selected";
			background.style.backgroundcolor = '#FF6600';
			checkBox.checked = true;
		}
	}

	function chck_form(){
		let form = document.getElementById("vote_form");
		let cnt = 0;
		for(let i = 0; i<form.elements.length; i++){
			let elem = form.elements[i];
			if(elem.type == "checkbox"){
				if(elem.checked){
					cnt++;
				}
			}
		};

		return cnt < 2;
	}
</script>

<?php

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
//CALCUL RESULTATS
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

function build_resultats_ca($res_by_coll){
	$res = array();

	foreach($res_by_coll as $college=>$candidats){
		$res[$college] = new resultat_college_ca($candidats, $college);
	}

	return $res;	
}

function define_winners_ca($resultats){
	$res = array();

	function get_winners($res_coll){
		return $res_coll->get_winners();
	}

	return array_map("get_winners", $resultats);
}

class resultat_college_ca{
	public $college;
	public $candidats_names = array();
	public $candidats_votes = array();

	public function __construct($cand_college, $college){
		$this->college = $college;
		$this->build_candidats($cand_college);		
	}

	public function build_candidats($cands){
		foreach ($cands as $rw){
			$id = $rw['id'];
			$this->candidats_names[$id] = $rw['nom'];
			$this->candidats_votes[$id] = $rw['votes'];	
		}
	}
	
	public function get_winners(){
		$sort_cand = $this->candidats_votes;

		//sort descendant by the value (aka number of votes)
		arsort($sort_cand);

		$res = array();
		$tem_votes = 0;
		foreach($sort_cand as $id=>$votes){
			//check if we have already 5 winners
			//if we do, but the next candidate has as many votes as the last one
			// we add him
			if(count($res) >= 5 && $tem_votes != $votes){
				break;
			}
			
			$tem_votes = $votes;
			$name = $this->candidats_names[$id];
			$res[$name] = $votes;			

		}
		return $res;
	}	
}


//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
//BUILD FORM
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

function complete_form_ca($candidates, $choices, $college="G1"){
	echo "\n<p>$college :</p>";
	
	echo "<div class='row'>";
	foreach ($candidates as $candidate) {
		$c_name = $candidate['nom'];
		$id = $candidate['id'];
		
		make_checkbox_ca($c_name, $id);
		
	}
	echo "</div>";
	echo '</br>';
}

function make_checkbox_ca($cand_name, $cand_id){
	$card_id = "card_" . $cand_id;
	$cb_id = "cb_" . $cand_id;
	$src = "images/cand_" . $cand_id;

	echo "<div id='$card_id' class='cb_unselected'>";
	make_hidden_checkbox($cand_id, $cb_id);
	echo '<img src='.$src.' onclick="checkBoxClicked(\''.$card_id.'\', \''.$cb_id.'\');" style="cursor:pointer;" />';
	echo "<div>$cand_name</div>";
	echo "<div><a href='index.php?view=motivations&id=$cand_id' target='_blank'>Motivations</a></div>";
	echo "</div>";
}

function make_hidden_checkbox($cand_id, $cb_id){
	echo "\n<span style='display:none;'>";
	echo "<input type=checkbox name=$cand_id value=1 id='$cb_id' />";
	echo "</span>\n";
}


//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
//MAKE VOTE
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

function extract_cand_ids($cand){
	return $cand['id'];
}

function build_votes_ca($posted, $candidates, $id_blanc){
	/*Renvoie un array avec valeurs du type: res[liste_id] = 'passable'
	En ne considérant uniquement les valeurs de ce qui a été posté,
	dont les clés figurent dans les id de $listes

	Et ne renvoie que des termes figurant dans $columns (construit avec build_values())
	*/
	$candidates_ids = array_map('extract_cand_ids', $candidates);

	$res = array();
	$cnt = 0;
	foreach (array_keys($posted) as $key){
		if($key != "mot_de_passe"){
			if(!array_key_exists($key, $candidates_ids)){
				return '';
			}
			$cnt++;
			$res[$key] = 1;
		}
	}

	if($cnt > 2){
		return '';
	}
	elseif($cnt == 1){
		$res[$id_blanc] = 1;
	}
	elseif($cnt == 0){
		$res[$id_blanc] = 2;
	}

	return $res;
}

?>