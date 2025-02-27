<?php
include "components/header.php";
?>
<!-- Blank Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row bg-light rounded mx-0">
        <div class="col-md-6 my-3 mx-3">
            <h3>INVOICES</h3>
        </div>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Invoice Id</th>
                    <th scope="col">User Name</th>
                    <th scope="col">User Email</th>
                    <th scope="col">User Phone</th>
                    <th scope="col">Total Product Quantity</th>
                    <th scope="col">Item Count</th>
                    <th scope="col">Sub Total</th>
                    <th scope="col">Order Type</th>
                    <th scope="col">Payment Method</th>
                    <th scope="col">Order Number</th>
                    <th scope="col">Invoice Date</th>
                    <th scope="col">Invoice Time</th>
                    <th scope="col" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = $pdo->query("select * from invoices");
                $rows = $query->fetchALL(PDO::FETCH_ASSOC);
                foreach($rows as $keys){
                    ?>
                    <tr>
                    <td><?php echo $keys['invoiceid'] ?></td>
                    <td><?php echo $keys['username'] ?></td>
                    <td><?php echo $keys['useremail'] ?></td>
                    <td><?php echo $keys['userphone'] ?></td>
                    <td><?php echo $keys['totalproductquantity'] ?></td>
                    <td><?php echo $keys['itemcount'] ?></td>
                    <td><?php echo $keys['subtotal'] ?></td>
                    <td><?php echo $keys['order_type'] ?></td>
                    <td><?php echo $keys['payment_method'] ?></td>
                    <td><?php echo $keys['order_numbers'] ?></td>
                    <td><?php echo $keys['invoicedate'] ?></td>
                    <td><?php echo $keys['invoicetime'] ?></td>

                    <td><a href="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modeldelete<?php echo $keys['invoiceid'] ?>">Delete</td>
                </tr>
                    <!-- delete feedback Modal -->
<div class="modal fade" id="modeldelete<?php echo $keys['invoiceid'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">DELETE INVOICE</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="invoiceid" value="<?php echo $keys['invoiceid'] ?>">
                    <button type="submit" name="deleteInvoice" class="btn btn-danger">Delete Invoice</button>
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
<?php
include "components/footer.php";
?>