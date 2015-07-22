<?php
	session_start();
	include_once('includes/headerwc.html');
	require_once('includes/functions.php');
	$functions = new Functions;
	$functions->Connect();
	if (!isset($_SESSION['user']))
	{
		if (isset($_POST['login']) && $_POST['login'] == 1)
		{
			$login_successful = $functions->Login($_POST['user'], sha1($_POST['pass']));
			if ($login_successful)
			{
				if (!empty($_SESSION['id']))
				{
					print "\t\t\t\t" . '<p>Se ha conectado correctamente. Ser&aacute; redirigido a la p&aacute;gina principal autom&aacute;ticamente.</p>' . "\n";
					print "\t\t\t\t" . '<script type="text/javascript">location.href="index.php";</script>' . "\n";
				}
				else
				{
					print "\t\t\t\t" . '<p>Los datos introducidos son incorrectos.</p>' . "\n";
					session_destroy();
					$functions->ShowForm(1);
				}
			}
			else
			{
				print "\t\t\t\t" . '<p>No se ha podido conectar.</p>' . "\n";
				session_destroy();
				$functions->ShowForm(1);
			}
		}
		else
		{
			session_destroy();
			$functions->ShowForm(1);
		}
	}
	elseif (isset($_GET['logout']))
	{
		$_SESSION = array();
		session_destroy();
		print "\t\t\t\t" . '<p>Se ha desconectado correctamente. Ser&aacute; redirigido a la p&aacute;gina principal autom&aacute;ticamente.</p>' . "\n";
		print "\t\t\t\t" . '<script type="text/javascript">location.href="index.php";</script>' . "\n";
	}
	else
		print "\t\t\t\t" . '<p>Ya est&aacute;s conectado.</p>' . "\n";
	$functions->Disconnect();
	include_once('includes/footer.html');
?>