<?php 
	$title = "Fegion";
	$match_del = R::findOne('csgo_match', 'match_key = ?', [$route->parse_GET(2)]);
	R::trash($match_del);
	header('Location: /');
	controller::init_view($route, "logout", false, null);
?>