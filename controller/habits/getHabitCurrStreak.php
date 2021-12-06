<?php
require_once('../../config.php');

if(isset($_GET['habit_id'])  && !empty($_GET['habit_id']))
{
    $habitId = $_GET['habit_id'];

    $sql = "SELECT COUNT(*) max_streak 
              FROM 
                 ( SELECT x.*
                        , CASE WHEN @prev = created_on - INTERVAL 1 DAY THEN @i:=@i ELSE @i:=@i+1 END i
                        , @prev:=created_on  
                     FROM 
                        ( SELECT DISTINCT created_on FROM habitlog where habit_id=:hbtId and status=1) x
                     JOIN 
                        ( SELECT @prev:=null,@i:=0 ) vars 
                    ORDER 
                       BY created_on
                 ) a 
             GROUP 
                BY i 
             ORDER 
                BY max_streak";

    try{
        $handle = $pdo->prepare($sql);

        $params = ['hbtId'=>$habitId];

        $handle->execute($params);

        if($handle->rowCount() > 0) {
            $getRow = $handle->fetchAll();
            header('Content-Type: application/json; charset=utf-8');
            $data = array("streak"=>$getRow[0]["max_streak"]);
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


