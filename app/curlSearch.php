<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once( "dbconfig.php" );
  
$DBConfig = new DBConfig();
$pg_connect = $DBConfig->pg_connect();

// foreach ($_SERVER as $key => $value) {
//     echo $key." - ".$value."\n";
// }
if (isset($_SERVER['HTTP_X_SEARCH_TOKEN'])) {
    $user_token = $_SERVER['HTTP_X_SEARCH_TOKEN'];
}

// get posted data
$data = json_decode(file_get_contents("php://input"));
// make sure data is not empty
if(
    !empty($data->search->list) &&
    !empty($data->search->sensitivekeyword) &&
    !empty($user_token)
)
{
    $list = $data->search->list;
    sort($list);
    $list_str = implode(",", $list);
    $keyword = $data->search->sensitivekeyword;
    sort($keyword);
    $keyword_str = implode(",", $keyword);

    $result = pg_query($pg_connect,"SELECT * FROM tbl_user WHERE token='$user_token'");
    if (pg_num_rows($result) == 1)
    {
        while($row = pg_fetch_array($result))
        {
            $user_id = $row['id'];
        }

        $result1 = pg_query($pg_connect,"SELECT * FROM tbl_search_result WHERE user_id='$user_id' AND fonte_list='$list_str' AND fonte_sens_keyword='$keyword_str'");
        $resarr = array();
        if (pg_num_rows($result1) > 0)
        {
            while($row = pg_fetch_array($result1))
            {
                $arr = array(
                    'owner_name' => $row['owner_name'],
                    'owner_link' => $row['owner_link'],
                    'repo_name' => $row['repo_name'],
                    'repo_link' => $row['repo_link'],
                    'file_name' => $row['file_name'],
                    'file_link' => $row['file_link'],
                    'fonte_sensitive' => explode("||||", $row['fonte_sensitive']),
                    'fonte_found' => explode("||||", $row['fonte_found']),
                    'sensitive_count' => $row['sensitive_count'],
                    'found_count' => $row['found_count']
                );
                array_push($resarr, $arr);
            }

            // set response code - 200 OK
            http_response_code(200);
            echo json_encode(array("result" => $resarr), JSON_PRETTY_PRINT);
        } else {
            // set response code - 401
            http_response_code(401);
            echo json_encode(array("message" => "Invalid user token"));
        }
    } else {
        // set response code - 400 bad request
            http_response_code(400);
          
            // tell the user
            echo json_encode(array("message" => "No search result found"));
    }
}
?>