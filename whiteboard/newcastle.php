<?php require_once("includes/connection.php"); ?> <!-- This is for the server and database connection -->
<?php require_once("includes/functions.php"); ?> <!-- This is where all the functions are located -->
<!DOCTYPE HTML>

<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <!--[if lt IE 9]>
    	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  	<![endif]-->
    <title>Newcastle Whiteboard</title>
    <link rel="stylesheet" href="./stylesheets/reset.css" type="text/css" />
    <link rel="stylesheet" href="./stylesheets/style.css" type="text/css" />
    <meta http-equiv="refresh" content="900" />
</head>

<body>

<?php require_once("includes/global_variables.php"); ?>

<?php include("includes/header.php"); ?>
    
<div id="wrapper">
    
    <div id="rental-wrapper">
    
        <div class="top-table-fix"> <!-- This fixes a spacing issue i had with with the first table day div for IE -->
        </div>
        
        <!-- Days Iteration -->

        <?php
            $dates = [$current_date,$current_date_plus_1,$current_date_plus_2,$current_date_plus_3,$current_date_plus_4,$current_date_plus_5,$current_date_plus_6,$current_date_plus_7,$current_date_plus_8,$current_date_plus_9,$current_date_plus_10,$current_date_plus_11,$current_date_plus_12,$current_date_plus_13,$current_date_plus_14,$current_date_plus_15,$current_date_plus_16,$current_date_plus_17,$current_date_plus_18,$current_date_plus_19,$current_date_plus_20,$current_date_plus_21,$current_date_plus_22,$current_date_plus_23,$current_date_plus_24,$current_date_plus_25,$current_date_plus_26,$current_date_plus_27];

            foreach( $dates as $date ){

                $iterated_timestamp = strtotime_uk($date);
                $iterated_date_string = date("l d F Y", $iterated_timestamp);
                // Perfrom database queries
                $result = get_wb_rental_data($date, 8); // Get the rental data for today and company number			
                $vehicles_out_result = get_vehicles_out($date, 8, 'due out'); // Get the amount of vehicles going out for today, company number and due out
                $vehicles_in_result = get_vehicles_in($date, 8, 'To Collect'); // Get the amount of vehicles due in for today, company number and due in
				                
                $vehicles_out_num = sqlsrv_num_rows($vehicles_out_result); // Now we want to assign the number of rows gernerated from the vehicle out query above to a variable
                $vehicles_in_num = sqlsrv_num_rows($vehicles_in_result); // Now we want to assign the number of rows gernerated from the vehicle in query above to a variable
                
                $table_day = "<div class=\"table-day\">{$iterated_date_string}</div>"; // Here we are creating custom table day variables because each table heading has different data requirements which will be outputted on the table_header.php file
                $vehicles_out = "<div class=\"vehicles-out\">Due Out: <span class=\"vehicles-out-number\">{$vehicles_out_num}</span>&nbsp;&nbsp;Due In: <span class=\"vehicles-out-number\">{$vehicles_in_num}</span></div>";			
                
				//$data_check = sqlsrv_fetch_array($result); // This is used to return the data from the $result database query (above) and assign the values to $data_check
				
                // Now we want to see if any data exists in the $data_check variable by performing an if statement. What i am trying to acheive is if there is data in $data_check then i want it to output the table_header.php file which contains the header information for each table. If there is no data then display nothing (this is to work out if this day is a Sunday or not - Kerridge will not generate any data for Sunday's)
                if (false === sqlsrv_has_rows($result)) {
                    echo "";
                } else {
                    include("includes/table_data.php"); // This file contains all the code to output the rental data to a table
                }	
            }
        ?>
        
        <div class="spacer">
        </div>
    
    </div> <!-- End of rental-wrapper -->
    
    
</div> <!-- End of wrapper div -->

<?php require("includes/footer.php"); ?>