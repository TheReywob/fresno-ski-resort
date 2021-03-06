<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Fresno Ski & Snowboard Rental</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
  <!-- Begin Navbar -->
  <nav class="navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">Fresno Ski & Snowboard Rental</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample02">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="rentals.php">Rentals</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="classes.php">Classes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="auth.php">Admin Portal</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- End Navbar -->

  <!-- Begin Page Content -->
  <div class="container">
  <h1>Admin Portal</h1>
  <button class="btn btn-sm btn-outline-success disabled">New Entity</button>
  <hr>
  <h5>Rentals</h5>

  <div class="album py-5" style="margin-top:-55px">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
      <?php
        // Open connection to the database
        require "connect.php";

        // Fetch all rentable items
        $sql = "SELECT rentable_items.rentable_item_id, item_brand, item_model, item_color, item_size, item_price, is_rented_out, item_type, rental_startdate, rental_enddate FROM rentable_items INNER JOIN item_types ON rentable_items.itemtype_id=item_types.itemtype_id LEFT JOIN rental ON rentable_items.rentable_item_id=rental.rentable_item_id ORDER BY is_rented_out, item_brand, item_model";
        $result = $connect->query($sql);
        while ($row = $result->fetch_assoc()){
          $item_id = $row['rentable_item_id'];
          $image = "";

          // Create product card
          echo '<div class="col">';
          echo '<div class="card shadow-sm">';
          // Product image
          switch ($row['item_type']) {
            case "Skis":
              $image = "skiing.jpg";
              break;
            case "Snowboard":
              $image = "snowboarding.jpg";
              break;
            case "Poles":
              $image = "ski_poles.jpg";
              break;
            case "Boots":
              $image = "ski_boots.jpg";
              break;
            case "Helmet":
              $image = "helmets.jpg";
              break;
            case "Goggles":
              $image = "goggles.jpg";
              break;
          }
          echo '<img src="images/'.$image.'" alt="'.$row['item_type'].'" width="100%" height="225">';
          // Card body
          echo '<div class="card-body">';
          // Product name
          echo '<h2>'.$row['item_brand'].' '.$row['item_model'].'</h2>';
          // Product specifications
          echo '<p class="card-text">Type: '.$row['item_type'].'<br>Color: '.$row['item_color'].'<br>Size: '.$row['item_size'].'<br>Price per Day: $'.$row['item_price'].'</p>';
          // Product availability
          if ($row['is_rented_out'] == 0) {
            $availability = "Available";
            $text_type = "text-success";
            $disabled_status = "";
          }
          else if ($row['is_rented_out'] == 1) {
            // Check if todays date is between the rental period
            $today = date('Y-m-d');
            $rent_start_date = $row['rental_startdate'];
            $rent_end_date = $row['rental_enddate'];
            if (!($today >= $rent_start_date && $today <= $rent_end_date)) {
              // If today is NOT inside the rental period
              // Change is_rented_out to false in DB table
              $update_sql = "UPDATE rentable_items SET is_rented_out=0 WHERE rentable_item_id=$item_id";
              // Verify update was successful
              if (!($connect->query($update_sql) === TRUE)) {
                echo "Error: " . $update_sql . "<br>" . $connect->error;
              }
              // Delete rental record
              $delete_sql = "DELETE FROM rental WHERE rentable_item_id=$item_id";
              // Verify deletion was successful
              if (!($connect->query($delete_sql) === TRUE)) {
                echo "Error: " . $delete_sql . "<br>" . $connect->error;
              }
              // Set product availability to Available
              $availability = "Available";
              $text_type = "text-success";
              $disabled_status = "";
            }
            else {
              // If today is inside the rental period
              $availability = "Reserved until ".date("m/d/Y", strtotime($rent_end_date));
              $text_type = "text-danger";
              $disabled_status = "disabled";
            }
          }
          // Card buttons
          echo '<div class="d-flex justify-content-between align-items-center">';
          echo '<div class="btn-group">';
          /// Edit button
          echo '<form action="#.php" method="post">';
          // Disable button if product is already rented out
          echo '<button type="submit" name="editButton" value="'.$row['rentable_item_id'].'" class="btn btn-sm btn-outline-secondary disabled">Edit</button>';
          echo '</form>';
          /// Delete button
          echo '<form action="delete.php" method="post">';
          // Disable button if product is already rented out
          echo '<input type="hidden" name="table" value="rentable_items">';
          echo '<button type="submit" name="deleteButton" value="'.$row['rentable_item_id'].'" class="btn btn-sm btn-outline-danger">Delete</button>';
          echo '</form>';
          echo '</div>';
          // Print availability
          echo '<small class="'.$text_type.'">'.$availability.'</small>';
          // Close product card
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
        $connect -> close();
       ?>
     </div>
   </div>


       <hr>
       <h5>Classes</h5>

       <div class="album py-5" style="margin-top:-55px">
         <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
           <?php
             // Open connection to the database
             require "connect.php";

             // Fetch all lessons
             $sql = "SELECT * FROM lesson INNER JOIN instructor ON lesson.instr_id=instructor.instr_id ORDER BY less_date";
             $result = $connect->query($sql);
             while ($row = $result->fetch_assoc()){
               $lesson_id = $row['less_id'];
               $instr_id = $row['instr_id'];
               if ($row['instr_id'] == 1) {
                 $image = "ski_instr_1.jpg";
               } else if ($row['instr_id'] == 3) {
                 $image = "snow_instr_1.jpg";
               } else if ($row['instr_id'] == 4) {
                 $image = "snow_instr_2.jpg";
               } else if ($row['instr_id'] == 5) {
                 $image = "ski_instr_2.jpg";
               } else if ($row['instr_id'] == 6) {
                 $image = "ski_instr_3.jpg";
               }

               // Create class card
               echo '<div class="col">';
               echo '<div class="card shadow-sm">';
               // Instructor picture
               // need to work on this!!!
               echo '<img src="images/'.$image.'" alt="'.$row['item_type'].'" width="100%" height="225">';
               // Card body
               echo '<div class="card-body">';
               /// Class type
               // Check if class is private or public
               if ($row['less_private'] == 1) {
                 // If class is 1-on-1
                 $private_lesson = "Private ";
                 $class_type = "1-on-1";
               } else {
                 // If class is public
                 $private_lesson = "";
                 $class_type = "Public";
               }
               // Check if ski or snowboard lesson
               if ($row['less_type'] == 1) {
                 $class_name = "Ski Lesson";
               } else if ($row['less_type'] == 2) {
                 $class_name = "Snowboard Lesson";
               }
               echo '<h2>'.$private_lesson.' '.$class_name.'</h2>';
               // Class specifications
               $class_time = date_create($row['less_date']);
               echo '<p class="card-text">Type: '.$class_type.'<br>Instructor: '.$row['instr_fname'].' '.$row['instr_lname'].'<br>Duration: '.$row['less_duration'].' min<br>When: '.date_format($class_time, 'm/d/Y \a\t g:ia').'</p>';

               /// Class spots available
               // Count number of people currently in class
               $spots_sql = "SELECT COUNT(less_id) FROM class WHERE less_id=$lesson_id";
               $spots_result = $connect->query($spots_sql);
               while ($spots_row = $spots_result->fetch_assoc()){
                 $spots_available = ($row['less_max_slots'] - $spots_row['COUNT(less_id)']);
               }
               // If no more spots available
               if ($spots_available == 0) {
                 $text_type = "text-danger";
                 $disabled_status = "disabled";
               } else {
                 $text_type = "text-success";
                 $disabled_status = "";
               }
               // Card buttons
               echo '<div class="d-flex justify-content-between align-items-center">';
               echo '<div class="btn-group">';
               /// Edit button
               echo '<form action="#.php" method="post">';
               // Disable button if product is already rented out
               echo '<button type="submit" name="editButton" value="'.$row['less_id'].'" class="btn btn-sm btn-outline-secondary disabled">Edit</button>';
               echo '</form>';
               /// Delete button
               echo '<form action="delete.php" method="post">';
               // Disable button if product is already rented out
               echo '<input type="hidden" name="table" value="lesson">';
               echo '<button type="submit" name="deleteButton" value="'.$row['less_id'].'" class="btn btn-sm btn-outline-danger">Delete</button>';
               echo '</form>';
               echo '</div>';
               // Print class availability
               echo '<small class="'.$text_type.'">'.$spots_available.'/'.$row['less_max_slots'].' slots available</small>';
               // Close product card
               echo '</div>';
               echo '</div>';
               echo '</div>';
               echo '</div>';
             }
             $connect -> close();
           ?>

</div>
<!-- End Page Content -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
