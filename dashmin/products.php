<?php
include "components/header.php";
?>
<!-- Blank Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row bg-light rounded mx-0">
        <div class="col-lg-12">
            <button type="button" class="btn btn-primary m-2" data-bs-toggle="modal" data-bs-target="#addproduct">Add Products</button>
        </div>
        
        <?php
$query = $pdo->query("SELECT `products`.*, `categories`.`name` as catname
    FROM `products` 
    INNER JOIN `categories` ON `products`.`categoryid` = `categories`.`ctid`;");
$rows = $query->fetchAll(PDO::FETCH_ASSOC);

if (empty($rows)) {
    echo "<h3 class='text-center'>Products not found in the table</h3>";
} else {
    ?>
    <div class="col-md-6 my-3 mx-3">
            <h3>ADD PRODUCTS</h3>
        </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Description</th>
                <th scope="col">Product Category Name</th>
                <th scope="col" colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($rows as $keys) {
                ?>
                <tr>
                    <th scope="row"><img src="<?php echo $productimagesaddress . $keys['image']; ?>" alt="" width="80" srcset=""></th>
                    <td><?php echo $keys['name']; ?></td>
                    <td><?php echo $keys['price']; ?></td>
                    <td><?php echo $keys['quantity']; ?></td>
                    <td><?php echo $keys['description']; ?></td>
                    <td><?php echo $keys['catname']; ?></td>
                    <td><a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#updateproduct<?php echo $keys['id']; ?>">Edit</a></td>
                    <td><a href="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#prodelete<?php echo $keys['id']; ?>">Delete</a></td>
                </tr>
                <!-- Delete Products Modal -->
                <div class="modal fade" id="prodelete<?php echo $keys['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">DELETE PRODUCTS</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="proid" value="<?php echo $keys['id']; ?>">
                                    <button type="submit" name="deleteProducts" class="btn btn-danger">Delete Products</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Update Products Modal -->
                <div class="modal fade" id="updateproduct<?php echo $keys['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">UPDATE PRODUCTS</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <input type="hidden" name="proid" value="<?php echo $keys['id']; ?>">
                                        <label for="productName" class="form-label">Product Name</label>
                                        <input type="text" name="productName" value="<?php echo $keys['name']; ?>" class="form-control" id="productName">
                                    </div>
                                    <div class="mb-3">
                                        <label for="productPrice" class="form-label">Product Price</label>
                                        <input type="text" name="productprice" value="<?php echo $keys['price']; ?>" class="form-control" id="productPrice">
                                    </div>
                                    <div class="mb-3">
                                        <label for="productQuantity" class="form-label">Product Quantity</label>
                                        <input type="text" name="productquantity" value="<?php echo $keys['quantity']; ?>" class="form-control" id="productQuantity">
                                    </div>
                                    <div class="mb-3">
                                        <label for="prodesc" class="form-label">Description</label>
                                        <textarea class="form-control" name="prodesc" id="prodesc" rows="3"><?php echo $keys['description']; ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="productImage" class="form-label">Product Image</label>
                                        <input type="file" name="productImage" class="form-control" id="productImage">
                                        <img class="mt-3" src="<?php echo $productimagesaddress . $keys['image']; ?>" width="90" alt="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="cateid" class="form-label">Product Category</label>
                                        <select class="form-select" name="cateid" id="cateid">
                                            <option selected>Select Category</option>
                                            <?php
                                            $categoryQuery = $pdo->query("SELECT * FROM categories");
                                            $categories = $categoryQuery->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($categories as $catkeys) {
                                            ?>
                                                <option value="<?php echo $catkeys['ctid']; ?>" <?php echo $keys['categoryid'] == $catkeys['ctid'] ? 'selected' : ''; ?>>
                                                    <?php echo $catkeys['name']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" name="updateProducts" class="btn btn-primary">Update Products</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?php
}
?>

    </div>
</div>
<!-- Blank End -->

<!-- add Products Modal -->
<div class="modal fade" id="addproduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">ADD PRODUCTS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Product Name</label>
                        <input type="text" name="productName" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Product Price</label>
                        <input type="text" name="productprice" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Product Quantity</label>
                        <input type="text" name="productquantity" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Products Image</label>
                        <input type="file" name="productImage" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Enter some text here</label>
                        <textarea class="form-control" name="prodesc" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Product Category</label>
                        <select class="form-select" id="floatingSelect" name="cateid" aria-label="Floating label select example">
                            <option selected>Select Category</option>
                            <?php
                            $query = $pdo->query("SELECT * FROM categories");
                            $rows = $query->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($rows as $keys) {
                            ?>
                                <option value="<?php echo $keys['ctid']; ?>"><?php echo $keys['name']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" name="addProducts" class="btn btn-primary">Add Products</button>
                </form>
            </div>

        </div>
    </div>
</div>


<?php
include "components/footer.php";
?>