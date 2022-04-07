<?php
  // Open connection to the database
  require "connect.php";
  // Fetch form data
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $phone = $_POST['phone'];
  $street = $_POST['street'];
  $city = $_POST['city'];
  $state = $_POST['state'];
  $zip = $_POST['zip'];
  $lesson_id = $_POST['lesson_id'];

  // Insert customer data into customer table
  $sql = "INSERT INTO customer (custo_fname, custo_lname, custo_phone, custo_street, custo_city, custo_state, custo_zip) VALUES ('$fname', '$lname', '$phone', '$street', '$city', '$state', '$zip')";
  // Verify insertion was successful
  if ($connect->query($sql) === TRUE) {
    // Get new customer's custo_id
    sleep(3);
    $sql = "SELECT * FROM customer WHERE custo_fname='$fname' AND custo_lname='$lname'";
    $result = $connect->query($sql);
    while ($row = $result->fetch_assoc()){
      $customer_id = $row['custo_id'];
    }
  } else {
    die("Error: " . $sql . "<br>" . $connect->error);
  }



  // Add customer and lesson_id to class table
  $sql = "INSERT INTO class (custo_id, less_id) VALUES ($customer_id, $lesson_id)";
  // Verify insertion was successful
  if ($connect->query($sql) === TRUE) {
    echo 'Successfully joined class!';
    echo '<br><a href="classes.php">Back to Classes</a>';
  } else {
    die("Error: " . $sql . "<br>" . $connect->error);
  }

  $connect -> close();
 ?>
