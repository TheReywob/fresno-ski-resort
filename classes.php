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
          <a class="nav-link" href="index.php">Rentals</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="classes.php">Classes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Admin Portal</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- End Navbar -->

  <!-- Begin Page Content -->
  <div class="container">
  <h1>Classes</h1>

  <!-- Begin Project Cards -->
  <div class="album py-5" style="margin-top:-55px">
    <!--  <div class="container"> -->
        <hr>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
          <?php
            // Open connection to the database
            require "connect.php";

            // Fetch all rentable items
            $sql = "SELECT * FROM `class` INNER JOIN lesson ON class.less_id=lesson.less_id LEFT JOIN instructor ON lesson.instr_id=instructor.instr_id";
            $result = $connect->query($sql);
            while ($row = $result->fetch_assoc()){
              $class_id = $row['class_id'];
              $image = "";

              // Create class card
              echo '<div class="col">';
              echo '<div class="card shadow-sm">';
              // Instructor picture
              switch ($row['item_type']) {
              }
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
              echo '<p class="card-text">Type: '.$class_type.'<br>Instructor: '.$row['item_color'].'<br>Duration: '.$row['less_duration'].' min<br>Time: '.$row['item_colorz'].'</p>';
              // Card buttons
              echo '<div class="d-flex justify-content-between align-items-center">';
              echo '<div class="btn-group">';
              echo '<a href="#" class="btn btn-sm btn-outline-primary">Join Class</a>';
              echo '</div>';

              // Class spots available
              if ($row['is_rented_out'] == 0) {
                $availability = "Available";
                $text_type = "text-success";
              }
              else if ($row['is_rented_out'] == 1) {
                // Check if todays date is between the rental period
                $today = date('Y-m-d');
                $rent_start_date = $row['rental_startdate'];
                $rent_end_date = $row['rental_enddate'];
                if (!($today > $rent_start_date && $today < $rent_end_date)) {
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
                }
                else {
                  // If today is inside the rental period
                  $availability = "Reserved until ".date("m/d/Y", strtotime($rent_end_date));
                  $text_type = "text-danger";
                }
              }

              echo '<small class="'.$text_type.'">1/1 slots available</small>';
              // Close product card
              echo '</div>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
            }

          ?>

  <!-- End Project Cards -->
  </div>
  <!-- End Page Content -->





  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
