<?php
include "components/header.php";
?>
<!-- Blank Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row bg-light rounded mx-0">
        <div class="col-md-6 my-3 mx-3">
            <h3>FEEDBACKS</h3>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">User Email</th>
                    <th scope="col">User Message</th>
                    <th scope="col" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = $pdo->query("select * from feedback");
                $rows = $query->fetchALL(PDO::FETCH_ASSOC);
                foreach($rows as $keys){
                    ?>
                    <tr>
                    <td><?php echo $keys['feedbackemail'] ?></td>
                    <td><?php echo $keys['feedbackmsg'] ?></td>
                    <td><a href="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modeldelete<?php echo $keys['feedbackid'] ?>">Delete</td>
                </tr>
                    <!-- delete feedback Modal -->
<div class="modal fade" id="modeldelete<?php echo $keys['feedbackid'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">DELETE FEEDBACK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="feedbackid" value="<?php echo $keys['feedbackid'] ?>">
                    <button type="submit" name="deleteFeedback" class="btn btn-danger">Delete Feedback</button>
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