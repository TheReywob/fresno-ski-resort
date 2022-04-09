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
  <hr>

  <?php
    // Open connection to the database
    require "connect.php";




    $connect -> close();
   ?>

</div>
<!-- End Page Content -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
