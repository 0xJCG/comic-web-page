<?php
	if (isset($_SESSION['user']))
		$user = $_SESSION['user'];
	else
		$user = "";
	
	$texts = array(
		'comic' => 'cómic',
		'no_comic_show' => 'No hay ningún cómic a mostrar',
		'login' => 'Conectar',
		'logout' => 'Desconectar',
		'hi_user' => "&iexcl;Hola, $user!",
		'web_by' => "Página web realizada por",
	);
?>