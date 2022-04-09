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
          <a class="nav-link active" href="classes.php">Classes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="auth.php">Admin Portal</a>
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
            $sql = "SELECT * FROM lesson INNER JOIN instructor ON lesson.instr_id=instructor.instr_id ORDER BY less_date";
            $result = $connect->query($sql);
            while ($row = $result->fetch_assoc()){
              $lesson_id = $row['less_id'];
              $image = "";

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
              /// Join Class button
              echo '<form action="join_class.php" method="post">';
              // Disable button if class is booked full
              echo '<button type="submit" name="joinButton" value="'.$lesson_id.'" class="btn btn-sm btn-outline-primary '.$disabled_status.'">Join Class</button>';
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

  <!-- End Project Cards -->
  </div>
  <!-- End Page Content -->





  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
