<?php
require_once('../../config.php');

if( isset($_POST['oldPass'],$_POST['newPass'],$_POST['userId']) && !empty($_POST['userId']) && !empty($_POST['oldPass'])  && !empty($_POST['newPass']))
{

    $userId = $_POST['userId'];
    $oldPass = $_POST['oldPass'];
    $newPass = $_POST['newPass'];

    $date = date('Y-m-d');

    try{
        $sql = "select * from users where id = :userId ";
        $handle = $pdo->prepare($sql);
        $params = ['userId'=>$userId];

        $handle->execute($params);

        if($handle->rowCount() > 0)
        {
            $getRow = $handle->fetch(PDO::FETCH_ASSOC);
            if(password_verify($oldPass, $getRow['password']))
            {
                $newPassword = trim($newPass);

                $options = array("cost"=>4);
                $hashPassword = password_hash($newPassword,PASSWORD_BCRYPT,$options);

                $sql = "update users set password=:newPass, updated_on=:updated_on where id=:userId";

                $handle = $pdo->prepare($sql);
                $params = [
                    ':newPass'=>$hashPassword,
                    ':userId'=>$userId,
                    ':updated_on'=>$date
                ];

                if ($handle->execute($params) && $handle->rowCount() > 0) {
                    header('Content-Type: application/json; charset=utf-8');
                    $data = array("Status"=>"Success");
                    echo json_encode($data);
                } else {
                    header('Content-Type: application/json; charset=utf-8');
                    $data = array("Status"=>"Empty","Message"=>"Oops! Something went wrong!");
                    echo json_encode($data);
                }

            } else {
                header('Content-Type: application/json; charset=utf-8');
                $data = array("Status"=>"Error","Message"=>"Password not matched!");
                echo json_encode($data);
            }
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