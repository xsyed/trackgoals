<?php
require_once('../../config.php');

if(isset($_GET['userId']) && !empty($_GET['userId']))
{
    $userId = $_GET['userId'];

    try{
        $get_frnd_num = $frnd_obj->get_all_friends($userId, false);
        $get_all_friends = $frnd_obj->get_all_friends($userId, true);

        if($get_frnd_num > 0){

            echo json_encode($get_all_friends);
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


