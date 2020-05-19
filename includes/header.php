<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
	echo "<script type='text/javascript'>window.top.location='login.php';</script>"; exit;
}