<?php
include "components/header.php";
?>
<!-- Blank Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row bg-light rounded mx-0">
        <div class="col-lg-12">
            <button type="button" class="btn btn-primary m-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add Category</button>
        </div>
        <div class="col-md-6 my-3 mx-3">
            <h3>ADD CATEGORY</h3>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = $pdo->query("select * from categories");
                $rows = $query->fetchALL(PDO::FETCH_ASSOC);
                foreach($rows as $keys){
                    ?>
                    <tr>
                    <th scope="row"><img src="<?php echo $catimagesaddress.$keys['image'] ?>" alt="" width="80" srcset=""></th>
                    <td><?php echo $keys['name'] ?></td>
                    <td><a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modelupdate<?php echo $keys['id'] ?>">Edit</a></td>
                    <td><a href="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modeldelete<?php echo $keys['id'] ?>">Delete</td>
                </tr>

                <!-- update category Modal -->
<div class="modal fade" id="modelupdate<?php echo $keys['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">UPDATE CATEGORY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="hidden" name="catid" value="<?php echo $keys['id'] ?>">
                        <label for="exampleInputEmail1" class="form-label">Category Name</label>
                        <input type="text" name="catName" value="<?php echo $keys['name'] ?>" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Category Image</label>
                        <input type="file" name="catImage" class="form-control" id="exampleInputPassword1">
                        <img class="mt-3" src="<?php echo $catimagesaddress.$keys['image'] ?>" width="90" alt="">
                    </div>
                    <button type="submit" name="updateCategory" class="btn btn-primary">Update Category</button>
                </form>
            </div>

        </div>
    </div>
</div>
                    <!-- delete category Modal -->
<div class="modal fade" id="modeldelete<?php echo $keys['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">DELETE CATEGORY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="catid" value="<?php echo $keys['id'] ?>">
                    <button type="submit" name="deleteCategory" class="btn btn-danger">Delete Category</button>
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

<!-- add category Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">ADD CATEGORY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Category Name</label>
                        <input type="text" name="catName" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Category Image</label>
                        <input type="file" name="catImage" class="form-control" id="exampleInputPassword1">
                    </div>
                    <button type="submit" name="addCategory" class="btn btn-primary">Add Category</button>
                </form>
            </div>

        </div>
    </div>
</div>


<?php
include "components/footer.php";
?>