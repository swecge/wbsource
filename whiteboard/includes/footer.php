</body>
</html>
<?php
	// Close connection
    if (isset($connection)) {
		sqlsrv_close($connection);
	}
?>