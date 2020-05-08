<?php
//database_connection.php

include('cred_account.php');
$connect = new PDO("mysql:host=$DATABASE_HOST;dbname=$DATABASE_NAME", $DATABASE_USER, $DATABASE_PASS);
function fill_select_box($connect)
{
    $query = "
  SELECT * FROM Ratelist 
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    $output = '';

    foreach ($result as $row) {
        $output .= '<option value="' . $row["Product"] . '">' . $row["Product"] . '</option>';
    }

    return $output;
}

function fill_rate_purchase($connect, $id, $count)
{
 $query = "
  SELECT * FROM Ratelist 
  WHERE Product = '".$id."'
 ";

 $statement = $connect->prepare($query);

 $statement->execute();

 $result = $statement->fetchAll();

 $total_rows = $statement->rowCount();

 $output = '';

 foreach($result as $row)
 {
    $output.= '<input type="text" name="order_item_price[]" id="order_item_price'.$count.'" data-srno="'.$count.'" class="form-control input-sm number_only order_item_price" value="'.$row["Purchase_Rate"].'" style="min-width: 75px;" readonly/>';
    //$output.= '<input type="text" value="'.$row["Rate"].'" placeholder="Rate" readonly class="form-control item_name">';
 }

 return $output;
}

function fill_rate_sales($connect, $id, $count)
{
 $query = "
  SELECT * FROM Ratelist 
  WHERE Product = '".$id."'
 ";

 $statement = $connect->prepare($query);

 $statement->execute();

 $result = $statement->fetchAll();

 $total_rows = $statement->rowCount();

 $output = '';

 foreach($result as $row)
 {
    $output.= '<input type="text" name="order_item_price[]" id="order_item_price'.$count.'" data-srno="'.$count.'" class="form-control input-sm number_only order_item_price" value="'.$row["Sales_Rate"].'" style="min-width: 75px;" readonly/>';
    //$output.= '<input type="text" value="'.$row["Rate"].'" placeholder="Rate" readonly class="form-control item_name">';
 }

 return $output;
}
?>