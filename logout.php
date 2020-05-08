<?php
session_start();
session_destroy();
// Redirect to the login page:
	echo "<script type='text/javascript'>window.top.location='login.php';</script>"; exit;
?>