<?php
require_once('../../config.php');

if(isset($_POST['habit_id'],$_POST['habit_name']) && !empty($_POST['habit_id'])  && !empty($_POST['habit_name']))
{

    $habitId = $_POST['habit_id'];
    $habit_name = $_POST['habit_name'];

    $date = date('Y-m-d');

    $sql = "update habits set name=:hbname, updated_on=:updated_on where id=:hbtid";

    try{
        $handle = $pdo->prepare($sql);
        $params = [
            ':hbtid'=>$habitId,
            ':hbname'=>$habit_name,
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