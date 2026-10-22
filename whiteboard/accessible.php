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
    <title>Accessible Whiteboard</title>
    <link rel="stylesheet" href="./stylesheets/reset.css" type="text/css" />
    <link rel="stylesheet" href="./stylesheets/style.css" type="text/css" />
    <meta http-equiv="refresh" content="900" />
</head>

<body>

<?php require_once("includes/global_variables.php"); ?> 
    
<div id="wrapper">
    
	<?php include("includes/header.php"); ?>
    
    <div id="rental-wrapper">
    
        <div class="top-table-fix"> <!-- This fixes a spacing issue i had with with the first table day div for IE -->
        </div>
        
        <!-- table day 1 -->  
          
            <?php
                
                // Perfrom database queries
                $result = get_wb_rental_data($current_date, 13); // Get the rental data for today and company number			
                $vehicles_out_result = get_vehicles_out($current_date, 13, 'due out'); // Get the amount of vehicles going out for today, company number and due out
				                
                $vehicles_out_num = sqlsrv_num_rows($vehicles_out_result); // Now we want to assign the number of rows gernerated from the vehicle out query above to a variable
                
                $table_day = "<div class=\"table-day\">{$current_date_string}</div>"; // Here we are creating custom table day variables because each table heading has different data requirements which will be outputted on the table_header.php file
                $vehicles_out = "<div class=\"vehicles-out\">Due Out: <span class=\"vehicles-out-number\">{$vehicles_out_num}</span>&nbsp;&nbsp;Due In: <span class=\"vehicles-out-number\">{$vehicles_in_num}</span></div>";			
                
				//$data_check = sqlsrv_fetch_array($result); // This is used to return the data from the $result database query (above) and assign the values to $data_check
				
                // Now we want to see if any data exists in the $data_check variable by performing an if statement. What i am trying to acheive is if there is data in $data_check then i want it to output the table_header.php file which contains the header information for each table. If there is no data then display nothing (this is to work out if this day is a Sunday or not - Kerridge will not generate any data for Sunday's)
                if (false === sqlsrv_has_rows($result)) {
                    echo "";
                } else {
                    include("includes/table_header.php");
                }			
                        
                include("includes/table_data.php"); // This file contains all the code to output the rental data to a table
                            
            ?>
            
        <!-- End of table day 1 -->
        
        <!-- table day 2 -->
        
            <?php

                $result = get_wb_rental_data($current_date_plus_1, 13);
                $vehicles_out_result = get_vehicles_out($current_date_plus_1, 13, 'due out');
                
                $vehicles_out_num = sqlsrv_num_rows($vehicles_out_result);
                
                $table_day = "<div class=\"table-day\">{$current_date_plus_1_string}</div>";				
                $vehicles_out = "<div class=\"vehicles-out\">Vehicles going out: <span class=\"vehicles-out-number\">{$vehicles_out_num}</span></div>";			

				//$data_check = sqlsrv_fetch_array($result);

                if (false === sqlsrv_has_rows($result)) {
                    echo "";
                } else {
                    include("includes/table_header.php");
                }			
                        
                include("includes/table_data.php");
                            
            ?>
            
        <!-- End of table day 2 -->
        
        <!-- table day 3 -->    
            
            <?php

                $result = get_wb_rental_data($current_date_plus_2, 13);
                $vehicles_out_result = get_vehicles_out($current_date_plus_2, 13, 'due out');
                
                $vehicles_out_num = sqlsrv_num_rows($vehicles_out_result);
                
                $table_day = "<div class=\"table-day\">{$current_date_plus_2_string}</div>";
                $vehicles_out = "<div class=\"vehicles-out\">Vehicles going out: <span class=\"vehicles-out-number\">{$vehicles_out_num}</span></div>";			

				//$data_check = sqlsrv_fetch_array($result);

                if (false === sqlsrv_has_rows($result)) {
                    echo "";
                } else {
                    include("includes/table_header.php");
                }			
                        
                include("includes/table_data.php");
                            
            ?>
            
        <!-- End of table day 3 -->
        
        <!-- table day 4 -->    
            
            <?php

                $result = get_wb_rental_data($current_date_plus_3, 13);
                $vehicles_out_result = get_vehicles_out($current_date_plus_3, 13, 'due out');

                $vehicles_out_num = sqlsrv_num_rows($vehicles_out_result);
                
                $table_day = "<div class=\"table-day\">{$current_date_plus_3_string}</div>";
                $vehicles_out = "<div class=\"vehicles-out\">Vehicles going out: <span class=\"vehicles-out-number\">{$vehicles_out_num}</span></div>";			

				//$data_check = sqlsrv_fetch_array($result);

                if (false === sqlsrv_has_rows($result)) {
                    echo "";
                } else {
                    include("includes/table_header.php");
                }			
                        
                include("includes/table_data.php");
                            
            ?>
        
        <!-- End of table day 4 -->
        
        <!-- table day 5 -->
            
            <?php

                $result = get_wb_rental_data($current_date_plus_4, 13);
                $vehicles_out_result = get_vehicles_out($current_date_plus_4, 13, 'due out');

                $vehicles_out_num = sqlsrv_num_rows($vehicles_out_result);
                
                $table_day = "<div class=\"table-day\">{$current_date_plus_4_string}</div>";
                $vehicles_out = "<div class=\"vehicles-out\">Vehicles going out: <span class=\"vehicles-out-number\">{$vehicles_out_num}</span></div>";			

				//$data_check = sqlsrv_fetch_array($result);

                if (false === sqlsrv_has_rows($result)) {
                    echo "";
                } else {
                    include("includes/table_header.php");
                }			
                        
                include("includes/table_data.php");
                            
            ?>
            
        <!-- End of table day 5 -->
    
        <!-- table day 6 -->
            
            <?php

                $result = get_wb_rental_data($current_date_plus_5, 13);
                $vehicles_out_result = get_vehicles_out($current_date_plus_5, 13, 'due out');

                $vehicles_out_num = sqlsrv_num_rows($vehicles_out_result);
                
                $table_day = "<div class=\"table-day\">{$current_date_plus_5_string}</div>";
                $vehicles_out = "<div class=\"vehicles-out\">Vehicles going out: <span class=\"vehicles-out-number\">{$vehicles_out_num}</span></div>";			

				//$data_check = sqlsrv_fetch_array($result);

                if (false === sqlsrv_has_rows($result)) {
                    echo "";
                } else {
                    include("includes/table_header.php");
                }			
                        
                include("includes/table_data.php");
                            
            ?>
            
        <!-- End of table day 6 -->
        
        <!-- table day 7 -->
            
            <?php
                
                $result = get_wb_rental_data($current_date_plus_6, 13);
                $vehicles_out_result = get_vehicles_out($current_date_plus_6, 13, 'due out');		

                $vehicles_out_num = sqlsrv_num_rows($vehicles_out_result);
                
                $table_day = "<div class=\"table-day\">{$current_date_plus_6_string}</div>";
                $vehicles_out = "<div class=\"vehicles-out\">Vehicles going out: <span class=\"vehicles-out-number\">{$vehicles_out_num}</span></div>";			

				//$data_check = sqlsrv_fetch_array($result);

                if (false === sqlsrv_has_rows($result)) {
                    echo "";
                } else {
                    include("includes/table_header.php");
                }			
                        
                include("includes/table_data.php");
                            
            ?>
            
        <!-- End of table day 7 -->
        
        <div class="spacer">
        </div>
    
    </div> <!-- End of rental-wrapper -->

    
</div> <!-- End of wrapper div -->

<?php require("includes/footer.php"); ?>