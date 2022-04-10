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
  $startdate = $_POST['startDate'];
  $enddate = $_POST['endDate'];
  $item_id = $_POST['item_id'];

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


  // Set is_rented_out to TRUE in rentable_items table
  $sql = "UPDATE rentable_items SET is_rented_out=1 WHERE rentable_item_id=$item_id";
  // Verify update was successful
  if ($connect->query($sql) === FALSE) {
    die("Error: " . $sql . "<br>" . $connect->error);
  }

  // Add customer and item_id to rental table
  $sql = "INSERT INTO rental (custo_id, rentable_item_id, rental_startdate, rental_enddate) VALUES ('$customer_id', '$item_id', '$startdate', '$enddate')";
  // Verify insertion was successful
  if ($connect->query($sql) === TRUE) {
    echo 'Successfully reserved rental!';
    echo '<br><a href="rentals.php">Back to Rental Shop</a>';
  } else {
    die("Error: " . $sql . "<br>" . $connect->error);
  }

  $connect -> close();
 ?>
