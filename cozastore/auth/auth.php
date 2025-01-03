<?php
session_start();
include("connection.php");
$cataddress = "../dashmin/img/categories/";
$proaddress = "../dashmin/img/products/";

if(isset($_POST['registration'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $number = $_POST['number'];
    $hashpassword = password_hash($password,PASSWORD_DEFAULT);
    $query = $pdo->prepare ("insert into users(user_name,user_email,user_password,user_phone) values (:un,:ue,:up,:upp)");
    $query -> bindParam(":un",$name);
    $query -> bindParam(":ue",$email);
    $query -> bindParam(":up",$hashpassword);
    $query -> bindParam(":upp",$number);
    $query -> execute();
    echo ("<script>alert('Account Registered Successfully')</script>");
}

//login
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = $pdo->prepare("select * from users where user_email = :ue");
    $query->bindParam("ue",$email);
    $query -> execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    if(password_verify($password,$row['user_password'])){
        $_SESSION['userid']= $row['user_id'];
        $_SESSION['username']= $row['user_name'];
        $_SESSION['useremail']= $row['user_email'];
        $_SESSION['userpassword']= $row['user_password'];
        $_SESSION['usernumber']= $row['user_phone'];
        $_SESSION['usertype']= $row['user_role_type'];
        if($_SESSION['usertype']=="user"){
            echo "<script>
            alert('logged in user successfully');
            location.assign('index.php')
            </script>";
        }else{
            echo "<script>
            alert('logged in admin successfully');
            location.assign('../dashmin/index.php');
            </script>";
        }

    }
}

?>