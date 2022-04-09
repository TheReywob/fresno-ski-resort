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
          <a class="nav-link active" href="rentals.php">Rentals</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="classes.php">Classes</a>
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
  <h1>Confirm your Rental</h1>
  <hr>

  <form action="insert_join.php" method="post">
    <div class="row">
      <div class="col">
        <h5>Customer Info</h5>
        <br>
        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname" required><br><br>
        <label for="lname">Last Name:</label>
        <input type="text" id="lname" name="lname" required><br><br>
        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" required><br><br>
        <label for="street">Street:</label>
        <input type="text" id="street" name="street" required><br><br>
        <label for="city">City:</label>
        <input type="text" id="city" name="city" required><br><br>
        <label for="state">State:</label>
        <select id="state" name="state" required>
          <option value="AL">Alabama</option>
          <option value="AK">Alaska</option>
          <option value="AZ">Arizona</option>
          <option value="AR">Arkansas</option>
          <option value="CA">California</option>
          <option value="CO">Colorado</option>
          <option value="CT">Connecticut</option>
          <option value="DE">Delaware</option>
          <option value="FL">Florida</option>
          <option value="GA">Georgia</option>
          <option value="HI">Hawaii</option>
          <option value="ID">Idaho</option>
          <option value="IL">Illinois</option>
          <option value="IN">Indiana</option>
          <option value="IA">Iowa</option>
          <option value="KS">Kansas</option>
          <option value="KY">Kentucky</option>
          <option value="LA">Louisiana</option>
          <option value="ME">Maine</option>
          <option value="MD">Maryland</option>
          <option value="MA">Massachusetts</option>
          <option value="MI">Michigan</option>
          <option value="MN">Minnesota</option>
          <option value="MS">Mississippi</option>
          <option value="MO">Montana</option>
          <option value="NE">Nebraska</option>
          <option value="NV">Nevada</option>
          <option value="NH">New Hampshire</option>
          <option value="NJ">New Jersey</option>
          <option value="NM">New Mexico</option>
          <option value="NY">New York</option>
          <option value="NC">North Carolina</option>
          <option value="ND">North Dakota</option>
          <option value="OH">Ohio</option>
          <option value="OK">Oklahoma</option>
          <option value="OR">Oregon</option>
          <option value="PA">Pennsylvania</option>
          <option value="RI">Rhode Island</option>
          <option value="SC">South Carolina</option>
          <option value="SD">South Dakota</option>
          <option value="TN">Tennessee</option>
          <option value="TX">Texas</option>
          <option value="UT">Utah</option>
          <option value="VT">Vermont</option>
          <option value="VA">Virginia</option>
          <option value="WA">Washington</option>
          <option value="WV">West Virginia</option>
          <option value="WI">Wisconsin</option>
          <option value="WY">Wyoming</option>
        </select>
        <br><br>
        <label for="zip">ZIP:</label>
        <input type="text" id="zip" name="zip" required><br><br>
        <?php
          // Store rentable_item id of item user clicked on
          $item_id = $_POST['rentButton'];
          echo '<input type="hidden" name="item_id" value="'.$item_id.'"';
        ?>
        <!-- Start date - minimum date is today -->
        <label for="startDate">Rental Start Date:</label>
        <input type="date" id="startDate" name="startDate" min="<?=date("Y-m-d")?>" required><br><br>
        <!-- End date - maximum rental length is 2 weeks -->
        <label for="endDate">Rental End Date*:</label>
        <input type="date" id="endDate" name="endDate" min="<?=date("Y-m-d")?>" max="<?=date('Y-m-d', strtotime(date("Y-m-d").' + 14 days'))?>" required><br><br>
        <button type="reset" class="btn btn-outline-secondary">Reset</button>
        <button type="submit" class="btn btn-primary">Confirm Rental</button><br>
        <small class="text-muted">*Your rental period cannot exceed 2 weeks.</small>
      </div>
      <div class="col">
        <h5>Rental Details</h5>
        <br>
        <?php
          // Open connection to the database
          require "connect.php";
          // Fetch all rentable items
          $sql = "SELECT * FROM rentable_items INNER JOIN item_types ON rentable_items.itemtype_id=item_types.itemtype_id WHERE rentable_items.rentable_item_id=$item_id";
          $result = $connect->query($sql);
          var_dump($item_id);
          var_dump($result);
          while ($row = $result->fetch_assoc()){
            var_dump($row);
            // Product name
            echo '<h2>'.$row['item_brand'].' '.$row['item_model'].'</h2>';
            // Product specifications
            echo '<p class="card-text">Type: '.$row['item_type'].'<br>Color: '.$row['item_color'].'<br>Size: '.$row['item_size'].'</p>';
          }
          $connect -> close();
        ?>
      </div>
    </div>
  </form>
  </div>
  <!-- End Page Content -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
