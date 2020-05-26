<?php
function pdo_connect_mysql()
{
	include 'cred_account.php';
	try {
		return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
	} catch (PDOException $exception) {
		// If there is an error with the connection, stop the script and display the error.
		die('Failed to connect to database!');
	}
}
function template_header($title)
{
	echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
EOT;
}
function template_footer()
{
	echo <<<EOT
    </body>
</html>
EOT;
}

function LoadBranch($connect)
{
	$query = "
		SELECT * FROM Branch
	";

	$statement = $connect->prepare($query);

	$statement->execute();

	$result = $statement->fetchAll();

	$output = '';

	foreach ($result as $row) {
		$output .= '<option value="' . $row["id"] . '">' . $row["Branch_Name"] ." (" . $row["Address"] . ")" . '</option>';
	}

	return $output;
}
function fill_pan_no($connect, $id)
{
   $query = "
  SELECT * FROM accounts_info 
  WHERE id = '" . $id . "'
 ";

   $statement = $connect->prepare($query);

   $statement->execute();

   $result = $statement->fetchAll();

   $total_rows = $statement->rowCount();

   $output = '';

   foreach ($result as $row) {
      $output .= '<input type="number" name="Customers_PAN_no" id="Customerspanno" class="form-control" value="' . $row["PAN_No"] . '" readonly/>';
      //$output.= '<input type="text" value="'.$row["Rate"].'" placeholder="Rate" readonly class="form-control item_name">';
   }

   return $output;
}
function fill_pan_no_purchase($connect, $id)
{
   $query = "
  SELECT * FROM accounts_info 
  WHERE id = '" . $id . "'
 ";

   $statement = $connect->prepare($query);

   $statement->execute();

   $result = $statement->fetchAll();

   $total_rows = $statement->rowCount();

   $output = '';

   foreach ($result as $row) {
      $output .= '<input type="number" name="Sellers_PAN_no" id="Customerspanno" class="form-control" value="' . $row["PAN_No"] . '" readonly/>';
      //$output.= '<input type="text" value="'.$row["Rate"].'" placeholder="Rate" readonly class="form-control item_name">';
   }

   return $output;
}