<?php 
	$title = "Fegion";
	$match_reverse = R::findOne('csgo_match', 'match_key = ?', [$route->parse_GET(2)]);
	$comand1 = $match_reverse->comand_1;
	$comand2 = $match_reverse->comand_2;
	$match_reverse->comand_1 = $comand2;
	$match_reverse->comand_2 = $comand1;
	R::store($match_reverse);
	#R::trash($match_del);
	header('Location: /tournament/csgo/'.$route->parse_GET(2).'/');
	controller::init_view($route, "logout", false, null);
?>