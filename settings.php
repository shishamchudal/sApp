<?php
include 'includes/header.php';
include('functions.php');
include('database_connection.php');
if ($_SESSION["User_type"] == "Admin") {

    $statement = $connect->prepare("
        SELECT * FROM `accounts`
    ");

    $statement->execute();

    $all_result = $statement->fetchAll();

    $total_rows = $statement->rowCount();

    $name = $_SESSION['name'];
    
    if (isset($_GET["update"])) {
        if (isset($_POST["Update"])) {
            $id = $_GET["id"];
            $statement = $connect->prepare("
                UPDATE
                    `accounts`
                SET
                    `User_type` = :User_type
                WHERE
                    `id` = :id
            ");
            $statement->execute(
                array(
                    ':User_type'               =>  trim($_POST["User_type"]),
                    ':id'             =>  trim($id)
                )
            );
            echo "Values updated sucessfully!";
            header("location:settings.php");
        }
    }
} else {
    echo '
        <script>
            alert("😡😡You are not allowed to view this page😡😡!");
            window.top.location="index.php";
        </script>
    ';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sales's List</title>
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>


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
                    if (isset($_GET["update"]) && isset($_GET["id"])) {
                        $statement = $connect->prepare("
                        SELECT * FROM accounts  
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
                                <h2>UpDate Sales</h2>
                            </div>
                            <p>Please fill this form and submit to UpDate Sales record to the database.</p>
                            <form id="Cheque_form" method="post">
                                <table id="data-table" class='table table-bordered table-striped'>
                                    <tr>
                                        <th>
                                            <label for="name">Name</label>
                                        </th>
                                        <td>
                                            <input type="text" name="Name" required class="form-control Name" value="<?php echo $row["username"]; ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <label for="name">User Type</label>
                                        </th>
                                        <td>
                                            <select name="User_type" id="User_type" required class="form-control">
                                                <option value="Admin">Admin</option>
                                                <option value="Standard">Standard</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input type="submit" id="Update" class="btn btn-primary" value="Update" name="Update">
                                            <a href="settings.php" class="btn btn-default">Cancel</a>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            <script>
                                $(document).ready(function() {

                                    $('#Update').click(function() {

                                        $('#Cheque_form').submit();
                                        alert('Record Updated sucessfully!');
                                    });

                                });
                            </script>
                        <?php
                        }
                    } else {
                        ?>
                        <div class="page-header clearfix">
                            <h2 class="pull-left">Settings</h2>
                        </div>
                        <div id="Ratelist" class="table-responsive">
                            <table id="data-table" class='table table-bordered table-striped'>
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Name</td>
                                        <td>User Type</td>
                                        <td>Edit</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($total_rows > 0) {
                                        $sum = 0;
                                        foreach ($all_result as $row) {
                                            $sum = $sum + $row["Total_sales_amount"];
                                            echo '
                                            <tr>
                                                <td>' . $row["id"] . '</td>
                                                <td>' . $row['username'] . '</td>
                                                <td>' . $row['User_type'] . '</td>
                                                <td><a href="settings.php?update=1&id=' . $row["id"] . '">Edit</a></td>
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
        $('#Name').chosen();
        $('#data-table').DataTable();
        $('#date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });
    });
</script>
<!-- Bootstrap core JavaScript-->
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>