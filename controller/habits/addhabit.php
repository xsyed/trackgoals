<?php
require_once('../../config.php');

if(isset($_POST['habit_name'],$_POST['userId']) && !empty($_POST['habit_name']) && !empty($_POST['userId']))
{
    $habit_name = trim($_POST['habit_name']);
    $userId = $_POST['userId'];
    $date = date('Y-m-d H:i:s');
    $sql = "insert into habits (name, userId, created_on, updated_on) values(:hname,:userId,:created_on,:updated_on)";

    try{
        $handle = $pdo->prepare($sql);
        $params = [
            ':hname'=>$habit_name,
            ':userId'=>$userId,
            ':created_on'=>$date,
            ':updated_on'=>$date
        ];

        $handle->execute($params);

        echo "Success";
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
}
else
{
    echo  "Habit name is required";
}


