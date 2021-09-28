<?php
include 'engine/route.php';
include 'engine/source.php';

$route = new route(false);
	
libs::add_lib("rb", $route);
libs::add_lib("bootstrap", $route);
libs::add_lib("web_components", $route);
libs::add_lib("scraper", $route);

switch ($route->parse_uri()) {
	case '/':
		controller::init_model("main", $route, "auth");
		break;
	case '/csgo/':
		controller::init_model("csgo", $route, "auth");
		break;
	case '/account/signin/':
		controller::init_model("signin", $route, "guest");
		break;
	case '/valorant/':
		controller::init_model("valorant", $route, "auth");
		break;
	case '/ajax/':
		controller::init_model("ajax", $route, "auth");
		//controller::init_model("ajax", $route, "auth");
		break;
	case '/csgo/live/':
		controller::init_model("csgo_live", $route, "auth");
		//controller::init_model("ajax", $route, "auth");
		break;
	case '/valorant/data/':
		$dt = new scraper();
		echo $dt->get_tour_json($dt->parsing());
		//controller::init_model("ajax", $route, "auth");
		break;
	case '/ajax/valorant/'.$route->parse_GET(3).'/':
		$dt = new scraper();
		echo $dt->get_tour_page($route->parse_GET(3));
		//controller::init_model("ajax", $route, "auth");
		break;
	case '/ajax/'.$route->parse_GET(2).'/':
		$dt = new scraper();
		echo $dt->get_tour_json(array('/'.$route->parse_GET(2).'/'));
		break;
	case '/delete/'.$route->parse_GET(2).'/':
		controller::init_model("delete", $route, "auth");
		break;
	case '/reverse/'.$route->parse_GET(2).'/':
		controller::init_model("reverse", $route, "auth");
		break;
	case '/tournament/'.$route->parse_GET(2).'/':
		controller::init_model("tournament", $route, "auth");
		break;
	case '/tournament/csgo/'.$route->parse_GET(3).'/':
		controller::init_model("tournament_csgo", $route, "auth");
		break;
	case '/tournament/ajax/'.$route->parse_GET(3).'/':
		controller::init_model("tournament_csgo_ajax", $route, "auth");
		break;
	default:
		$route->err_code = 404;
		controller::init_model("errors", $route, "public");
		break;
}
?>