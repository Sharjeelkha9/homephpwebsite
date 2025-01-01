<?php
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
?>