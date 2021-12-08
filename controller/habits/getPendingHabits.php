<?php
require_once('../../config.php');

if(isset($_GET['userId'],$_GET['onDate']) && !empty($_GET['userId']) && !empty($_GET['onDate']))
{
    $userId = $_GET['userId'];
    $onDate = $_GET['onDate'];

    $info = getdate();
    $date = $info['mday'];
    $month = $info['mon'];
    $year = $info['year'];

    $currDate = "$year-$month-$date";

    if($onDate == $currDate){
        $sql = "SELECT * FROM habits h
            WHERE NOT EXISTS 
                (SELECT * FROM habitlog l 
					WHERE h.id = l.habit_id 
					and l.created_on = :ondate
				 ) 
            and h.userId = :userId";

        try{
            $handle = $pdo->prepare($sql);

            $params = [
                'ondate'=>$onDate,
                'userId'=>$userId];

            $handle->execute($params);

            if($handle->rowCount() > 0) {
                $getRow = $handle->fetchAll();
                header('Content-Type: application/json; charset=utf-8');
                $data = [];
                $c = 0;
                foreach ($getRow as $oneRow){
                    $data[$c] = ["name"=>$oneRow["name"],"habit_id"=>$oneRow["id"],"color"=>$oneRow["color"]];
                    $c++;
                }
                echo json_encode($data);
                //echo "Seccues";
            } else{
                header('Content-Type: application/json; charset=utf-8');
                $data = ["Status"=>"Empty","fordate"=>$currDate];
                echo json_encode($data);
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    } else {
        header('Content-Type: application/json; charset=utf-8');
        $data = ["Status"=>"Empty","fordate"=>$currDate];
        echo json_encode($data);
    }


}
else
{
    echo  "Habit name is required";
}


