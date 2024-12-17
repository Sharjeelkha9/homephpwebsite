<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta1/css/bootstrap.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta1/js/bootstrap.bundle.min.js"></script>

   
  </body>
</html>
<!-- <style>
    .even-row {
        background-color: skyblue; 
    }
    .odd-row {
        background-color: #ffffff;
    }
</style> -->

<!-- <table class="table">
<?php
for ($i=1; $i <=10 ; $i++) {
    ?>
    <tr class="<?php echo ($i % 2 == 0) ? 'even-row' : 'odd-row'; ?>">
        <th scope="row">5</th>
        <td>*</td>
        <td><?php echo $i?></td>
        <td>=</td>
        <td><?php echo $i*5?></td>
    </tr>



    <?php 
}
?>
</table> -->



<?php
$students = [
  [
    "name"=>"Sharjeel",
    "age"=>19,
    "course"=>"cpism",
    "slot"=>"9 to 11",
    "fees"=>8500
  ],
  [
    "name"=>"Touqeer",
    "age"=>19,
    "course"=>"cpism",
    "slot"=>"9 to 11",
    "fees"=>8500
  ],
  [
    "name"=>"Hussnain",
    "age"=>19,
    "course"=>"cpism",
    "slot"=>"9 to 11",
    "fees"=>8500
  ],
  [
    "name"=>"Ali Raza",
    "age"=>19,
    "course"=>"cpism",
    "slot"=>"9 to 11",
    "fees"=>8500
  ],
  [
    "name"=>"Hassan Raza",
    "age"=>19,
    "course"=>"cpism",
    "slot"=>"9 to 11",
    "fees"=>8500
  ],
];
// foreach($students as $values){
//   echo $values['name'] .'<br>';
// }
?>
<table class="table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Age</th>
        <th>Course</th>
        <th>Slot</th>
        <th>Fees</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($students as $values) { ?>
        <tr>
          <td><?= $values['name'] ?></td>
          <td><?= $values['age'] ?></td>
          <td><?= $values['course'] ?></td>
          <td><?= $values['slot'] ?></td>
          <td><?= $values['fees'] ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
