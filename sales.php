<?php
include 'includes/header.php';
include('functions.php');
include('database_connection.php');
if ($_SESSION["User_type"] == "Admin") {
    $statement = $connect->prepare("
    SELECT
    Sales_Ledger.id,
    Sales_Ledger.Date,
    Sales_Ledger.Bill_no,
    Sales_Ledger.Customers_name,
    Sales_Ledger.Customers_PAN_no,
    Sales_Ledger.Total_sales_amount,
    Sales_Ledger.VAT_included_sales_amount,
    Sales_Ledger.VAT_included_sales_VAT,
    Branch.Name,
    Branch.Address
    FROM
    Sales_Ledger
    JOIN Branch ON Sales_Ledger.Branch = Branch.id
        order by Date
    ");

    $statement->execute();

    $all_result = $statement->fetchAll();

    $total_rows = $statement->rowCount();

    if (isset($_POST['filter'])) {
        if (!empty(trim($_POST["startDate"]) && trim($_POST["endDate"]) && trim($_POST["Branch_Name"]))) {
            $statement = $connect->prepare("
            SELECT
            Sales_Ledger.id,
            Sales_Ledger.Date,
            Sales_Ledger.Bill_no,
            Sales_Ledger.Customers_name,
            Sales_Ledger.Customers_PAN_no,
            Sales_Ledger.Total_sales_amount,
            Sales_Ledger.VAT_included_sales_amount,
            Sales_Ledger.VAT_included_sales_VAT,
            Branch.Name,
            Branch.Address
            FROM
            Sales_Ledger
            JOIN Branch ON Sales_Ledger.Branch = Branch.id
            WHERE Date Between :startDate AND :endDate
            AND Branch = :Branch order by Date;
            ");

            $statement->execute(
                array(
                    ':startDate' => trim($_POST["startDate"]),
                    ':endDate' => trim($_POST["endDate"]),
                    ':Branch' => trim($_POST["Branch_Name"])
                )
            );
            $all_result = $statement->fetchAll();

            $total_rows = $statement->rowCount();
        } elseif (!empty(trim($_POST["Branch_Name"]))) {
            $statement = $connect->prepare("
            SELECT
            Sales_Ledger.id,
            Sales_Ledger.Date,
            Sales_Ledger.Bill_no,
            Sales_Ledger.Customers_name,
            Sales_Ledger.Customers_PAN_no,
            Sales_Ledger.Total_sales_amount,
            Sales_Ledger.VAT_included_sales_amount,
            Sales_Ledger.VAT_included_sales_VAT,
            Branch.Name,
            Branch.Address
            FROM
            Sales_Ledger
            JOIN Branch ON Sales_Ledger.Branch = Branch.id
            WHERE Branch = :Branch order by Date;
            ");

            $statement->execute(
                array(
                    ':Branch' => trim($_POST["Branch_Name"])
                )
            );
            $all_result = $statement->fetchAll();

            $total_rows = $statement->rowCount();
        } elseif (!empty(trim($_POST["startDate"])) && trim($_POST["endDate"])) {
            $statement = $connect->prepare("
            SELECT
            Sales_Ledger.id,
            Sales_Ledger.Date,
            Sales_Ledger.Bill_no,
            Sales_Ledger.Customers_name,
            Sales_Ledger.Customers_PAN_no,
            Sales_Ledger.Total_sales_amount,
            Sales_Ledger.VAT_included_sales_amount,
            Sales_Ledger.VAT_included_sales_VAT,
            Branch.Name,
            Branch.Address
            FROM
            Sales_Ledger
            JOIN Branch ON Sales_Ledger.Branch = Branch.id
            WHERE Date Between :startDate AND :endDate order by Date;
            ");

            $statement->execute(
                array(
                    ':startDate' => trim($_POST["startDate"]),
                    ':endDate' => trim($_POST["endDate"])
                )
            );
            $all_result = $statement->fetchAll();

            $total_rows = $statement->rowCount();
        }
    }

    $name = $_SESSION['name'];
    if (isset($_POST["Add"])) {
        try {
            echo
                "<hr> Date: " . trim($_POST["Date"]) .
                    "<br> Bill_no: " . trim($_POST["Bill_no"]) .
                    "<br> Customers_name: " . trim($_POST["Customers_name"]) .
                    "<br> Customers_PAN_no: " . trim($_POST["Customers_PAN_no"]) .
                    "<br> Total_sales_amount: " . trim($_POST["Total_sales_amount"]) .
                    "<br> VAT_included_sales_amount: " . trim($_POST["VAT_included_sales_amount"]) .
                    "<br> VAT_included_sales_VAT: " . trim($_POST["VAT_included_sales_VAT"]) .
                    "<br> Branch: " . trim($_POST["Branch"]) .
                    "<hr>";
            $statement = $connect->prepare("
        INSERT INTO `Sales_Ledger`(
            `Date`,
            `Bill_no`,
            `Customers_name`,
            `Customers_PAN_no`,
            `Total_sales_amount`,
            `VAT_included_sales_amount`,
            `VAT_included_sales_VAT`,
            `Branch`
        )
        VALUES(
            :Date,
            :Bill_no,
            :Customers_name,
            :Customers_PAN_no,
            :Total_sales_amount,
            :VAT_included_sales_amount,
            :VAT_included_sales_VAT,
            :Branch
        );
        ");
            $statement->execute(
                array(
                    ':Date'               =>  trim($_POST["Date"]),
                    ':Bill_no'             =>  trim($_POST["Bill_no"]),
                    ':Customers_name'             =>  trim($_POST["Customers_name"]),
                    ':Customers_PAN_no'             =>  trim($_POST["Customers_PAN_no"]),
                    ':Total_sales_amount'             =>  trim($_POST["Total_sales_amount"]),
                    ':VAT_included_sales_amount'             =>  trim($_POST["VAT_included_sales_amount"]),
                    ':VAT_included_sales_VAT'             =>  trim($_POST["VAT_included_sales_VAT"]),
                    ':Branch'             =>  trim($_POST["Branch"])
                )
            );
            echo "Added Sucessfully";
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        echo "<script type='text/javascript'>window.top.location='sales.php';</script>";
        exit;
    }
    if (isset($_GET["update"])) {
        if (isset($_POST["Update"])) {
            $id = $_GET["id"];
            $statement = $connect->prepare("
            UPDATE `Sales_Ledger` 
            SET `Date` = :Date,
            `Bill_no` = :Bill_no,
            `Customers_name` = :Customers_name,
            `Customers_PAN_no` = :Customers_PAN_no,
            `Total_sales_amount` = :Total_sales_amount,
            `VAT_included_sales_amount` = :VAT_included_sales_amount,
            `VAT_included_sales_VAT` = :VAT_included_sales_VAT
            WHERE id = :id;
            ");
            $statement->execute(
                array(
                    ':id'                   => $id,
                    ':Date'               =>  trim($_POST["Date"]),
                    ':Bill_no'             =>  trim($_POST["Bill_no"]),
                    ':Customers_name'             =>  trim($_POST["Customers_name"]),
                    ':Customers_PAN_no'             =>  trim($_POST["Customers_PAN_no"]),
                    ':Total_sales_amount'             =>  trim($_POST["Total_sales_amount"]),
                    ':VAT_included_sales_amount'             =>  trim($_POST["VAT_included_sales_amount"]),
                    ':VAT_included_sales_VAT'             =>  trim($_POST["VAT_included_sales_VAT"])
                )
            );
            echo "Values updated sucessfully!";
            echo "<script type='text/javascript'>window.top.location='sales.php';</script>";
            exit;
        }
    }
    if (isset($_GET["delete"]) && isset($_GET["id"])) {
        $statement = $connect->prepare(
            "DELETE FROM Sales_Ledger WHERE id = :id"
        );
        $statement->execute(
            array(
                ':id'       =>      $_GET["id"]
            )
        );
        echo "<script type='text/javascript'>window.top.location='sales.php';</script>";
        exit;
    }
} else {
    $Branch = $_SESSION['Linked_branch'];
    $statement = $connect->prepare("
    SELECT
    Sales_Ledger.id,
    Sales_Ledger.Date,
    Sales_Ledger.Bill_no,
    Sales_Ledger.Customers_name,
    Sales_Ledger.Customers_PAN_no,
    Sales_Ledger.Total_sales_amount,
    Sales_Ledger.VAT_included_sales_amount,
    Sales_Ledger.VAT_included_sales_VAT,
    Branch.Name,
    Branch.Address
    FROM
    Sales_Ledger
    JOIN Branch ON Sales_Ledger.Branch = Branch.id
    WHERE Sales_Ledger.Branch = :Branch
        order by Date
    ");

    $statement->execute(
        array(
            ':Branch'   => $Branch
        )
    );

    $all_result = $statement->fetchAll();

    $total_rows = $statement->rowCount();

    if (isset($_POST['filter'])) {
        $statement = $connect->prepare("
    SELECT
    Sales_Ledger.id,
    Sales_Ledger.Date,
    Sales_Ledger.Bill_no,
    Sales_Ledger.Customers_name,
    Sales_Ledger.Customers_PAN_no,
    Sales_Ledger.Total_sales_amount,
    Sales_Ledger.VAT_included_sales_amount,
    Sales_Ledger.VAT_included_sales_VAT,
    Branch.Name,
    Branch.Address
    FROM
    Sales_Ledger
    JOIN Branch ON Sales_Ledger.Branch = Branch.id
    WHERE Date Between :startDate AND :endDate 
    AND Sales_Ledger.Branch = :Branch
    order by Date;
    ");

        $statement->execute(
            array(
                ':startDate' => trim($_POST["startDate"]),
                ':endDate' => trim($_POST["endDate"]),
                ':Branch'   => $Branch
            )
        );
        $all_result = $statement->fetchAll();

        $total_rows = $statement->rowCount();
    }

    $name = $_SESSION['name'];
    if (isset($_POST["Add"])) {
        try {
            echo
                "<hr> Date: " . trim($_POST["Date"]) .
                    "<br> Bill_no: " . trim($_POST["Bill_no"]) .
                    "<br> Customers_name: " . trim($_POST["Customers_name"]) .
                    "<br> Customers_PAN_no: " . trim($_POST["Customers_PAN_no"]) .
                    "<br> Total_sales_amount: " . trim($_POST["Total_sales_amount"]) .
                    "<br> VAT_included_sales_amount: " . trim($_POST["VAT_included_sales_amount"]) .
                    "<br> VAT_included_sales_VAT: " . trim($_POST["VAT_included_sales_VAT"]) .
                    "<br> Branch: " . trim($_POST["Branch"]) .
                    "<hr>";
            $statement = $connect->prepare("
        INSERT INTO `Sales_Ledger`(
            `Date`,
            `Bill_no`,
            `Customers_name`,
            `Customers_PAN_no`,
            `Total_sales_amount`,
            `VAT_included_sales_amount`,
            `VAT_included_sales_VAT`,
            `Branch`
        )
        VALUES(
            :Date,
            :Bill_no,
            :Customers_name,
            :Customers_PAN_no,
            :Total_sales_amount,
            :VAT_included_sales_amount,
            :VAT_included_sales_VAT,
            :Branch
        );
        ");
            $statement->execute(
                array(
                    ':Date'               =>  trim($_POST["Date"]),
                    ':Bill_no'             =>  trim($_POST["Bill_no"]),
                    ':Customers_name'             =>  trim($_POST["Customers_name"]),
                    ':Customers_PAN_no'             =>  trim($_POST["Customers_PAN_no"]),
                    ':Total_sales_amount'             =>  trim($_POST["Total_sales_amount"]),
                    ':VAT_included_sales_amount'             =>  trim($_POST["VAT_included_sales_amount"]),
                    ':VAT_included_sales_VAT'             =>  trim($_POST["VAT_included_sales_VAT"]),
                    ':Branch'             =>  trim($_POST["Branch"])
                )
            );
            echo "Added Sucessfully";
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        echo "<script type='text/javascript'>window.top.location='sales.php';</script>";
        exit;
    }
    if (isset($_GET["update"])) {
        if (isset($_POST["Update"])) {
            $id = $_GET["id"];
            $statement = $connect->prepare("
            UPDATE `Sales_Ledger` 
            SET `Date` = :Date,
            `Bill_no` = :Bill_no,
            `Customers_name` = :Customers_name,
            `Customers_PAN_no` = :Customers_PAN_no,
            `Total_sales_amount` = :Total_sales_amount,
            `VAT_included_sales_amount` = :VAT_included_sales_amount,
            `VAT_included_sales_VAT` = :VAT_included_sales_VAT
            WHERE id = :id;
            ");
            $statement->execute(
                array(
                    ':id'                   => $id,
                    ':Date'               =>  trim($_POST["Date"]),
                    ':Bill_no'             =>  trim($_POST["Bill_no"]),
                    ':Customers_name'             =>  trim($_POST["Customers_name"]),
                    ':Customers_PAN_no'             =>  trim($_POST["Customers_PAN_no"]),
                    ':Total_sales_amount'             =>  trim($_POST["Total_sales_amount"]),
                    ':VAT_included_sales_amount'             =>  trim($_POST["VAT_included_sales_amount"]),
                    ':VAT_included_sales_VAT'             =>  trim($_POST["VAT_included_sales_VAT"])
                )
            );
            echo "Values updated sucessfully!";
            echo "<script type='text/javascript'>window.top.location='sales.php';</script>";
            exit;
        }
    }
    if (isset($_GET["delete"]) && isset($_GET["id"])) {
        $statement = $connect->prepare("
                        SELECT * FROM Sales_Ledger  
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

            if ($_SESSION["User_type"] == "Admin" or $row["Branch"] == $Branch) {
                $statement = $connect->prepare(
                    "DELETE FROM Sales_Ledger WHERE id = :id"
                );
                $statement->execute(
                    array(
                        ':id'       =>      $_GET["id"]
                    )
                );
                echo "<script type='text/javascript'>window.top.location='sales.php';</script>";
                exit;
            } else {
?>
                <script>
                    alert("You are not allowed to delete itЁЯШб!");
                    window.top.location = 'sales.php';
                </script>
<?php
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sale's Register (बिक्री खाता)</title>

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
                    if (isset($_GET["add"])) {
                    ?>

                        <div class="page-header">
                            <h2>Add Sales's Record (बिक्री खाता)</h2>
                        </div>
                        <p>Please fill this form and submit to add Sales record to the database.!</p>
                        <form id="Cheque_form" method="post">
                            <table id="data-table" class='table table-bordered table-striped'>
                                <tr>
                                    <th>
                                        <label for="name">Date</label>
                                    </th>
                                    <td>
                                        <input type="date" name="Date" id="date" required class="form-control" tabindex="1">
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="panno">Invoice No</label>
                                    </th>
                                    <td>
                                        <input type="number" name="Bill_no" id="billno" class="form-control" tabindex="2" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="phone">Customer's Name</label>
                                    </th>
                                    <td>
                                        <input type="text" name="Customers_name" id="Customersname" required class="form-control" tabindex="3">
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="phone">Customer's PAN No</label>
                                    </th>
                                    <td>
                                        <input type="number" name="Customers_PAN_no" id="Customerspanno" required class="form-control" tabindex="4">
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="phone">Total Sales Amount</label>
                                    </th>
                                    <td>
                                        <input type="number" name="Total_sales_amount" id="totalsalesamount" required class="form-control" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="phone">Sales Amount</label>
                                    </th>
                                    <td>
                                        <input type="number" name="VAT_included_sales_amount" id="sales_amount" required class="form-control sales_amount" tabindex="5">
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="phone">VAT Amount</label>
                                    </th>
                                    <td>
                                        <input type="number" name="VAT_included_sales_VAT" id="vat_amount" required class="form-control vat_amount" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="phone">Branch</label>
                                    </th>
                                    <td>
                                        <select name="Branch" id="Branch" required class="form-control Branch" tabindex="6">
                                            <option>Select Branch</option>
                                            <?php echo LoadBranch($connect); ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <input type="submit" id="Add" class="btn btn-primary" value="Add" name="Add">
                                        <a href="sales.php" class="btn btn-default">Cancel</a>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <script>
                            $(document).ready(function() {
                                $('#date').datepicker({
                                    format: "yyyy-mm-dd",
                                    autoclose: true
                                });

                                function calc_vat_amt() {
                                    var sales_amount = $("#sales_amount").val();
                                    var vat_amount = (13 / 100) * sales_amount;
                                    $('#vat_amount').val(vat_amount);
                                    var total_amount = parseFloat(sales_amount) + parseFloat(vat_amount);
                                    $('#totalsalesamount').val(total_amount)
                                }
                                $(document).on('blur', '#sales_amount', function() {
                                    calc_vat_amt();
                                });
                                $('#Add').click(function() {
                                    if ($.trim($('#date').val()).length == 0) {
                                        alert("Please Enter Date");
                                        return false;
                                    }
                                    if ($.trim($('#billno').val()).length == 0) {
                                        alert("Please Enter Invoice No");
                                        return false;
                                    }
                                    if ($.trim($('#Customersname').val()).length == 0) {
                                        alert("Please Enter Customers name");
                                        return false;
                                    }
                                    if ($.trim($('#Customerspanno').val()).length == 0) {
                                        alert("Please Enter Customers pan no");
                                        return false;
                                    }

                                    if ($.trim($('#sales_amount').val()).length == 0) {
                                        alert("Please Enter Sales amount");
                                        return false;
                                    }
                                    if ($.trim($('#Branch').val()).length == 0) {
                                        alert("Please Select Branch");
                                        return false;
                                    }
                                    $('#Cheque_form').submit();
                                    alert('Record added sucessfully!');
                                });

                            });
                        </script>
                        <?php
                    } elseif (isset($_GET["update"]) && isset($_GET["id"])) {
                        $statement = $connect->prepare("
                        SELECT * FROM Sales_Ledger  
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
                            if ($_SESSION["User_type"] == "Admin" or $row["Branch"] == $Branch) {
                        ?>
                                <div class="page-header">
                                    <h2>Update Sales Record (बिक्री खाता)</h2>
                                </div>
                                <p>Please fill this form and submit to UpDate Sales record to the database.</p>
                                <form id="Cheque_form" method="post">
                                    <table id="data-table" class='table table-bordered table-striped'>
                                        <tr>
                                            <th>
                                                <label for="name">Date</label>
                                            </th>
                                            <td>
                                                <input type="date" name="Date" id="date" required class="form-control" value="<?php echo $row["Date"]; ?>" tabindex="1">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <label for="panno">Invoice No</label>
                                            </th>
                                            <td>
                                                <input type="number" name="Bill_no" id="billno" class="form-control" value="<?php echo $row["Bill_no"]; ?>" required tabindex="2">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <label for="phone">Customer's Name</label>
                                            </th>
                                            <td>
                                                <input type="text" name="Customers_name" id="Customersname" value="<?php echo $row["Customers_name"]; ?>" required class="form-control" tabindex="3">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <label for="phone">Customer's PAN No</label>
                                            </th>
                                            <td>
                                                <input type="number" name="Customers_PAN_no" id="Customerspanno" value="<?php echo $row["Customers_PAN_no"]; ?>" required class="form-control" tabindex="4">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <label for="phone">Total Sales Amount</label>
                                            </th>
                                            <td>
                                                <input type="number" name="Total_sales_amount" id="totalsalesamount" value="<?php echo $row["Total_sales_amount"]; ?>" required class="form-control" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <label for="phone">Sales Amount</label>
                                            </th>
                                            <td>
                                                <input type="number" name="VAT_included_sales_amount" id="sales_amount" value="<?php echo $row["VAT_included_sales_amount"]; ?>" required class="form-control sales_amount" tabindex="5">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <label for="phone">VAT Amount</label>
                                            </th>
                                            <td>
                                                <input type="number" name="VAT_included_sales_VAT" id="vat_amount" value="<?php echo $row["VAT_included_sales_VAT"]; ?>" required class="form-control vat_amount" readonly>
                                            </td>
                                        </tr>

                                        <td>
                                            <input type="submit" id="Add" class="btn btn-primary" value="Update" name="Update">
                                            <a href="sales.php" class="btn btn-default">Cancel</a>
                                        </td>
                                    </table>
                                </form>
                                <script>
                                    $(document).ready(function() {
                                        $('#date').datepicker({
                                            format: "yyyy-mm-dd",
                                            autoclose: true
                                        });

                                        function calc_vat_amt() {
                                            var sales_amount = $("#sales_amount").val();
                                            var vat_amount = (13 / 100) * sales_amount;
                                            $('#vat_amount').val(vat_amount);
                                            var total_amount = parseFloat(sales_amount) + parseFloat(vat_amount);
                                            $('#totalsalesamount').val(total_amount)
                                        }
                                        $(document).on('blur', '#sales_amount', function() {
                                            calc_vat_amt();
                                        });
                                        $('#Add').click(function() {
                                            if ($.trim($('#date').val()).length == 0) {
                                                alert("Please Enter Date");
                                                return false;
                                            }
                                            if ($.trim($('#billno').val()).length == 0) {
                                                alert("Please Enter Invoice No");
                                                return false;
                                            }
                                            if ($.trim($('#Customersname').val()).length == 0) {
                                                alert("Please Enter Customers name");
                                                return false;
                                            }
                                            if ($.trim($('#Customerspanno').val()).length == 0) {
                                                alert("Please Enter Customers pan no");
                                                return false;
                                            }

                                            if ($.trim($('#sales_amount').val()).length == 0) {
                                                alert("Please Enter Sales amount");
                                                return false;
                                            }
                                            $('#Cheque_form').submit();
                                            alert('Record Updated sucessfully!');
                                        });

                                    });
                                </script>
                            <?php
                            } else {
                            ?>
                                <div class="page-header">
                                    <h2>You are not allowed here!</h2>
                                    <p><a href="sales.php" class="btn btn-danger">Go Back!</a></p>
                                </div>
                        <?php
                            }
                        }
                    } else {
                        ?>
                        <div class="page-header clearfix">
                            <h2 class="pull-left">Sales Register (बिक्री खाता)</h2>
                            <a href="sales.php?add=1" class="btn btn-success pull-right">Add New Record</a><br><br>
                        </div>
                        <form method="post" id="filter_form">
                            <table>
                                <tr>
                                    <td>
                                        Start Date:
                                    </td>
                                    <td>
                                        <input type="date" name="startDate" id="StartDate" class="form-control">
                                    </td>
                                    <td>
                                        End Date:
                                    </td>
                                    <td>
                                        <input type="date" name="endDate" id="EndDate" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <?php
                                    include_once 'header.php';
                                    if ($_SESSION["User_type"] == "Admin") {
                                        $statement = $connect->prepare("
                                        SELECT * FROM Branch
                                    ");

                                        $statement->execute();

                                        $all_result_branch = $statement->fetchAll();

                                        $total_rows_branch = $statement->rowCount();
                                    ?>
                                        <td>
                                            <label for="AccountName">Branch Name</label>
                                        </td>
                                        <td>
                                            <select name="Branch_Name" id="Branch_Name" class="form-control">
                                                <option value="">Select a branch</option>
                                                <?php
                                                if ($total_rows_branch > 0) {
                                                    foreach ($all_result_branch as $row) {
                                                        echo '
                                            <option value="' . $row["id"] . '" class="form-control">' . $row["Name"] . ' (' . $row["Address"] . ')</option>
                                            ';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    <?php
                                    }
                                    ?>
                                    <td>
                                        <input type="submit" name="filter" id="filter" value="Filter" class="btn btn-primary filter">
                                    </td>
                                    <td>
                                        <input type="button" name="print" id="print" value="Print" class="btn btn-danger print" onclick="myFunction()">
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <br>
                        <script>
                            $(document).ready(function() {
                                $('#filter').click(function() {
                                    $('#filter_form').submit();
                                });

                            });
                        </script>
                        <div id="Ratelist" class="table-responsive">
                            <?php
                            $statement = $connect->prepare("
                            SELECT * FROM Branch  
                                WHERE id = :id
                                LIMIT 1
                            ");
                            $statement->execute(
                                array(
                                    ':id'       =>  $_SESSION["Linked_branch"]
                                )
                            );
                            $result = $statement->fetch();
                            ?>
                            <center>
                                <table>
                                    <tr>
                                        <th>
                                            <span>
                                                PAN No:
                                            </span>
                                        </th>
                                        <th>
                                            <input type="text" name="PAN" id="PAN" readonly class="form-control" style="text-align:center; color:blue;" value="<?php echo $result["PAN"]; ?>">
                                        </th>
                                    </tr>
                                </table>
                                <br>
                            </center>
                            <div id="Part1" style="display: none">
                                <div class="page-header clearfix">
                                    <center>
                                        <h2 class="pull-left">Sales Register (बिक्री खाता)</h2>
                                    </center>
                                </div><br>
                                <center>
                                    <table>
                                        <tr>
                                            <th>
                                                <span>
                                                    PAN No:
                                                </span>
                                            </th>
                                            <th>
                                                <input type="text" name="PAN" id="PAN" readonly class="form-control" style="text-align:center; color:blue;" value="<?php echo $result["PAN"]; ?>">
                                            </th>
                                        </tr>
                                    </table>
                                    <br>
                                </center>
                                <table class='table table-bordered table-striped'>
                                    <thead>
                                        <tr style="text-align:center;">
                                            <td>S_ID</td>
                                            <td>Date</td>
                                            <td>Invoice No</td>
                                            <td>Customer's Name</td>
                                            <td>Customer's PAN No</td>
                                            <td>Total Sales Amount</td>
                                            <td>VAT Included Sales Amount</td>
                                            <td>VAT Amount</td>
                                            <td>Branch</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($total_rows > 0) {
                                            $sum = 0;
                                            $sum1 = 0;
                                            $sum2 = 0;
                                            foreach ($all_result as $row) {
                                                $sum = $sum + $row["Total_sales_amount"];
                                                $sum1 = $sum1 + $row["VAT_included_sales_amount"];
                                                $sum2 = $sum2 + $row["VAT_included_sales_VAT"];
                                                echo '
                                            <tr>
                                                <td>' . $row["id"] . '</td>
                                                <td style="white-space: nowrap;">' . $row['Date'] . '</td>
                                                <td>' . $row['Bill_no'] . '</td>
                                                <td>' . $row['Customers_name'] . '</td>
                                                <td>' . $row['Customers_PAN_no'] . '</td>
                                                <td>' . $row['Total_sales_amount'] . '</td>
                                                <td>' . $row['VAT_included_sales_amount'] . '</td>
                                                <td>' . $row['VAT_included_sales_VAT'] . '</td></div>
                                                <td style="white-space: nowrap;">' . $row['Name'] . '<br> (' . $row['Address'] . ') </td>
                                            </tr>
                                            ';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tr>
                                        <td colspan="5"><b>Grand Total Amount:</b></td>
                                        <td colspan="1"><b><?php echo $sum; ?></b></td>
                                        <td colspan="1"><b><?php echo $sum1; ?></b></td>
                                        <td colspan="1"><b><?php echo $sum2; ?></b></td>
                                        <td colspan="1"></td>
                                    </tr>
                                </table>
                            </div>
                            <table id="data-table" class='table table-bordered table-striped'>
                                <thead>
                                    <tr style="text-align:center;">
                                        <td>S_ID</td>
                                        <td>Date</td>
                                        <td>Invoice No</td>
                                        <td>Customer's Name</td>
                                        <td>Customer's PAN No</td>
                                        <td>Total Sales Amount</td>
                                        <td>VAT Included Sales Amount</td>
                                        <td>VAT Amount</td>
                                        <td>Branch</td>
                                        <td>Edit</td>
                                        <td>Delete</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($total_rows > 0) {
                                        $sum = 0;
                                        $sum1 = 0;
                                        $sum2 = 0;
                                        foreach ($all_result as $row) {
                                            $sum = $sum + $row["Total_sales_amount"];
                                            $sum1 = $sum1 + $row["VAT_included_sales_amount"];
                                            $sum2 = $sum2 + $row["VAT_included_sales_VAT"];
                                            echo '
                                            <tr>
                                                <td>' . $row["id"] . '</td>
                                                <td style="white-space: nowrap;">' . $row['Date'] . '</td>
                                                <td>' . $row['Bill_no'] . '</td>
                                                <td>' . $row['Customers_name'] . '</td>
                                                <td>' . $row['Customers_PAN_no'] . '</td>
                                                <td>' . $row['Total_sales_amount'] . '</td>
                                                <td>' . $row['VAT_included_sales_amount'] . '</td>
                                                <td>' . $row['VAT_included_sales_VAT'] . '</td></div>
                                                <td style="white-space: nowrap;">' . $row['Name'] . '<br> (' . $row['Address'] . ') </td>
                                                <td><a href="sales.php?update=1&id=' . $row["id"] . '">Edit</a></td>
                                                <td><a href="sales.php?delete=1&id=' . $row["id"] . '">Delete</a></td>
                                            </tr>
                                            ';
                                        }
                                    }
                                    ?>
                                </tbody>
                                <tr>
                                    <td colspan="5"><b>Grand Total Amount:</b></td>
                                    <td colspan="1"><b><?php echo $sum; ?></b></td>
                                    <td colspan="1"><b><?php echo $sum1; ?></b></td>
                                    <td colspan="1"><b><?php echo $sum2; ?></b></td>
                                    <td colspan="3"></td>
                                </tr>
                            </table>

                        <?php } ?>
                        </div>
                </div>
                <?php include("includes/footer.php"); ?>
            </div>
        </div>
</body>

</html>
<script type="text/javascript" src="printThis.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#print').click(function() {
            x = $('#Part1');
            x.show();
            x.printThis({
                debug: false, // show the iframe for debugging
                importCSS: true, // import parent page css
                importStyle: false, // import style tags
                printContainer: true, // print outer container/$.selector
                loadCSS: "", // path to additional css file - use an array [] for multiple
                pageTitle: "", // add title to print page
                removeInline: false, // remove inline styles from print elements
                removeInlineSelector: "*", // custom selectors to filter inline styles. removeInline must be true
                printDelay: 333, // variable print delay
                header: null, // prefix to html
                footer: null, // postfix to html
                base: false, // preserve the BASE tag or accept a string for the URL
                formValues: true, // preserve input/form values
                canvas: false, // copy canvas content
                doctypeString: '<!DOCTYPE html>', // enter a different doctype for older markup
                removeScripts: false, // remove script tags from print content
                copyTagClasses: false, // copy classes from the html & body tag
                beforePrintEvent: null, // callback function for printEvent in iframe
                beforePrint: null, // function called before iframe is filled
                afterPrint: null // function called before iframe is removed
            });
            x.fadeOut(3000);
        })
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