<?php
include('functions.php');
include('database_connection.php');

$statement = $connect->prepare("
SELECT * FROM accounts_info
    ");

$statement->execute();

$all_result = $statement->fetchAll();

$total_rows = $statement->rowCount();

if (isset($_POST["View"])) {
    $id_name = $_POST["Name"];
    header("location:Ledger.php?account=1&id=$id_name");
}

?>
<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ledger Details</title>
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
                    if (isset($_GET["account"]) && isset($_GET["id"])) {
                        $id = $_GET["id"];
                        if (isset($_POST['filter'])) {
                            $statement = $connect->prepare("
                            SELECT * FROM accounts_details
                            WHERE Account_id = :Account_id
                            AND Date Between :startDate AND :endDate order by Date;
                            ");

                            $statement->execute(
                                array(
                                    ':Account_id' => $id,
                                    ':startDate' => trim($_POST["startDate"]),
                                    ':endDate' => trim($_POST["endDate"])
                                )
                            );
                            $result = $statement->fetchAll();

                            $rows = $statement->rowCount();
                            $statement = $connect->prepare("
                            SELECT * FROM accounts_info
                            WHERE id = :Account_id;
                            ");

                            $statement->execute(
                                array(
                                    ':Account_id' => $id
                                )
                            );
                            $acount_details = $statement->fetch();
                        } else {
                            $statement = $connect->prepare("
                            SELECT * FROM accounts_details
                            WHERE Account_id = :Account_id;
                            ");

                            $statement->execute(
                                array(
                                    ':Account_id' => $id
                                )
                            );
                            echo $StartDate . "<br>" . $EndDate;
                            $result = $statement->fetchAll();

                            $rows = $statement->rowCount();
                            $statement = $connect->prepare("
                            SELECT * FROM accounts_info
                            WHERE id = :Account_id;
                            ");

                            $statement->execute(
                                array(
                                    ':Account_id' => $id
                                )
                            );
                            $acount_details = $statement->fetch();
                        }
                    ?>
                        <center>
                            <div class="page-header">
                                <h2>Ledger Details</h2>
                            </div>
                            <hr>
                            <div class="page-header">
                                <h2><?php echo $acount_details["Name"]; ?></h2>
                            </div>
                            <p>Address: <?php echo $acount_details["Address"]; ?></p>
                            <p>Phone No: <?php echo $acount_details["Phone"]; ?></p>
                            <hr>
                            <br>
                        </center>


                        <div class="table-responsive">
                            <form method="post" id="filter_form">
                                <table>
                                    <tr>
                                        <td>
                                            Start Date:
                                        </td>
                                        <td>
                                            <input type="date" name="startDate" id="StartDate" class="form-control" required>
                                        </td>
                                        <td>
                                            End Date:
                                        </td>
                                        <td>
                                            <input type="date" name="endDate" id="EndDate" class="form-control" required>
                                        </td>
                                        <td>
                                            <input type="submit" name="filter" id="filter" value="Filter" class="btn btn-primary filter">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            <br>
                            <script>
                                $(document).ready(function() {
                                    $('#Add').click(function() {
                                        alert('Cheque updated sucessfully!');
                                        $('#filter_form').submit();
                                    });

                                });
                            </script>
                            <table id="data-table" class='table table-bordered table-striped'>
                                <thead>
                                    <th>Date</th>
                                    <th>Account Description</th>
                                    <th>Dr Amount</th>
                                    <th>Cr Amount</th>
                                    <th>Balance</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_cr = 0;
                                    $total_dr = 0;
                                    $total_balance = 0;
                                    if ($rows > 0) {
                                        foreach ($result as $data) {
                                            $total_cr = $total_cr + $data["Cr"];
                                            $total_dr = $total_dr + $data["Dr"];
                                            $total_balance = $total_balance + $data["Dr"] - $data["Cr"];
                                            if ($total_balance < 0) {
                                                $view_balance = -$total_balance . " Cr";
                                            } elseif ($total_balance > 0) {
                                                $view_balance = $total_balance . " Dr";
                                            }else{
                                                $view_balance = "Nill";
                                            }

                                            echo '
                                            <tr>
                                                <td>' . $data["Date"] . '</td>
                                                <td>' . $data["Description"] . '</td>
                                                <td>' . $data["Dr"] . '</td>
                                                <td>' . $data["Cr"] . '</td>
                                                <td>' . $view_balance . '</td>
                                            </tr>
                                            ';
                                        }
                                    }
                                    ?>
                                </tbody>
                                <tr>
                                    <td colspan="2"><b>Total</b></td>
                                    <td><b><?php echo $total_dr; ?><b</td> <td><b><?php echo $total_cr; ?></b></td>
                                    <td><b><?php echo $view_balance; ?></b></td>
                                </tr>
                            </table>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="page-header clearfix">
                            <h2 class="pull-left">Select Account</h2>
                        </div>
                        <form method="post" id="Ledger_form">
                            <table>
                                <tr>
                                    <td colspan="2">
                                        <label for="Account">Select an account from the dropdown list below.</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="AccountName">Account Name</label>
                                    </td>
                                    <td>
                                        <select name="Name" id="Name" class="form-control">
                                            <?php
                                            if ($total_rows > 0) {
                                                foreach ($all_result as $row) {
                                                    echo '
                                            <option value="' . $row["id"] . '" class="form-control">' . $row["Name"] . '</option>
                                            ';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <br>
                                        <input type="Submit" id="View" name="View" value="View Ledger" class="btn btn-primary">
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <script>
                            $(document).ready(function() {
                                $('#View').click(function() {
                                    $('#Ledger_form').submit();
                                });
                            });
                        </script>
                    <?php
                    }
                    ?>
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
        $('#StartDate').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });
        $('#EndDate').datepicker({
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