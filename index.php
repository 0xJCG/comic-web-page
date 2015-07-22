<?php
	session_start();
	
	/*require_once('includes/functions.php');
	$functions = new Functions;*/
	require_once("Database.class.php");
	$db = DatabaseLayer::getConnection("MySqlProvider");
	
	/* Selecting the comic to show. */
	if (isset($_GET['comic']))
		$rs = $db->execute("SELECT comics.id, path, title, username, date FROM comics, users WHERE comics.author = users.id AND comics.id = ?", array($_GET['comic']));
	elseif (isset($_GET['first']))
		$rs = $db->execute("SELECT comics.id, path, title, username, date FROM comics, users WHERE comics.author = users.id ORDER BY id ASC LIMIT 0, 1");
	elseif (isset($_GET['random']))
		$rs = $db->execute("SELECT comics.id, path, title, username, date FROM comics, users WHERE comics.author = users.id ORDER BY RAND() LIMIT 0, 1"); // Random comic.
	else
		$rs = $db->execute("SELECT comics.id, path, title, username, date FROM comics, users WHERE comics.author = users.id ORDER BY id DESC LIMIT 0, 1"); // By default, we show the newest comic.
	
	/* We show the comic only if it exists. */
	if ($rs)
	{
		$comic_id = $rs[0];
		$comic_path = $rs[1];
		$comic_title = $rs[2];
		$comic_author = $rs[3];
		$comic_date = date("d-m-Y", strtotime($rs[4])); // Converting the american data into european.
		
		/* Taking the id of the previous and next comics of the selected one. */
		$prev_next = $db->execute("SELECT (SELECT id FROM comics WHERE id < ? ORDER BY id DESC LIMIT 0, 1) AS previous, (SELECT id FROM comics WHERE id > ? ORDER BY id ASC LIMIT 0, 1) AS next", array($comic_id, $comic_id));
		$prev = $prev_next[0];
		$next = $prev_next[1];
		
		/* Printing the comic. */
		require_once('includes/comic.php');
	}
	else
		print "\t\t\t\t" . '<p>Error, el c&oacute;mic seleccionado no existe.</p>' . "\n";
	
	//$functions->Disconnect();
?>