<?php

include('database_connection.php');
include('functions.php');

$statement = $connect->prepare("
SELECT * FROM accounts_info
");

$statement->execute();

$all_result = $statement->fetchAll();

$total_rows = $statement->rowCount();

if (isset($_POST["Add"])) {
    $statement = $connect->prepare("
    INSERT INTO accounts_info
    (Name, Address, Phone, PAN_No, Account_type) 
    VALUES (:Name, :Address, :Phone, :PAN_No, :Account_type);
");
    $statement->execute(
        array(
            ':Name'               =>  trim($_POST["Name"]),
            ':Address'             =>  trim($_POST["Address"]),
            ':Phone'                 =>  trim($_POST["Phone"]),
            ':PAN_No'                 =>  trim($_POST["PAN_No"]),
            ':Account_type'               =>  trim($_POST["Account_type"])
        )
    );
    echo "Values added sucessfully";
    header("location:Accounts.php");
}
if (isset($_GET["update"])) {
    if (isset($_POST["Update"])) {
        $id = $_GET["id"];
        $statement = $connect->prepare("
            UPDATE accounts_info
            SET Name= :Name,
            Address= :Address,
            Phone= :Phone,
            Account_type= :Account_type
            WHERE id = :id
            ");
        $statement->execute(
            array(
                ':id'                   => $id,
                ':Name'               =>  trim($_POST["Name"]),
                ':Address'             =>  trim($_POST["Address"]),
                ':Phone'             =>  trim($_POST["Phone"]),
                ':Account_type'               =>  trim($_POST["Account_type"])
            )
        );
        echo "Values updated sucessfully!";
        header("location:Accounts.php");
    }
}
if (isset($_GET["delete"]) && isset($_GET["id"])) {
    $statement = $connect->prepare("DELETE FROM accounts_info WHERE id = :id");
    $statement->execute(
        array(
            ':id'       =>      $_GET["id"]
        )
    );
    $statement = $connect->prepare(
        "DELETE FROM Details WHERE Customer_id = :id"
    );
    $statement->execute(
        array(
            ':id'       =>      $_GET["id"]
        )
    );
    header("location:Accounts.php");
}

?>
<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Accounts</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" rel="stylesheet">

    <?php include_once 'includes/head-links.php'; ?>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        /* Remove the navbar's default margin-bottom and rounded borders */
        .navbar {
            margin-bottom: 4px;
            border-radius: 0;
        }

        /* Add a gray background color and some padding to the footer */
        footer {
            background-color: #f2f2f2;
            padding: 25px;
        }

        .carousel-inner img {
            width: 100%;
            /* Set width to 100% */
            margin: auto;
            min-height: 200px;
        }

        .navbar-brand {
            padding: 5px 40px;
        }

        .navbar-brand:hover {
            background-color: #ffffff;
        }

        /* Hide the carousel text when the screen is less than 600 pixels wide */
        @media (max-width: 600px) {
            .carousel-caption {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include("includes/sidebar.php"); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include("includes/topbar.php"); ?>

                <div class="container-fluid">
                    <?php
                    if (isset($_GET["add"])) {
                    ?>

                        <div class="page-header">
                            <h2>Add Account</h2>
                        </div>
                        <p>Please fill this form and submit to add Customer record to the database.</p>
                        <form id="invoice_form" method="post">
                            <label>Name</label>
                            <input type="text" name="Name" id="Name" class="form-control" required>

                            <label>Address</label>
                            <input type="text" name="Address" id="Address" class="form-control">

                            <label>Phone No</label>
                            <input type="number" name="Phone" id="Phone" class="form-control">

                            <label>PAN No</label>
                            <input type="number" name="PAN_No" id="PAN_No" class="form-control" required>

                            <label>Account Type</label>
                            <select name="Account_type" id="Account_type" class="form-control" required>
                                <option value="Customer">Customer</option>
                                <option value="Vendor">Vendor</option>
                            </select>

                            <br>
                            <input type="submit" name="Add" id="Add" value="Add" class="btn btn-primary">
                            <a href="Accounts.php" class="btn btn-default">Cancel</a>
                        </form>
                        <script>
                            $(document).ready(function() {
                                $('#Add').click(function() {
                                    $('#invoice_form').submit();
                                });

                            });
                        </script>
                        <?php
                    } elseif (isset($_GET["update"]) && isset($_GET["id"])) {
                        $statement = $connect->prepare("
                        SELECT * FROM accounts_info  
                            WHERE id = :id
                            LIMIT 1
                        ");
                        $statement->execute(
                            array(
                                ':id'       =>  $_GET["id"]
                            )
                        );
                        $result = $statement->fetchAll();
                        foreach ($result as $row) {
                        ?>
                            <div class="page-header">
                                <h2>UpDate Account</h2>
                            </div>
                            <p>Please fill this form and submit to add Customer record to the database.</p>
                            <form method="post" id="invoice_form">
                                <label>Name</label>
                                <input type="text" name="Name" id="Name" class="form-control" value="<?php echo $row["Name"]; ?>">

                                <label>Address</label>
                                <input type="text" name="Address" id="Address" class="form-control" value="<?php echo $row["Address"]; ?>">

                                <label>Phone No</label>
                                <input type="number" name="Phone" id="Phone" class="form-control" value="<?php echo $row["Phone"]; ?>">

                                <label>Account Type</label>
                                <select name="Account_type" id="Account_type" class="form-control" value="<?php echo $row["Account_type"]; ?>">
                                    <option value="<?php echo $row["Account_type"]; ?> selected"><?php echo $row["Account_type"]; ?></option>
                                    <hr>
                                    <option value="Customer">Customer</option>
                                    <option value="Vendor">Vendor</option>
                                    <option value="Cash">Cash A/C</option>
                                </select>

                                <br>
                                <input type="submit" name="Update" id="Update" value="Update" class="btn btn-primary">
                                <a href="Accounts.php" class="btn btn-default">Cancel</a>
                            </form>
                            <script>
                                $(document).ready(function() {
                                    $('#Update').click(function() {
                                        $('#invoice_form').submit();
                                    });
                                });
                            </script>
                        <?php
                        }
                    } else {
                        ?>
                        <div class="page-header clearfix">
                            <h2 class="pull-left">Account's List</h2>
                            <a href="Accounts.php?add=1" class="btn btn-success pull-right">Add New Account</a><br><br>
                        </div>
                        <div id="Ratelist" class="table-responsive">
                            <table id="data-table" class='table table-bordered table-striped'>
                                <thead>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Phone No</th>
                                    <th>PAN No</th>
                                    <th>Account Type</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($total_rows > 0) {
                                        $TotalCredit = 0;
                                        $TotalCheque = 0;
                                        foreach ($all_result as $row) {
                                            echo '
                                            <tr>
                                                <td>' . $row["id"] . '</td>
                                                <td><a href="Ledger.php?account=1&id=' . $row["id"] . '">' . $row["Name"] . '</a></td>
                                                <td>' . $row["Address"] . '</td>
                                                <td>' . $row["Phone"] . '</td>
                                                <td>' . $row["PAN_No"] . '</td>
                                                <td>' . $row["Account_type"] . '</td>
                                                <td><a href="Accounts.php?update=1&id=' . $row["id"] . '">Edit</a></td>
                                                <td><a href="Accounts.php?delete=1&id=' . $row["id"] . '">Delete</a></td>
                                            </tr>
                                            ';
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php include("includes/footer.php"); ?>
        </div>
    </div>
</body>

</html>
<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').DataTable();
    });
</script>
<!-- Bootstrap core JavaScript-->
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>