<?php
session_start();
include "connection.php";
$catimagesaddress = "img/categories/";
$productimagesaddress = "img/products/";
//add Category 

if (isset($_POST['addCategory'])) {
    $name = $_POST['catName'];
    $imagename = $_FILES['catImage']['name'];
    $imageobject = $_FILES['catImage']['tmp_name'];
    $extension = pathinfo($imagename, PATHINFO_EXTENSION);
    $pathdirectory = "img/categories/". $imagename;
    if ($extension == "jpg" || $extension == "png" || $extension == "jpeg" || $extension == "webp") {
        if (move_uploaded_file($imageobject, $pathdirectory)) {
            //query Prepration
            $query = $pdo->prepare("insert into categories(name,image) values (:pn,:pimg)");
            $query->bindParam("pn", $name);
            $query->bindParam("pimg", $imagename);
            $query->execute();
            echo "<script>alert('Data Submitted Successfully')</script>";
        }
    } else {
        echo "<script>alert('Invalid file type use only jpg, jpeg, png or webp')</script>";
    }
}

//update category
if (isset($_POST['updateCategory'])) {
    $name = $_POST['catName'];
    $id = $_POST['catid'];
    if (!empty($_FILES['catImage']['name'])) {
        $imagename = $_FILES['catImage']['name'];
        $imageobject = $_FILES['catImage']['tmp_name'];
        $extension = pathinfo($imagename, PATHINFO_EXTENSION);
        $pathdirectory = "img/categories/" . $imagename;
        if ($extension == "jpg" || $extension == "png" || $extension == "jpeg" || $extension == "webp") {
            if (move_uploaded_file($imageobject, $pathdirectory)) {
                //query Prepration
                $query = $pdo->prepare("update categories set name = :catName, image = :catImage where ctid = :catid");
                $query->bindParam("catid", $id);
                $query->bindParam("catName", $name);
                $query->bindParam("catImage", $imagename);
                $query->execute();
                echo "<script>alert('Data Updated Successfully')</script>";
            }
        } else {
            echo "<script>alert('Invalid file type use only jpg, jpeg, png or webp')</script>";
        }
    } else {
        $query = $pdo->prepare("update categories set name = :catName where ctid = :catid");
        $query->bindParam("catid", $id);
        $query->bindParam("catName", $name);
        $query->execute();
        echo "<script>alert('Data Updated Successfully')</script>";
    }
}

//delete category

if (isset($_POST['deleteCategory'])) {
    $id = $_POST['catid'];
    $query = $pdo->prepare("delete from categories where ctid = :catid");
    $query->bindParam("catid", $id);
    $query->execute();
    echo "<script>alert('Data Deleted Successfully')</script>";
}
//add Products 

if (isset($_POST['addProducts'])) {
    $name = $_POST['productName'];
    $price = $_POST['productprice'];
    $quantity = $_POST['productquantity'];
    $description = $_POST['prodesc'];
    $categoryid = $_POST['cateid'];
    $imagename = $_FILES['productImage']['name'];
    $imageobject = $_FILES['productImage']['tmp_name'];
    $extension = pathinfo($imagename, PATHINFO_EXTENSION);
    $pathdirectory = "img/products/" . $imagename;
    if ($extension == "jpg" || $extension == "png" || $extension == "jpeg" || $extension == "webp") {
        if (move_uploaded_file($imageobject, $pathdirectory)) {
            //query Prepration
            $query = $pdo->prepare("insert into products(name,image,price,quantity,description,categoryid) values (:pn,:pimg,:pprice,:pquantity,:pd,:cid)");
            $query->bindParam("pn", $name);
            $query->bindParam("pimg", $imagename);
            $query->bindParam("pprice", $price);
            $query->bindParam("pquantity", $quantity);
            $query->bindParam("pd", $description);
            $query->bindParam("cid", $categoryid);
            $query->execute();
            echo "<script>alert('Data Submitted Successfully')</script>";
        }
    } else {
        echo "<script>alert('Invalid file type use only jpg, jpeg, png or webp')</script>";
    }
}


//delete products

if (isset($_POST['deleteProducts'])) {
    $id = $_POST['proid'];
    $query = $pdo->prepare("delete from products where id = :proid");
    $query->bindParam("proid", $id);
    $query->execute();
    echo "<script>alert('Data Deleted Successfully')</script>";
}

//update products

