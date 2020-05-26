<?php

//fill_sub_category.php

include('database_connection.php');
include('functions.php');

echo fill_pan_no_purchase($connect, $_POST["category_id"]);

?>
