<?php

	//require("constants.php"); 
	require("global_configuration.php");
	
	// Create the local server connection
	$azureServer = $config['DB_SERVER'];
	$azureDatabase = $config['DB_NAME'];
	$connectionInfo = array('Database'=>$azureDatabase,
							'Authentication'=>'ActiveDirectoryMsi');
	$connection = sqlsrv_connect($azureServer, $connectionInfo);

	
	// Check to see if the server connection works
	if (!$connection) {
		die("Server connection failed: " . print_r(sqlsrv_errors(), true));
	}
	
      	  function jrgsqlsrv_get_field_by_name($query, $name)
	        {
	        $ndx = jrgsqlsrv_get_field_index_by_name($query, $name);
			$val = sqlsrv_get_field($query, $ndx, SQLSRV_PHPTYPE_STRING(SQLSRV_ENC_CHAR));
			return $val; 

			}


	        function jrgsqlsrv_get_field_index_by_name($query, $name)
	        {
	          $metaData = sqlsrv_field_metadata($query);
	          for ($i = 0; $i < $metaData; $i++) 
            {
              if ($metaData[$i]["Name"] === $name) 
              {
                return $i;
              }
            }
	        }
        
?>