if (isset($_POST['updateProducts'])) {
    $id = $_POST['proid'];
    $name = $_POST['productName'];
    $price = $_POST['productprice'];
    $quantity = $_POST['productquantity'];
    $description = $_POST['prodesc'];
    $categoryid = $_POST['cateid'];
    if (!empty($_FILES['productImage']['name'])) {
        $imagename = $_FILES['productImage']['name'];
        $imageobject = $_FILES['productImage']['tmp_name'];
        $extension = pathinfo($imagename, PATHINFO_EXTENSION);
        $pathdirectory = "img/products/" . $imagename;
        if ($extension == "jpg" || $extension == "png" || $extension == "jpeg" || $extension == "webp") {
            if (move_uploaded_file($imageobject, $pathdirectory)) {
                $query = $pdo->prepare("update products set name = :pName, price = :pprice, quantity = :pquantity, description = :pd, image = :pImage, categoryid = :cid where id = :proid");
                $query->bindParam("proid", $id);
                $query->bindParam("pName", $name);
                $query->bindParam("pprice", $price);
                $query->bindParam("pquantity", $quantity);
                $query->bindParam("pd", $description);
                $query->bindParam("pImage", $imagename);
                $query->bindParam("cid", $categoryid);
                $query->execute();
                echo "<script>alert('Data Updated Successfully')</script>";
            }
        } else {
            echo "<script>alert('Invalid file type. Use only jpg, jpeg, png, or webp')</script>";
        }
    } else {
        $query = $pdo->prepare("update products set name = :pName, price = :pprice, quantity = :pquantity, description = :pd, categoryid = :cid where id = :proid");
        $query->bindParam("proid", $id);
        $query->bindParam("pName", $name);
        $query->bindParam("pprice", $price);
        $query->bindParam("pquantity", $quantity);
        $query->bindParam("pd", $description);
        $query->bindParam("cid", $categoryid);
        $query->execute();
        echo "<script>alert('Data Updated Successfully')</script>";
    }
}
//add employee
if (isset($_POST['addEmployee'])) {
    $name = $_POST['empName'];
    $email = $_POST['empEmail'];
    $phone = $_POST['empPhone'];
    $pass = $_POST['empPass'];
    $userrole = $_POST['empRole'];

    // Hash the password before storing it
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

    try {
        // Insert into the employee table
        $query = $pdo->prepare("INSERT INTO employee (empname, empemail, empphone, emppass) VALUES (:en, :ee, :epp, :ep)");
        $query->bindParam(":en", $name);
        $query->bindParam(":ee", $email);
        $query->bindParam(":epp", $phone);
        $query->bindParam(":ep", $hashedPassword);
        $query->execute();

        // Insert into the users table
        $query = $pdo->prepare("INSERT INTO users (user_name, user_email, user_phone, user_password, user_role_type) VALUES (:en, :ee, :epp, :ep, :urt)");
        $query->bindParam(":en", $name);
        $query->bindParam(":ee", $email);
        $query->bindParam(":epp", $phone);
        $query->bindParam(":ep", $hashedPassword);
        $query->bindParam(":urt", $userrole);
        $query->execute();

        echo "<script>alert('Employee Added Successfully');</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error Adding Employee: " . $e->getMessage() . "');</script>";
    }
};
//update employee
if (isset($_POST['updateEmployee'])){
    $name = $_POST['empName'];
    $id = $_POST['empid'];
    $email = $_POST['empEmail'];
    $phone = $_POST['empPhone'];
    $pass = $_POST['empPass'];
    $query = $pdo->prepare("update employee set empname = :empName, empemail = :empEmail, empphone = :empPhone, emppass = :empPass where empid = :empid");
                $query->bindParam("empid", $id);
                $query->bindParam("empName", $name);
                $query->bindParam("empEmail", $email);
                $query->bindParam("empPhone", $phone);
                $query->bindParam("empPass", $pass);
                $query->execute();
                echo "<script>alert('Employee Updated Successfully')</script>";
};
//delete employee

if (isset($_POST['deleteEmployee'])) {
    $id = $_POST['empid'];

    try {
        // Start a transaction to ensure both deletions are processed together
        $pdo->beginTransaction();

        // Step 1: Get the employee email before deleting from the employee table
        $query = $pdo->prepare("SELECT empemail FROM employee WHERE empid = :empid");
        $query->bindParam("empid", $id);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $empEmail = $row['empemail'];

            // Step 2: Delete the employee from the employee table
            $query = $pdo->prepare("DELETE FROM employee WHERE empid = :empid");
            $query->bindParam("empid", $id);
            $query->execute();

            // Step 3: Delete the corresponding user from the users table
            $query = $pdo->prepare("DELETE FROM users WHERE user_email = :email");
            $query->bindParam("email", $empEmail);
            $query->execute();

            // Commit the transaction
            $pdo->commit();
            echo "<script>alert('Employee Deleted Successfully');</script>";
        } else {
            echo "<script>alert('Employee not found');</script>";
        }
    } catch (Exception $e) {
        // Roll back the transaction in case of any error
        $pdo->rollBack();
        echo "<script>alert('Error deleting employee: " . $e->getMessage() . "');</script>";
    }
}


//delete order

if (isset($_POST['deleteOrder'])) {
    $id = $_POST['orderid'];
    $query = $pdo->prepare("delete from orders where orderid = :orderid");
    $query->bindParam("orderid", $id);
    $query->execute();
    echo "<script>alert('Order Deleted Successfully')</script>";
}
//delete feedback
if (isset($_POST['deleteFeedback'])) {
    $id = $_POST['feedbackid'];
    $query = $pdo->prepare("delete from feedback where feedbackid = :feedbackid");
    $query->bindParam("feedbackid", $id);
    $query->execute();
    echo "<script>alert('Feedback Deleted Successfully')</script>";
}
//delete invoice
if (isset($_POST['deleteInvoice'])) {
    $id = $_POST['invoiceid'];
    $query = $pdo->prepare("delete from invoices where invoiceid = :invoiceid");
    $query->bindParam("invoiceid", $id);
    $query->execute();
    echo "<script>alert('Invoice Deleted Successfully')</script>";
}
//change password


//update profile


