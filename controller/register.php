<?php
session_start();
require_once('../config.php');

    if(isset($_POST['first_name'],$_POST['email'],$_POST['password']) && !empty($_POST['first_name'])  && !empty($_POST['email']) && !empty($_POST['password']))
    {

        $firstName = trim($_POST['first_name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $options = array("cost"=>4);
        $hashPassword = password_hash($password,PASSWORD_BCRYPT,$options);
        $date = date('Y-m-d H:i:s');

        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $sql = 'select * from users where email = :email';
            $stmt = $pdo->prepare($sql);
            $p = ['email'=>$email];
            $stmt->execute($p);

            if($stmt->rowCount() == 0)
            {
                $sql = "insert into users (firstname, email, `password`, created_at,updated_on,`photo`) values(:fname,:email,:pass,:created_at,:updated_at,'default.png')";

                try{
                    $handle = $pdo->prepare($sql);
                    $params = [
                        ':fname'=>$firstName,
                        ':email'=>$email,
                        ':pass'=>$hashPassword,
                        ':created_at'=>$date,
                        ':updated_at'=>$date
                    ];


                    $handle->execute($params);

                    $success = 'User has been created successfully';
                    echo "Success";
                }
                catch(PDOException $e){
                    $errors[] = $e->getMessage();
                    echo $e->getMessage();
                }
            }
            else
            {
                $valFirstName = $firstName;
                $valEmail = '';
                $valPassword = $password;

                echo "Email address already registered";
            }
        }
        else
        {
            echo "Email address is not valid";
        }
    }
    else
    {
        if(!isset($_POST['first_name']) || empty($_POST['first_name']))
        {
            echo "Name is required";
        }
        else
        {
            $valFirstName = $_POST['first_name'];
        }

        if(!isset($_POST['email']) || empty($_POST['email']))
        {
            echo "Email is required";
        }
        else
        {
            $valEmail = $_POST['email'];
        }

        if(!isset($_POST['password']) || empty($_POST['password']))
        {
            echo "Password is required";
        }
        else
        {
            $valPassword = $_POST['password'];
        }

    }