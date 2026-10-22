<?php
     
	 function getConfiguration()
	 {	

	    $cfg = array();
           
        $cfg["DB_SERVER"]   = getenv("asqldb-whiteboard-location");
        $cfg["DB_NAME"]     = getenv("asqldb-whiteboard-databasename");

        return $cfg;

	 }

?>