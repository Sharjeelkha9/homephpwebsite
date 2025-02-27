<?php
include "components/header.php";
?>
<!-- Blank Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row bg-light rounded mx-0">
        <div class="col-lg-12">
            <button type="button" class="btn btn-primary m-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add Employee</button>
        </div>
        <div class="col-md-6 my-3 mx-3">
            <h3>EMPLOYEE</h3>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Password</th>
                    <th scope="col" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = $pdo->query("select * from employee");
                $rows = $query->fetchALL(PDO::FETCH_ASSOC);
                foreach ($rows as $keys) {
                ?>
                    <tr>
                        <td><?php echo $keys['empname'] ?></td>
                        <td><?php echo $keys['empemail'] ?></td>
                        <td><?php echo $keys['empphone'] ?></td>
                        <td><?php echo $keys['emppass'] ?></td>
                        <td><a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modelupdate<?php echo $keys['empid'] ?>">Edit</a></td>
                        <td><a href="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modeldelete<?php echo $keys['empid'] ?>">Delete</td>
                    </tr>

                    <!-- update employee Modal -->
                    <div class="modal fade" id="modelupdate<?php echo $keys['empid'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">UPDATE EMPLOYEE</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <input type="hidden" name="empid" value="<?php echo $keys['empid'] ?>">
                                            <label for="exampleInputEmail1" class="form-label">Employee Name</label>
                                            <input type="text" name="empName" value="<?php echo $keys['empname'] ?>" class="form-control" id="exampleInputEmail1"
                                                aria-describedby="emailHelp">
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Employee Email</label>
                                            <input type="email" name="empEmail" value="<?php echo $keys['empemail'] ?>" class="form-control" id="exampleInputPassword1">
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Employee Phone</label>
                                            <input type="tel" name="empPhone" value="<?php echo $keys['empphone'] ?>" class="form-control" id="exampleInputPassword1">
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Employee Password</label>
                                            <input type="text" name="empPass" value="<?php echo $keys['emppass'] ?>" class="form-control" id="exampleInputPassword1">
                                        </div>
                                        <button type="submit" name="updateEmployee" class="btn btn-primary">Update Employee</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- delete category Modal -->
                    <div class="modal fade" id="modeldelete<?php echo $keys['empid'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">DELETE EMPLOYEE</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="empid" value="<?php echo $keys['empid'] ?>">
                                        <button type="submit" name="deleteEmployee" class="btn btn-danger">Delete Employee</button>
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
                    <div class="mb-3">
                        <label for="roleSelect" class="form-label">Role</label>
                        <select name="empRole" class="form-select" id="roleSelect">
                            <option value="employee" selected>Employee</option>
                        </select>
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