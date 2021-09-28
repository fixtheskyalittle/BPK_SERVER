<?php 
$title = "Fegion";
	unset($_SESSION['auth_perx']);
	header('Location: /');
controller::init_view($route, "logout", false, null);
?>
