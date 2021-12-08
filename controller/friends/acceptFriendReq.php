<?php
require_once('../../config.php');

if(isset($_GET['userId']) && isset($_GET['fuserId']) && !empty($_GET['userId']) && !empty($_GET['fuserId']))
{
    $userId = $_GET['userId'];
    $fuserId =$_GET['fuserId'];

    try{

        if($frnd_obj->is_already_friends($userId, $fuserId)){
            header('Content-Type: application/json; charset=utf-8');
            $data = ["Status"=>"Empty"];
            echo json_encode($data);
        }
        else{
            $frnd_obj->make_friends($userId, $fuserId);
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


