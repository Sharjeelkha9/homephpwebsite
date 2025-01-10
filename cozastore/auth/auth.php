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
            alert('logged in User Successfully');
            location.assign('index.php')
            </script>";
        }else{
            echo "<script>
            alert('logged in Admin Successfully');
            location.assign('../dashmin/index.php');
            </script>";
        }

    }
}


// add to cart
if(isset($_POST['AddToCart'])){
    $pId = $_POST['proId'];
    $pName = $_POST['proname'];
    $pQuantity = $_POST['proquantity'];
    $pPrice = $_POST['proprice'];
    $pImage = $_POST['proimage'];
if(isset($_SESSION['cart'])){
    $checkData = false;
foreach($_SESSION['cart'] as $keys => $values){
if($values['proid']==$pId){
   $_SESSION['cart'][$keys]['proquantity'] +=$pQuantity;
   echo "<script>
   alert('Quantity Added');
   </script>";
    $checkData = true;
}
}
if(!$checkData){

        $count = count($_SESSION['cart']);
    //    echo "<script>alert('".$count."')</script>";
    $_SESSION['cart'][$count] =array(
        "proid"=>$pId,
        "proname"=>$pName,
        "proimage"=>$pImage,
        "proprice"=>$pPrice,
        "proquantity"=>$pQuantity
    );
    echo "<script>
    alert('Product Add into Cart');
    </script>";
    
}

}else{
    $_SESSION['cart'][0]=array(
                                "proid"=>$pId,
                                "proname"=>$pName,
                                "proimage"=>$pImage,
                                "proprice"=>$pPrice,
                                "proquantity"=>$pQuantity
                            );
                            echo "<script>
                            alert('Product Add into Cart');
                            </script>";
}

}
// delete cart item
if(isset($_GET['remove'])){
    $pid = $_GET['remove'];
    foreach($_SESSION['cart'] as $keys => $values){
        if($values['proid']==$pid){
            unset($_SESSION['cart'][$keys]);
            $_SESSION['cart']=array_values($_SESSION['cart']);
            echo "<script>
            alert('Item Remove From Cart');
            location.assign('shoping-cart.php');
            </script>";
        }
    }
}


//  order palce
if(isset($_POST['orderPlace'])){
    $uid = $_SESSION['userid'];
    $uname = $_POST['name'];
    $uemail = $_POST['email'];
    $unumber = $_POST['number'];
    $uaddress = $_POST['address'];
    date_default_timezone_set("Asia/Karachi");
    $currentTime = time();
    $date = date("Y-m-d H:i:s",$currentTime);
    $time = date("H:i:s",strtotime($date));
    // echo "<script>alert('".$time."')</script>";
    $total = 0;
    $productQuantity = 0;
    $itemCount =1;
    $subTotal = 0;
    foreach($_SESSION['cart'] as $key => $val){
$productQuantity += $val['proquantity'];
$itemCount += $key; 

        $total = $val['proquantity']*$val['proprice'];
        $subTotal +=$total;
        $query = $pdo ->prepare("INSERT INTO `orders`( `userid`, `useremail`, `userphone`, `useraddress`, `username`, `productname`, `productprice`, `productquantity`, `producttotal`, `productimage`, `orderdate`, `ordertime`) VALUES(:ui,:ue,:up,:ua,:un,:pn,:pp,:pq,:pt,:pi,:od,:ot)");
        $query->bindParam("ui",$uid);
        $query->bindParam("ue",$uemail);
        $query->bindParam("up",$unumber);
        $query->bindParam("ua",$uaddress);
        $query->bindParam("un",$uname);
        $query->bindParam("pn",$val['proname']);
        $query->bindParam("pp",$val['proprice']);
        $query->bindParam("pq",$val['proquantity']);
        $query->bindParam("pt",$total);
        $query->bindParam("pi",$val['proimage']);
        $query->bindParam("od",$date);
        $query->bindParam("ot",$time);

$query->execute();
    }

$queryInvoivce = $pdo->prepare("INSERT INTO `invoices`( `username`, `useremail`, `totalproductquantity`, `itemcount`, `subtotal`, `invoicedate`, `invoicetime`, `userphone`) VALUES(:inn,:ie,:tpq,:ic,:sb,:dd,:dt,:ip)");
$queryInvoivce->bindParam("inn",$uname);
$queryInvoivce->bindParam("ie",$uemail);
$queryInvoivce->bindParam("tpq",$productQuantity);
$queryInvoivce->bindParam("ic",$itemCount);
$queryInvoivce->bindParam("sb",$subTotal);
$queryInvoivce->bindParam("dd",$date);
$queryInvoivce->bindParam("dt",$time);
$queryInvoivce->bindParam("ip",$unumber);
$queryInvoivce->execute();
 unset($_SESSION['cart']);
    echo "<script>alert('Order Placed Successfully');
    location.assign('index.php');
    </script>";
}

?>