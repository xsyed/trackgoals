<?php
require_once('../../config.php');

if(isset($_GET['habit_id'])  && !empty($_GET['habit_id']))
{

    $habitId = $_GET['habit_id'];

    $sql = "Select *, COUNT(*) as total from habitlog
            inner join habits on habits.id=habitlog.habit_id
            where habitlog.habit_id=:hbtId";

    try{
        $handle = $pdo->prepare($sql);

        $params = ['hbtId'=>$habitId];

        $handle->execute($params);

        if($handle->rowCount() > 0) {
            $getRow = $handle->fetchAll();
            header('Content-Type: application/json; charset=utf-8');
            $data = array("name"=>$getRow[0]["name"],"total"=>$getRow[0]["total"]);
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


