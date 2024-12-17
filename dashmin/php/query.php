<?php
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
                $query = $pdo->prepare("update categories set name = :catName, image = :catImage where id = :catid");
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
        $query = $pdo->prepare("update categories set name = :catName where id = :catid");
        $query->bindParam("catid", $id);
        $query->bindParam("catName", $name);
        $query->execute();
        echo "<script>alert('Data Updated Successfully')</script>";
    }
}

//delete category

if (isset($_POST['deleteCategory'])) {
    $id = $_POST['catid'];
    $query = $pdo->prepare("delete from categories where id = :catid");
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
