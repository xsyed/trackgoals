<?php
require_once('../../config.php');

if( isset($_POST['oldEmail'],$_POST['newEmail'],$_POST['userId']) && !empty($_POST['userId']) && !empty($_POST['oldEmail'])  && !empty($_POST['newEmail']))
{

    $userId = $_POST['userId'];
    $oldEmail = $_POST['oldEmail'];
    $newEmail = $_POST['newEmail'];

    $date = date('Y-m-d');


    if (!filter_var($oldEmail, FILTER_VALIDATE_EMAIL)) {
        header('Content-Type: application/json; charset=utf-8');
        $data = array("Status"=>"Empty");
        echo json_encode($data);
        exit();
    }

    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        header('Content-Type: application/json; charset=utf-8');
        $data = array("Status"=>"Empty");
        echo json_encode($data);
        exit();
    }

    $sql = "update users set email=:newEmail, updated_on=:updated_on where id=:userId and email=:oldEmail";

    try{
        $handle = $pdo->prepare($sql);
        $params = [
            ':oldEmail'=>$oldEmail,
            ':newEmail'=>$newEmail,
            ':userId'=>$userId,
            ':updated_on'=>$date
        ];


        if ( $handle->execute($params) && $handle->rowCount() > 0) {
            header('Content-Type: application/json; charset=utf-8');
            $data = array("Status"=>"Success");
            echo json_encode($data);
        } else {
            header('Content-Type: application/json; charset=utf-8');
            $data = array("Status"=>"Empty");
            echo json_encode($data);
        }


    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
}
else
{
    echo "fail";

}