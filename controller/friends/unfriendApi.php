<?php
require_once('../../config.php');

if(isset($_GET['userId']) && isset($_GET['fuserId']) && !empty($_GET['userId']) && !empty($_GET['fuserId']))
{
    $userId = $_GET['userId'];
    $fuserId =$_GET['fuserId'];

    try{
        $status = $frnd_obj->delete_friends($userId, $fuserId);

        if($status == true){
            echo json_encode(["Status"=>"Success"]);
            //echo "Seccues";
        } else{
            header('Content-Type: application/json; charset=utf-8');
            $data = ["Status"=>"Empty"];
            echo json_encode($data);
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


