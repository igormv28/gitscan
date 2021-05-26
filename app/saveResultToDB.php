<?php
	session_start();
	if (isset($_SESSION["username"])) {
		include_once( "dbconfig.php" );
		$DBConfig = new DBConfig();
		$pg_connect = $DBConfig->pg_connect();

		$username = $_SESSION["username"];

		$result = pg_query($pg_connect,"SELECT * FROM tbl_user WHERE username='$username'");
	    if (pg_num_rows($result) == 0)
	    {
	      echo "<script>alert('Invalid User');</script>";
	    } else {
	      while($row = pg_fetch_array($result))
	      {
	        $user_id = $row['id'];
	      }
	    }

	    if (isset($_REQUEST["palavras_chaves"])) {
	        $fonte_list = $_REQUEST["palavras_chaves"];
	        $fonte_sens_keyword = $_REQUEST["palavras_sensitivas"];
	        $owner_name = $_REQUEST["owner_name"];
	        $owner_link = $_REQUEST["owner_link"];
	        $repo_name = $_REQUEST["repo_name"];
	        $repo_link = $_REQUEST["repo_link"];
	        $file_name = $_REQUEST["file_name"];
	        $file_link = $_REQUEST["file_link"];
	        $fonte_sensitive = $_REQUEST["fonte_sensitive"];
	        $fonte_sensitive = str_replace("'", "\'", $fonte_sensitive);
	        $fonte_sensitive = str_replace("'", "\"", $fonte_sensitive);
	        $fonte_found = $_REQUEST["fonte_found"];
	        $fonte_found = str_replace("'", "\'", $fonte_found);
	        $fonte_found = str_replace("'", "\"", $fonte_found);
	        $sensitive_count = $_REQUEST["sensitive_count"];
            $found_count = $_REQUEST["found_count"];

	        try {
	        	$result = pg_query($pg_connect,"INSERT INTO tbl_search_result (owner_name, owner_link, repo_name, repo_link, file_name, file_link, fonte_sensitive, fonte_found, fonte_list, fonte_sens_keyword, user_id, sensitive_count, found_count) VALUES ('$owner_name', '$owner_link', '$repo_name', '$repo_link', '$file_name', '$file_link', '$fonte_sensitive', '$fonte_found', '$fonte_list', '$fonte_sens_keyword', '$user_id', '$sensitive_count', '$found_count')");
	        	echo true;	
	        } catch (Exception $e) {
	        	echo $e;
	        }
	    }
	}
?>