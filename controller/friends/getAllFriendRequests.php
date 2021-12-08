<?php
require_once('../../config.php');

if(isset($_GET['userId']) && !empty($_GET['userId']))
{
    $userId = $_GET['userId'];

    try{
        $get_req_num = $frnd_obj->request_notification($userId, false);
        $get_all_req_sender = $frnd_obj->request_notification($userId, true);


        if($get_req_num > 0){

            echo json_encode($get_all_req_sender);
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


