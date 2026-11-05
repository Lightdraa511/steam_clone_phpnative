<?php
    if (isset($_POST ['save'])) { // check variable POST from form
        include "connection.php"; //call conncection php mysql

        // hash the password using PHP's password_hash() function
        $password = password_hash($_POST['password_user'], PASSWORD_DEFAULT);

        //sql query INSERT INTO VALUES
        $query = "INSERT INTO user (username, email, password_user, fullname) 
        VALUES 
        ('$_POST[username]','$_POST[email]', '$password','$_POST[fullname]')";
   
        // run query
         $create = mysqli_query($db_connection, $query);
   
         if($create) { // check if query TRUE/succes
            // echo "<p>user added successfully </p>"; // versi html
            echo "<script> alert ('user added successfully !'); </script>"; // versi javascript
         } else {
            //echo "<p>user add failed!</p>"; //versi html
            echo "<script> alert ('user add failed!'); </script>"; // versi javascript
         }
   
        }  
    ?>
    <!-- <p><a href="form_login.php">BACK TO USER LIST</p> -->
    <script>window.location.replace("form_login.php"); </script>