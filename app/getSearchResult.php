<?php
	session_start();
	if (isset($_SESSION["username"])) {
		include_once( "dbconfig.php" );
		$DBConfig = new DBConfig();
		$pg_connect = $DBConfig->pg_connect();

		$username = $_SESSION["username"];
		if (isset($_GET["list"])) {
			$list = $_GET["list"];
			$keyword = $_GET["keyword"];

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
		    $result = pg_query($pg_connect,"SELECT * FROM tbl_search_result WHERE user_id='$user_id' AND fonte_list='$list' AND fonte_sens_keyword='$keyword'");
		    $resarr = array();
		    if (pg_num_rows($result) > 0)
		    {
		      while($row = pg_fetch_array($result))
		      {
		      	$arr = array(
		      		'owner_name' => $row['owner_name'],
		      		'owner_link' => $row['owner_link'],
		      		'repo_name' => $row['repo_name'],
		      		'repo_link' => $row['repo_link'],
		      		'file_name' => $row['file_name'],
		      		'file_link' => $row['file_link'],
		      		'fonte_sensitive' => $row['fonte_sensitive'],
		      		'fonte_found' => $row['fonte_found'],
		      		'sensitive_count' => $row['sensitive_count'],
		      		'found_count' => $row['found_count']
		      	);
		      	array_push($resarr, $arr);
		      }
		      echo json_encode($resarr);
		    }
		}		
	}
?>