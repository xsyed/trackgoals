<?php
require_once('../../config.php');



if( isset($_POST['userId'],$_FILES['file']['name']) && !empty($_POST['userId']))
{

    $name = $_FILES['file']['name'];
    $target_dir = dirname(__FILE__,3)."/template/profileimages/";

    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $imgExt = pathinfo($target_file,PATHINFO_EXTENSION);
    $imageFileType = strtolower($imgExt);

    // Valid file extensions
    $extensions_arr = array("jpg","jpeg","png","gif");

    $userId = $_POST['userId'];
    $date = date('Y-m-d');
    $milliseconds = round(microtime(true) * 1000);

    if(in_array($imageFileType,$extensions_arr) ){

        try{
            $sql = "update users set photo=:filename, updated_on=:updated_on where id=:userId";
            $handle = $pdo->prepare($sql);

            $params = [
                ':filename'=>"profile_pic_".$userId.$date.$milliseconds.".".$imgExt,
                ':userId'=>$userId,
                ':updated_on'=>$date
            ];

            if ($handle->execute($params) && $handle->rowCount() > 0 && move_uploaded_file($_FILES['file']['tmp_name'],$target_dir."profile_pic_".$userId.$date.$milliseconds.".".$imgExt)) {
                header('Content-Type: application/json; charset=utf-8');
                $data = array("Status"=>"Success");
                echo json_encode($data);
            } else {
                header('Content-Type: application/json; charset=utf-8');
                $data = array("Status"=>"Empty");
                echo json_encode($data);
            }


        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }


}
else
{
    echo "fail";

}