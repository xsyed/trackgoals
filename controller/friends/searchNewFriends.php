<?php
session_start();
require_once('../../config.php');


if(isset($_GET['searchQuery']) && !empty($_GET['searchQuery'])) {
    $searchQuery = $_GET['searchQuery'];
    $userId = $_SESSION["id"];

    try{
        $params =array($userId,$userId,$userId, "%$searchQuery%");

        $query = $pdo->prepare('SELECT * FROM users u
            WHERE NOT EXISTS 
                (SELECT * FROM `friends` WHERE (user_one=? AND user_two = u.id) OR (user_one = u.id AND user_two =?)
				 )
                 and u.id!=? and firstname like ?');


        $query->execute($params);

        if($query->rowCount() > 0) {
            $getRow = $query->fetchAll();
            header('Content-Type: application/json; charset=utf-8');
            $data = [];
            $c = 0;
            foreach ($getRow as $oneRow){
                $data[$c] = ["id"=>$oneRow["id"],"firstname"=>$oneRow["firstname"],"lastname"=>$oneRow["lastname"],"email"=>$oneRow["email"],"photo"=>$oneRow["photo"]];
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