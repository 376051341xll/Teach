<?php
	session_start();
	if($_SESSION['shell'] < 1)
	{
		$_SESSION['shell'] = '';
		echo "<script>window.parent.location.href='login.php'; </script>";
	}
?>