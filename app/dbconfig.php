<?php
class DBConfig {
	public $host        = "host=localhost";
	public $port        = "port=5432";
	public $dbname      = "dbname=db_githubscan";
	public $credentials = "user= password=";	

	function pg_connect() {
		$connect= pg_connect( "$this->host $this->port $this->dbname $this->credentials"  ) or die("Could not connect: " . pg_last_error());
		return $connect;
	}
	
	function pg_close($connect) {
		pg_close($connect);
	}
}
?>