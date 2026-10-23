<?php
$mysqli = new mysqli("db5000864815.hosting-data.io", "dbu134514", "eQUIP@89%%%", "dbs761031");

if (mysqli_connect_errno()) {
    printf("Falla en la conexión failed: %s\n",
    $mysqli->connect_error);
    exit();
}

class connection {
	static public function apikey(){

		return "HZ6Zfp1MloO3vt41dif7tToH3sk1";

	}
}

?>    
