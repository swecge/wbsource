<?php

	// This file contains all the functions
	
	
	// Here we change the string to time (strtotime) function so it will read uk format dates (dd/mm/yyyy). strtotime converts human readable time and date to a unix time stamp
	function strtotime_uk($date_string) {
			$date_string = preg_replace("/^\s*([0-9]{1,2})[\/\. -]+([0-9]{1,2})[\/\. -]*([0-9]{0,4})/", "\\2/\\1/\\3", $date_string);
			$date_string = trim($date_string,'/');
			//echo "Converted to UK date: $date_string";
			return strtotime($date_string);
		}
		
			
	
	// This function is used to test whether the data queries from the mysql data were successful
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed: " . print_r(sqlsrv_errors(), true));
		}
	}
	
	
	
	// These functions perform various mysql queries
	
	// This one queries the data for the main rental day tables and orders them by action (due out at top due back at bottom) and due out time in ascending order
	function get_wb_rental_data($date, $location_id) {
		global $connection;		
		$query = "SELECT *
				FROM wbren (nolock)
				WHERE date = '$date' AND location_id = {$location_id}
				ORDER BY action, CASE WHEN action = 'to collect' THEN days_on_hire END, CASE WHEN action = 'due out' THEN CASE WHEN LEN(out_time) = 4 THEN CONCAT('0',out_time) ELSE out_time END ELSE CASE WHEN LEN(return_time) = 4 THEN CONCAT('0',return_time) ELSE return_time END END";
		$result = sqlsrv_query($connection, $query, array(), array( "Scrollable" => 'static' ));
		confirm_query($result);
		return $result;
	}
	
	// This one queries the data for the vehicles going out number
	function get_vehicles_out($date, $location_id, $action) {
		global $connection;
		$query = "SELECT *
				  FROM wbren (nolock)
				WHERE date = '$date' AND location_id = {$location_id} AND action = '$action'";
		$vehicles_out_result = sqlsrv_query($connection, $query, array(), array( "Scrollable" => 'static' ));
		confirm_query($vehicles_out_result);
		return $vehicles_out_result;
	}

	// This one queries the data for the vehicles due in number
	function get_vehicles_in($date, $location_id, $action) {
		global $connection;
		$query = "SELECT *
				FROM wbren (nolock)
				WHERE date = '$date' AND location_id = {$location_id} AND action = '$action'";
		$vehicles_in_result = sqlsrv_query($connection, $query, array(), array( "Scrollable" => 'static' ));
		confirm_query($vehicles_in_result);
		return $vehicles_in_result;
	}
	
	// This one queries the data for the vehicles due in number, but this is for branches that share the same company number (like Shrewsbury and Telford) but have unique sub_location_id values to seperate them
	function get_vehicles_out_sub_location($date, $location_id, $action, $sub_location_id) {
		global $connection;
		$query = "SELECT *
				FROM wbren (nolock)
				WHERE date = '$date' AND location_id = {$location_id} AND action = '$action' AND sub_location_id = '$sub_location_id'";
		$vehicles_out_sub_location_result = sqlsrv_query($connection, $query, array(), array( "Scrollable" => 'static' ));
		confirm_query($vehicles_out_sub_location_result);
		return $vehicles_out_sub_location_result;
	}

	// This one queries the data for the vehicles due in number, but this is for branches that share the same company number (like Shrewsbury and Telford) but have unique sub_location_id values to seperate them
	function get_vehicles_in_sub_location($location_id, $action, $sub_location_id) {
		global $connection;
		$query = "SELECT *
				FROM wbren (nolock)
				WHERE location_id = {$location_id} AND action = '$action' AND sub_location_id = '$sub_location_id'";
		$vehicles_in_sub_location_result = sqlsrv_query($connection, $query, array(), array( "Scrollable" => 'static' ));
		confirm_query($vehicles_in_sub_location_result);
		return $vehicles_in_sub_location_result;
	}
	
		
	
	// These functions are for out putting data to the rental table cells
	

	function action() {
		global $action;
		if ($action == "due out") {
			echo "<td><img src=\"/images/out.png\" alt=\"Due Out\" title=\"Due Out\" height=\"32\" width=\"32\" /></td>";
		} elseif ($action == "to collect") {
			echo "<td><img src=\"/images/in.png\" alt=\"Due In\" title=\"Due In\" height=\"32\" width=\"32\" /></td>";
		} else {
			echo "<td class=\"expired\">N/A</td>";
		}
	}
  

	
	
	// This function is slightly different to the default action() function. This one is used for brnaches like Shrewsbury and Telford who both share the same company number in Kerridge but act as two seperate branches
	// What this function does is it adds grey arrows to it's remote sites rentals (i.e. For Shrewsbury's whiteboard it shows all Telford's rentals with a grey arrow because Telford is the remote site to Shrewsbury).
	function action_sub_location($sub_remote_location) {
		global $action;
		global $sub_location_id;
		if (($action == "due out") && ($sub_location_id == $sub_remote_location)) {
				echo "<td><img src=\"/images/out-grey.png\" alt=\"Due Out\" title=\"Due Out\" height=\"32\" width=\"32\" /></td>";
		} elseif (($action == "to collect") && ($sub_location_id == $sub_remote_location)) {
			echo "<td><img src=\"/images/in-grey.png\" alt=\"Due In\" title=\"Due In\" height=\"32\" width=\"32\" /></td>";
		} elseif ($action == "due out") {
			echo "<td><img src=\"/images/out.png\" alt=\"Due Out\" title=\"Due Out\" height=\"32\" width=\"32\" /></td>";
		} elseif ($action == "to collect") {
			echo "<td><img src=\"/images/in.png\" alt=\"Due In\" title=\"Due In\" height=\"32\" width=\"32\" /></td>";
		} else {
			echo "<td class=\"expired\">N/A</td>";
		}
	}
  
  
	
  
	function customer_type() {
		global $customer_type;
		if ($customer_type == "W") {
			echo "<td><img src=\"/images/spanner.png\" alt=\"Workshop\" title=\"Workshop\" height=\"32\" width=\"32\" /></td>";
		} elseif ($customer_type == "SP") {
			echo "<td><img src=\"/images/sale.png\" alt=\"Sales Prep\" title=\"Sales Prep\" height=\"32\" width=\"32\" /></td>";
		} elseif ($customer_type == "C") {
			echo "<td><img src=\"/images/cash.png\" alt=\"Cash Customer\" title=\"Cash Customer\" height=\"32\" width=\"44\" /></td>";
		} elseif ($customer_type == "A") {
			echo "<td><img src=\"/images/pen-paper.png\" alt=\"Account Customer\" title=\"Account Customer\" height=\"32\" width=\"32\" /></td>";
		} elseif ($customer_type == "RE") {
			echo "<td><img src=\"/images/reserved-note.png\" alt=\"Reserved\" title=\"Reserved\" height=\"32\" width=\"32\" /></td>";
			} elseif ($customer_type == "NR") {
			echo "<td><img src=\"/images/van-moving-yellow.png\" alt=\"Non Rental\" title=\"Non Rental\" height=\"32\" width=\"60\" /></td>";
		} elseif ($customer_type == "DL") {
			echo "<td><img src=\"/images/vehicle-hazard.png\" alt=\"Damage in Life\" title=\"Damage in Life\" height=\"32\" width=\"32\" /></td>";
		} else {
			echo "<td class=\"amber\">No Entry</td>";
		}
	}
  
	

	function rental_status() {
		global $rental_status;
		if ($rental_status == "B") {
			echo "<td class=\"amber\">$rental_status</td>";
		}else {
			echo "<td>$rental_status</td>";
		}
	}
  
	function days_on_hire() {
		global $rental_status;
		global $days_on_hire;
		if ($rental_status == "H") {
			echo "<td class=\"hstatus\">$days_on_hire</td>";
		}
		else{
			echo "<td>$days_on_hire</td>";
		}
	}
  
	function registration() {
		global $registration;
		if ($registration == " ") { // I am not using the empty function because even though the field maybe blank Kerridge has put a space in so in theory the field isn't empty according to the empty function
			echo "<td><img src=\"/images/van-warning.png\" alt=\"No vehicle allocated\" title=\"No vehicle allocated\" height=\"32\" width=\"60\" /></td>";
		} else {
			echo "<td>$registration</td>";
		}
	}
  
	
  
	function vehicle_ready() {
		global $vehicle_ready;
		if ($vehicle_ready == "a") {
				echo "<td><img src=\"/images/thumbs-up.png\" alt=\"Vehicle Ready\" title=\"Vehicle Ready\" height=\"32\" width=\"32\" /></td>";
			} elseif ($vehicle_ready == "b") {
				echo "<td><img src=\"/images/thumbs-down.png\" alt\"Vehicle not Ready\" title=\"Vehicle not Ready\" height=\"32\" width=\"32\" /></td>";
			} elseif ($vehicle_ready == "c") {
				echo "<td><img src=\"/images/in-blue.png\" alt\"Collection in Progress\" title=\"Collection in Progress\" height=\"32\" width=\"32\" /></td>";
			} elseif ($vehicle_ready == "d") {
				echo "<td><img src=\"/images/out-blue.png\" alt\"Delivery in Progress\" title=\"Delivery in Progress\" height=\"32\" width=\"32\" /></td>";
			} elseif ($vehicle_ready == "f") {
				echo "<td><img src=\"/images/roundel.png\" alt\"Delivery/Collection Completed\" title=\"Delivery/Collection Completed\" height=\"32\" width=\"32\" /></td>";
			} elseif ($vehicle_ready == "r") {
				echo "<td><img src=\"/images/circle-arrows.png\" alt\"Re-Hire\" title=\"Re-Hire\" height=\"32\" width=\"32\" /></td>";
			} elseif ($vehicle_ready == "i") {
				echo "<td><img src=\"/images/wtfiib_small.png\" alt\"Failed Collection\" title=\"Failed Collection\" height=\"32\" width=\"32\" /></td>";
			} elseif ($vehicle_ready == "h") {
				echo "<td><img src=\"/images/ohcc_small.png\" alt\"Off Hired Can't Collect\" title=\"Off Hired Can't Collect\" height=\"32\" width=\"32\" /></td>";
			} else {
				echo "<td>$vehicle_ready</td>";
			}
	}
  
	
  
	/* This function isn't used but it will be kept for the future
	function out_date() {
		global $out_date;
		global $current_date_timestamp;
		global $out_time;
		global $current_time;
		global $current_time_plus_2hr;
		global $out_date_timestamp;		
		
		if (($out_date_timestamp == $current_date_timestamp) && ($out_time < $current_time)) {
			echo "<td class=\"red\">$out_date</td>";
		} elseif ($out_date_timestamp < $current_date_timestamp) {
			echo "<td class=\"red\">$out_date</td>";
		} elseif (($out_date_timestamp == $current_date_timestamp) && ($out_time == $current_time)) {
			echo "<td class=\"amber\">$out_date</td>";
		} elseif (($out_date_timestamp == $current_date_timestamp) && (($out_time > $current_time) && ($out_time <= $current_time_plus_2hr))) {
			echo "<td class=\"amber\">$out_date</td>";
		} else {
			echo "<td>$out_date</td>";
		}
	}
	End of function */

	
  
	function out_time() {
		global $out_date;
		global $current_date_timestamp;
		global $out_time;
		global $current_time;
		global $current_time_plus_2hr;
		global $out_date_timestamp;
		global $rental_status;
		
		if ($out_date == 0 || $rental_status == "H"){
			echo "<td></td>";
		} elseif (($out_date_timestamp == $current_date_timestamp) && ($out_time < $current_time)) {
			echo "<td class=\"red\">$out_time</td>";
		} elseif ($out_date_timestamp < $current_date_timestamp) {
			echo "<td class=\"red\">$out_time</td>";
		} elseif (($out_date_timestamp == $current_date_timestamp) && ($out_time == $current_time)) {
			echo "<td class=\"amber\">$out_time</td>";
		} elseif (($out_date_timestamp == $current_date_timestamp) && (($out_time > $current_time) && ($out_time <= $current_time_plus_2hr))) {
			echo "<td class=\"amber\">$out_time</td>";
		} else {
			echo "<td>$out_time</td>";
		}
	}
  
	
  
	/* This function isn't used but it will be kept for the future
	function return_date() {	
		global $return_date;
		global $current_date_timestamp;
		global $return_time;
		global $current_time;
		global $current_time_plus_2hr;
		global $return_date_timestamp;
				
		if (($return_date_timestamp == $current_date_timestamp) && ($return_time < $current_time)) {
			echo "<td class=\"red\">$return_date</td>";
		} elseif ($return_date_timestamp < $current_date_timestamp) {
			echo "<td class=\"red\">$return_date</td>";
		} elseif (($return_date_timestamp == $current_date_timestamp) && ($return_time == $current_time)) {
			echo "<td class=\"amber\">$return_date</td>";
		} elseif (($return_date_timestamp == $current_date_timestamp) && (($return_time > $current_time) && ($return_time <= $current_time_plus_2hr))) {
			echo "<td class=\"amber\">$return_date</td>";
		} else {
			echo "<td>$return_date</td>";
		}
	}
	End of function */
  
	
  
	function return_time() {
		global $return_date;
		global $current_date_timestamp;
		global $return_time;
		global $current_time;
		global $current_time_plus_2hr;
		global $return_date_timestamp;
		global $rental_status;
		
		if ($return_date == 0 || $rental_status <> "H"){
			echo "<td></td>";
		} elseif (($return_date_timestamp == $current_date_timestamp) && ($return_time < $current_time)) {
			echo "<td><img src=\"/images/clock-warning.png\" alt\"Vehicle was due back on {$return_date} at {$return_time}\" title=\"Vehicle was due back on {$return_date} at {$return_time}\" height=\"32\" width=\"30\" /></td>";
		} elseif ($return_date_timestamp < $current_date_timestamp) {
			echo "<td><img src=\"/images/clock-warning.png\" alt\"Vehicle was due back on {$return_date} at {$return_time}\" title=\"Vehicle was due back on {$return_date} at {$return_time}\" height=\"32\" width=\"30\" /></td>";
		} elseif (($return_date_timestamp == $current_date_timestamp) && ($return_time == $current_time)) {
			echo "<td class=\"amber\">$return_time</td>";
		} elseif (($return_date_timestamp == $current_date_timestamp) && (($return_time > $current_time) && ($return_time <= $current_time_plus_2hr))) {
			echo "<td class=\"amber\">$return_time</td>";
		} else {
			echo "<td>$return_time</td>";
		}
	}
  
	
  
	function delivery_collection() {
		global $delivery_collection;
		if ($delivery_collection == "Y") {
			echo "<td><img src=\"/images/tick.png\" alt=\"Yes\" title=\"Yes\" height=\"32\" width=\"32\" /></td>";
		} elseif ($delivery_collection == "N") {
			echo "<td></td>";
		} elseif ($delivery_collection == " ") {
			echo "<td></td>";
		} else {
			echo "<td>$delivery_collection</td>";
		}
	}
  
		
?>