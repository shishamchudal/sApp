<?php

include 'includes/header.php';
include('database_connection.php');
$user_id = $_SESSION['id'];



if (isset($_POST["Send"])) {
	try {
		$statement = $connect->prepare("
  INSERT INTO `chat`(
      `user_id`,
      `message`
  )
  VALUES(
      :user_id,
      :message
  );
  ");
		$statement->execute(
			array(
				':user_id'               =>  trim($user_id),
				':message'             =>  trim($_POST["message"])
			)
		);
	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
}
if (isset($_GET["delete"]) && $_GET["delete"] == 1) {
	if ($_SESSION["User_type"] == "Admin") {
		$statement = $connect->prepare(
			"DELETE FROM chat"
		);
		$statement->execute();
		echo '
	<script>
		alert("Message deleted sucessfully!");
			window.top.location = "chat.php";
	</script>
	';
	} else {
?>
		<script>
			alert("You are not allowed to delete 😡!");
			window.top.location = "chat.php";
		</script>
<?php
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Swipe – The Simplest Chat Platform</title>
	<meta name="description" content="#">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<!-- Swipe core CSS -->
	<link href="css/swipe.min.css" type="text/css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<!-- Favicon -->
	<link href="img/favicon.png" type="image/png" rel="icon">
</head>

<body>
	<main>
		<div class="layout">
			<div class="main">
				<div class="tab-content" id="nav-tabContent">
					<!-- Start of Babble -->
					<div class="babble tab-pane fade active show" id="list-chat" role="tabpanel" aria-labelledby="list-chat-list">
						<!-- Start of Chat -->
						<div class="chat" id="chat1">
							<div class="top">
								<div class="container">
									<div class="col-md-12">
										<div class="inside">
											<a href="#"><img class="avatar-md" src="img/avatars/avatar-female-5.jpg" data-toggle="tooltip" data-placement="top" title="Keith" alt="avatar"></a>
											<div class="status">
												<i class="material-icons online">fiber_manual_record</i>
											</div>
											<div class="data">
												<h5><a href="#">Group Chat</a></h5>
											</div>
											<div class="dropdown">
												<button class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons md-30">more_vert</i></button>
												<div class="dropdown-menu dropdown-menu-right">
													<a href="profile.php"><button class="dropdown-item info"><i class="material-icons">info</i>Account Info</button></a>
													<?php
													include_once 'header.php';
													if ($_SESSION["User_type"] == "Admin") {
													?>
														<a href="chat.php?delete=1"><button class="dropdown-item delete"><i class="material-icons">delete</i>Delete History</button></a>
													<?php
													}
													?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="content" id="content">
								<div class="container">
									<div class="col-md-12" id="msg-list"></div>
								</div>
							</div>
							<script>
								var chat = {};
								$(document).ready(function() {
									scrollToBottom(document.getElementById('content'));
									chat.fetchMessage = function() {
										scrollToBottom(document.getElementById('content'));
										$.ajax({
											url: "load.php",
											method: "POST",
											success: function(data) {
												$('#msg-list').html(data);
											}
										});

										scrollToBottom(document.getElementById('content'));
									};
									chat.interval = setInterval(chat.fetchMessage, 3000);
									chat.fetchMessage();
									scrollToBottom(document.getElementById('content'));

								});
							</script>
							<div class="container">
								<div class="col-md-12">
									<div class="bottom">
										<form method="post" id="message_form" class="position-relative w-100">
											<textarea name="message" id="message" class="form-control" placeholder="Start typing for reply..." rows="1"></textarea>
											<button class="btn emoticons"><i class="material-icons">insert_emoticon</i></button>
											<button type="submit" id="Send" name="Send" class="btn send"><i class="material-icons">send</i></button>
										</form>
										<label>
											<a href="index.php"><span class="btn attach d-sm-block d-none"><i class="material-icons">home</i></span></a>
										</label>
									</div>

									<script>
										$(document).ready(function() {
											$('#Send').click(function() {
												$('#message_form').submit();

												scrollToBottom(document.getElementById('content'));
											});

										});
									</script>
								</div>
							</div>
						</div>
						<!-- End of Chat -->
					</div>
					<!-- End of Babble -->
					<!-- Start of Babble -->
					<div class="babble tab-pane fade" id="list-empty" role="tabpanel" aria-labelledby="list-empty-list">
						<!-- Start of Chat -->
						<div class="chat" id="chat2">
							<div class="container">
								<div class="col-md-12">
									<div class="bottom">
										<form class="position-relative w-100">
											<textarea class="form-control" placeholder="Start typing for reply..." rows="1" autofocus="autofocus" onfocus="this.select()"></textarea>
											<button class="btn emoticons"><i class="material-icons">insert_emoticon</i></button>
											<button type="submit" class="btn send"><i class="material-icons">send</i></button>
										</form>
										<label>
											<input type="file">
											<span class="btn attach d-sm-block d-none"><i class="material-icons">attach_file</i></span>
										</label>
									</div>
								</div>
							</div>
						</div>
						<!-- End of Chat -->
					</div>
				</div>
			</div> <!-- Layout -->
	</main>
	<!-- Bootstrap/Swipe core JavaScript
		================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="js/popper.min.js"></script>
	<script src="js/swipe.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

	<script>
		function scrollToBottom(el) {
			el.scrollTop = el.scrollHeight;
		}
		scrollToBottom(document.getElementById('content'));
	</script>
</body>

</html>