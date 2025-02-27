<?php
include "components/header.php";
?>
<!-- Blank Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row bg-light rounded mx-0">
        <div class="col-md-6 my-3 mx-3">
            <h3>ORDERS</h3>
        </div>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Order Id</th>
                    <th scope="col">User Name</th>
                    <th scope="col">User Email</th>
                    <th scope="col">User Phone</th>
                    <th scope="col">User Address</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Product Price</th>
                    <th scope="col">Product Quantity</th>
                    <th scope="col">Total</th>
                    <th scope="col">Order Type</th>
                    <th scope="col">Payment Method</th>
                    <th scope="col">Order Number</th>
                    <th scope="col">Order Status</th>
                    <th scope="col" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = $pdo->query("select * from orders");
                $rows = $query->fetchALL(PDO::FETCH_ASSOC);
                foreach($rows as $keys){
                    ?>
                    <tr>
                    <td><?php echo $keys['orderid'] ?></td>
                    <td><?php echo $keys['username'] ?></td>
                    <td><?php echo $keys['useremail'] ?></td>
                    <td><?php echo $keys['userphone'] ?></td>
                    <td><?php echo $keys['useraddress'] ?></td>
                    <td><?php echo $keys['productname'] ?></td>
                    <td><?php echo $keys['productprice'] ?></td>
                    <td><?php echo $keys['productquantity'] ?></td>
                    <td><?php echo $keys['producttotal'] ?></td>
                    <td><?php echo $keys['order_type'] ?></td>
                    <td><?php echo $keys['payment_method'] ?></td>
                    <td><?php echo $keys['order_number'] ?></td>
                    <td><?php echo $keys['orderstatus'] ?></td>
                    <!-- <td><img src="<?php echo $productimagesaddress . $keys['image']; ?>" alt="" width="80" srcset=""></td> -->
                    <td><a href="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modeldelete<?php echo $keys['orderid'] ?>">Delete</td>
                </tr>
                    <!-- delete category Modal -->
<div class="modal fade" id="modeldelete<?php echo $keys['orderid'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">DELETE ORDER</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="orderid" value="<?php echo $keys['orderid'] ?>">
                    <button type="submit" name="deleteOrder" class="btn btn-danger">Delete Order</button>
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
    </div>
</div>
<!-- Blank End -->

<!-- add employee Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">ADD EMPLOYEE</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Employee Name</label>
                        <input type="text" name="empName" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Employee Email</label>
                        <input type="email" name="empEmail" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Employee Phone</label>
                        <input type="tel" name="empPhone" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Employee Password</label>
                        <input type="text" name="empPass" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                    </div>
                    <button type="submit" name="addEmployee" class="btn btn-primary">Add Employee</button>
                </form>
            </div>

        </div>
    </div>
</div>


<?php
include "components/footer.php";
?>