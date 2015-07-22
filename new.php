<?php
	session_start();
	include_once('includes/headerwc.html');
	require_once('includes/functions.php');
	$functions = new Functions;
	$functions->Connect();
	if (isset($_SESSION['type']) && $_SESSION['type'] == 1)
		$functions->ShowForm(2);
	else
		print "\t\t\t\t" . '<p>You need to be connected or be the administrator.</p>' . "\n";
	if (isset($_POST['send']) && $_POST['send'] == 1) {
		if ($functions->NewComic($_POST['title'], 'images/comics/', 'comic'))
			print "\t\t\t\t" . '<p>C&oacute;mic nuevo subido.</p>' . "\n";
		else
			print "\t\t\t\t" . '<p>Ha sido imposible subir el nuevo c&oacute;mic.</p>' . "\n";
	}
	$functions->Disconnect();
	include_once('includes/footer.html');
?>