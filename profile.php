<?php 

include 'includes/header.php'; 
include('database_connection.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Profile</title>

	<!-- Custom fonts for this template-->
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">

		<?php include("includes/sidebar.php"); ?>

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">

				<?php include("includes/topbar.php"); ?>

<?php


// We need to use sessions, so you should always start sessions using the below code.

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	echo "<script type='text/javascript'>window.top.location='index.php';</script>"; exit;
exit();
}
include 'cred_account.php';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	die('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare('SELECT password, email, User_type FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email, $User_type);
$stmt->fetch();
$stmt->close();


?>

				<div class="container-fluid">
					<h2> Profile Page</h2>
					<div>
						<p> Your account details are below:</p>
						<table>
							<tr>
								<td></td>
								<td>Username:</td>
								<td><?= $_SESSION['name'] ?></td>
							</tr>
							<tr>
								<td></td>
								<td>Email:</td>
								<td><?= $email ?></td>
							</tr>
							<tr>
								<td></td>
								<td>User Type:</td>
								<td><?= $User_type ?></td>
							</tr>
						</table>
					</div>
				</div>
				<?php

				include('includes/scripts.php');
				include('includes/footer.php');

				?>
			</div>
		</div>
	</div>
</body>
</html>