# Fresno Ski & Snowboard Rental Company Files

### Rentals

- rentals.php
  - Rentals page
  - Dynamically prints all "rentable items" from the database onto info cards.

- rent_item.php
  - Form that records customer information before scheduling a rental.
  - Automatically runs insert_rental.php after customer submits form.

- insert_rental.php
  - Script that inserts new rental record into the rental table.

### Classes

- classes.php
  - Class page
  - Dynamically prints all ski/snowboard lesson from the database onto info cards.

- join_class.php
  - Form that records customer information before signing up for a class.
  - Automatically runs insert_join.php after customer submits form.

- insert_join.php
  - Script that inserts new class record into the class table.

### Admin Portal

- auth.php
  - Admin Portal authentication form
  - When the user navigates to the Admin Portal via navbar, they will first be directed to auth.php
  - If login credentials are correct, user will be redirected to admin_portal.php

- admin_portal.php
  - Admin Portal page
  - Prints all rentals AND lessons with 'Edit' and 'Delete' buttons.

- delete.php
  - Script that deletes the item from the database that was passed to script.

### Misc

- connect.php
  - Database connection script
  - When called, this script opens a connection to the DB as a PHP variable.

- index.php
  - Landing page
  - Includes 2 buttons to quickly navigate to the Rentals page and Classes page.
