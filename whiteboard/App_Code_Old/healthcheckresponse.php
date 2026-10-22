<?php
function CheckHealth(){
		$testvalue = "check_string";
	    $responsevalue = $testvalue;

	if($responsevalue == $testvalue){
	   return http_response_code(200);
	}
	else{
		return http_response_code(400);
	}
}
?>