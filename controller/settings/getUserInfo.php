<?php
require_once('../../config.php');

if($_GET['userId'] && !empty($_GET['userId']) !== null)
{
    $userId = $_GET['userId'];

    $sql = "select id, firstname, lastname, email, created_at,photo from users where id=:userId";

    try{
        $handle = $pdo->prepare($sql);

        $params = ['userId'=>$userId];

        $handle->execute($params);

        if($handle->rowCount() > 0) {
            $getRow = $handle->fetchAll();
            header('Content-Type: application/json; charset=utf-8');
            $data = [array("id"=>$getRow[0]["id"],"firstname"=>$getRow[0]["firstname"],"lastname"=>$getRow[0]["lastname"],"email"=>$getRow[0]["email"],"joined"=>$getRow[0]["created_at"],"photo"=>$getRow[0]["photo"])];
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


