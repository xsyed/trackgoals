<?php
require_once('../../config.php');

if(isset($_GET['userId']) && isset($_GET['fuserId']) && !empty($_GET['userId']) && !empty($_GET['fuserId']))
{
    $userId = $_GET['userId'];
    $fuserId =$_GET['fuserId'];

    try{
        // CHECK IS REQUEST ALREADY SENT OR NOT
        // is_request_already_sent() FUNCTION RETURN TRUE OR FALSE
        if($frnd_obj->is_request_already_sent($userId, $fuserId)){
            header('Content-Type: application/json; charset=utf-8');
            $data = ["Status"=>"Empty"];
            echo json_encode($data);
        }
        // CHECK IF THIS ID IS ALREADY IN MY FRIENDS LIST.
        // THIS FUNCTION ALSO RETURN TRUE OR FALSE
        else if($frnd_obj->is_already_friends($userId, $fuserId)){
            header('Content-Type: application/json; charset=utf-8');
            $data = ["Status"=>"Empty"];
            echo json_encode($data);
        }
        // OTHERWISE MAKE FRIEND REQUEST
        else{
            header('Content-Type: application/json; charset=utf-8');
            $frnd_obj->make_pending_friends($userId, $fuserId);
            echo json_encode(["Status"=>"Success"]);
        }

    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
}
else
{
    echo  "Habit name is required";
}


