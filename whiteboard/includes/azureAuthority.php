<?php
    function getAzToken(){
        
        $url = getenv("token-url");
        
        // Set cURL options
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'x-functions-key: ' . getenv("functionapp-key")
        ));
        
        // Execute the cURL request
        $response = curl_exec($ch);
        
        // Check for errors
        if(curl_errno($ch)){
            return 'Error: ' . curl_error($ch);
        }
        else{
            return $response;
        }
        
        // Close cURL session
        curl_close($ch);
    }
?>