<?php
  // Open connection to the database
  require "connect.php";
  // Fetch id of item to delete
  $table = $_POST['table'];
  $id = $_POST['deleteButton'];


  if ($table == 'lesson') {
    $id_column_name = 'less_id';
  } else if ($table == 'rentable_items') {
    $id_column_name = 'rentable_item_id';
  }


  // Delete record
  $sql = "DELETE FROM $table WHERE $id_column_name=$id";
  // Verify deletion was successful
  if ($connect->query($sql) === FALSE) {
    echo "Error: " . $sql . "<br>" . $connect->error;
  } else {
    echo 'Successfully deleted entity!';
    echo '<br><a href="admin_portal.php">Back to Admin Portal</a>';
  }

 ?>
