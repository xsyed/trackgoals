<?php
require_once('../../config.php');

if(isset($_GET['habit_id'])  && !empty($_GET['habit_id']))
{

    $habitId = $_GET['habit_id'];

    $sql = "select year(created_on) as year,month(created_on) as month,count(*) as count
             from habitlog
             where habit_id=:hbtId
             group by year(created_on),month(created_on)
             order by year(created_on),month(created_on)";

    try{
        $handle = $pdo->prepare($sql);

        $params = ['hbtId'=>$habitId];

        $handle->execute($params);

        if($handle->rowCount() > 0) {
            $getRow = $handle->fetchAll();
            header('Content-Type: application/json; charset=utf-8');
            $data = [];
            $c = 0;
            foreach ($getRow as $oneRow){
                $data[$c] = ["year"=>$oneRow["year"],"month"=>$oneRow["month"],"count"=>$oneRow["count"]];
                $c++;
            }
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


