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
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the email exists in the `users` table
    $query = $pdo->prepare("SELECT * FROM users WHERE user_email = :ue");
    $query->bindParam("ue", $email);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);

    // If not found in users, check the `employees` table
    if (!$row) {
        $query = $pdo->prepare("SELECT * FROM employee WHERE empemail = :ee");
        $query->bindParam("ee", $email);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $isEmployee = true; // To distinguish employees
    } else {
        $isEmployee = false;
    }

    // Verify the password
    if ($row && password_verify($password, $row[$isEmployee ? 'emppassword' : 'user_password'])) {
        // Set session variables
        $_SESSION['userid'] = $row[$isEmployee ? 'empid' : 'user_id'];
        $_SESSION['username'] = $row[$isEmployee ? 'empname' : 'user_name'];
        $_SESSION['useremail'] = $row[$isEmployee ? 'empemail' : 'user_email'];
        $_SESSION['usernumber'] = $row[$isEmployee ? 'empphone' : 'user_phone']; // Add user number
        $_SESSION['usertype'] = $isEmployee ? 'employee' : $row['user_role_type'];

        // Redirect based on user type
        if ($_SESSION['usertype'] === "user") {
            echo "<script>
                alert('Logged in User Successfully');
                location.assign('index.php');
            </script>";
        } elseif ($_SESSION['usertype'] === "admin") {
            echo "<script>
                alert('Logged in Admin Successfully');
                location.assign('../dashmin/categories.php');
            </script>";
        } elseif ($_SESSION['usertype'] === "employee") {
            echo "<script>
                alert('Logged in Employee Successfully');
                location.assign('../dashmin/order.php'); // Change to employee dashboard URL
            </script>";
        }
    } else {
        echo "<script>alert('Invalid email or password');</script>";
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
    $uaddress = trim($_POST['address']);
    $order_type = $_POST['order_type'];
    $payment_method = $_POST['payment_method'];

    // Assign order type digit
    $orderTypeDigit = ($order_type == "Home Delivery") ? "1" : "2";

    if ($order_type === "Home Delivery" && empty($uaddress)) {
        echo "<script>alert('Please enter your address for Home Delivery');</script>";
    } else {
        date_default_timezone_set("Asia/Karachi");
        $currentTime = time();
        $date = date("Y-m-d H:i:s", $currentTime);
        $time = date("H:i:s", strtotime($date));

        $total = 0;
        $productQuantity = 0;
        $itemCount = 1;
        $subTotal = 0;
        $orderNumbers = [];

        foreach ($_SESSION['cart'] as $key => $val) {
            $productQuantity += $val['proquantity'];
            $itemCount += $key;
            $total = $val['proquantity'] * $val['proprice'];
            $subTotal += $total;

            // Generate 16-digit unique Order Number
            $productId = str_pad($val['proid'], 7, "0", STR_PAD_LEFT); // Ensure it's 7 digits
            $randomOrderNum = mt_rand(10000000, 99999999); // Generate random 8-digit number
            $orderNumber = $orderTypeDigit . $productId . $randomOrderNum; // Combine to form 16-digit order number
            $orderNumbers[] = $orderNumber; // Store order numbers for invoices

            // Insert order into database
            $query = $pdo->prepare("INSERT INTO `orders`(`userid`, `useremail`, `userphone`, `useraddress`, `username`, `productname`, `productprice`, `productquantity`, `producttotal`, `productimage`, `orderdate`, `ordertime`, `order_type`, `payment_method`, `order_number`) 
                                    VALUES(:ui, :ue, :up, :ua, :un, :pn, :pp, :pq, :pt, :pi, :od, :ot, :otyper, :pmethod, :ordernum)");
            $query->bindParam("ui", $uid);
            $query->bindParam("ue", $uemail);
            $query->bindParam("up", $unumber);
            $query->bindParam("ua", $uaddress);
            $query->bindParam("un", $uname);
            $query->bindParam("pn", $val['proname']);
            $query->bindParam("pp", $val['proprice']);
            $query->bindParam("pq", $val['proquantity']);
            $query->bindParam("pt", $total);
            $query->bindParam("pi", $val['proimage']);
            $query->bindParam("od", $date);
            $query->bindParam("ot", $time);
            $query->bindParam("otyper", $order_type);
            $query->bindParam("pmethod", $payment_method);
            $query->bindParam("ordernum", $orderNumber);
            $query->execute();
        }

        // Convert multiple order numbers into a comma-separated string
        $orderNumbersString = implode(',', $orderNumbers);

        // Insert into invoices table
        $queryInvoice = $pdo->prepare("INSERT INTO `invoices`(`username`, `useremail`, `totalproductquantity`, `itemcount`, `subtotal`, `invoicedate`, `invoicetime`, `userphone`, `order_type`, `payment_method`, `order_numbers`) 
                                        VALUES(:inn, :ie, :tpq, :ic, :sb, :dd, :dt, :ip, :otyper, :pmethod, :ordernums)");
        $queryInvoice->bindParam("inn", $uname);
        $queryInvoice->bindParam("ie", $uemail);
        $queryInvoice->bindParam("tpq", $productQuantity);
        $queryInvoice->bindParam("ic", $itemCount);
        $queryInvoice->bindParam("sb", $subTotal);
        $queryInvoice->bindParam("dd", $date);
        $queryInvoice->bindParam("dt", $time);
        $queryInvoice->bindParam("ip", $unumber);
        $queryInvoice->bindParam("otyper", $order_type);
        $queryInvoice->bindParam("pmethod", $payment_method);
        $queryInvoice->bindParam("ordernums", $orderNumbersString);
        $queryInvoice->execute();

        unset($_SESSION['cart']);
        echo "<script>alert('Order Placed Successfully.); location.assign('index.php');</script>";
    }
}


//feedback
if (isset($_POST['feedback'])) {
    $email = $_POST['feedemail'];
    $msg = $_POST['feedmsg'];
    $query = $pdo->prepare("insert into feedback(feedbackemail,feedbackmsg) values (:fe,:fm)");
            $query->bindParam("fe", $email);
            $query->bindParam("fm", $msg);
            $query->execute();
            echo "<script>alert('Feedback Submitted Successfully')</script>";

};
//change password


?>