<?php

// Change this to your connection info.
include 'cred_account.php';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}
if(isset($_POST['Register'])) {
    

    // Now we check if the data was submitted, isset() function will check if the data exists.
    if (!isset($_POST['username'], $_POST['password1'], $_POST['password2'], $_POST['email'])) {
        // Could not get the data that should have been sent.
        die ('Please complete the registration form!');
    }
    // Make sure the submitted registration values are not empty.
    if (empty($_POST['username']) || empty($_POST['password1']) || empty($_POST['password2']) || empty($_POST['email'])) {
        // One or more values are empty.
        die ('Please complete the registration form');
    }
    
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	die ('Email is not valid!');
    }
    
    if (preg_match('/[A-Za-z0-9]+/', $_POST['username']) == 0) {
    die ('Username is not valid!');
    }
    
    if (strlen($_POST['password1']) > 20 || strlen($_POST['password1']) < 5) {
	die ('Password must be between 5 and 20 characters long!');
    }
    
    // We need to check if the account with that username exists.
    if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
        // Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();
        // Store the result so we can check if the account exists in the database.
        if ($stmt->num_rows > 0) {
            // Username already exists
            echo 'Username exists, please choose another!';
        } else {
            if($_POST['password1'] != $_POST['password2']) {
                echo 'The two passwords do not match!';
            } else {
                // Username doesnt exists, insert new account
                if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, activation_code) VALUES (?, ?, ?, ?)')) {
                    // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
                    $password = password_hash($_POST['password1'], PASSWORD_DEFAULT);
                    $uniqid = uniqid();
                    $stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $uniqid);

                    $stmt->execute();
                    $from    = 'noreply@yourdomain.com';
                    $subject = 'Account Activation Required';
                    $headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
                    $activate_link = 'http://yourdomain.com/phplogin/activate.php?email=' . $_POST['email'] . '&code=' . $uniqid;
                    $message = '<p>Please click the following link to activate your account: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';
                    mail($_POST['email'], $subject, $message, $headers);
                    echo 'Please check your email to activate your account!';
                } else {
                    // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
                    echo 'Could not prepare statement!';
                }
            }
            
        }
        $stmt->close();
    } else {
        // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
        echo 'Could not prepare statement!';
    }
    $con->close();
    
}
?>


<?php

if (isset($_SESSION['loggedin'])) {
		echo "<script type='text/javascript'>window.top.location='index.php';</script>"; exit;
	exit();
}



?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>sApp - Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
  <div class="container">
    <br>
    <br>
    <br>
    <center>
      <h1 class="h4 text-gray-900 mb-4">Online Outlet Management System</h1>
    </center>

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block style="position: relative;  overflow: hidden;"><img src="img/login.jpg" width="100%" alt="LOGIN" style="position: absolute;top: -9999px;  left: -9999px;  right: -9999px;  bottom: -9999px;  margin: auto;">
              </div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
              </div>
              <form class="user" action="register.php" method="post" autocomplete="off">
                <div class="form-group">
                  
                    <input type="text" class="form-control form-control-user" id="exampleFirstName" placeholder="User Name" name="username" required>
                  
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address" name="email" required>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password1" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Repeat Password" name="password2" required>
                  </div>
                </div>
                <button class="btn btn-primary btn-user btn-block" name="Register">Register Account</button>
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="login.php">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

<?php 

include('includes/scripts.php');
include('includes/footer.php');


?>