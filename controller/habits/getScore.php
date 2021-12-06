<?php
require_once('../../config.php');

if($_GET['userId'] && !empty($_GET['userId']) !== null)
{
    $userId = $_GET['userId'];

    $sql = "SELECT COUNT(*) as Score FROM habitlog 
            WHERE habit_id in (select id from habits where userId=:userId) and status=1";

    try{
        $handle = $pdo->prepare($sql);

        $params = ['userId'=>$userId];

        $handle->execute($params);

        if($handle->rowCount() > 0) {
            $getRow = $handle->fetchAll();
            header('Content-Type: application/json; charset=utf-8');
            $data = array("Score"=>$getRow[0]["Score"]);
            echo json_encode($data);
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


