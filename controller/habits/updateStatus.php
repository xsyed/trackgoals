<?php
require_once('../../config.php');

if(isset($_POST['habit_id'],$_POST['status']) && !empty($_POST['habit_id'])  && !empty($_POST['status']))
{

    $habitId = $_POST['habit_id'];
    $status = $_POST['status'];

    $date = date('Y-m-d');

    $sql = "insert into habitlog (habit_id, status, created_on,updated_on) values(:hbtid,:status,:created_on,:updated_on)";

    try{
        $handle = $pdo->prepare($sql);
        $params = [
            ':hbtid'=>$habitId,
            ':status'=>$status,
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
echo "fail";

}