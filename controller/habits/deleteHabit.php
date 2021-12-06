<?php
require_once('../../config.php');

if($_POST['habit_id'] && !empty($_POST['habit_id']) !== null)
{

    $habitId = $_POST['habit_id'];


    $sql = "Delete from habits where id=:hbtid";

    try{
        $handle = $pdo->prepare($sql);
        $params = [
            ':hbtid'=>$habitId
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