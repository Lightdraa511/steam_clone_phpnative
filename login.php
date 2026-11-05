<?php
session_start(); // Start the session

if (isset($_POST['login'])) { // Check POST variable from FORM
    include "connection.php"; // Include connection file

    // Make the query based on username
    $query = "SELECT * FROM user WHERE username='$_POST[username]'";

    // Run the query
    $login = mysqli_query($db_connection, $query);

    if (mysqli_num_rows($login) > 0) { // Check if the username is found or not
        $user = mysqli_fetch_assoc($login); // If the user is found, extract the data
        if (password_verify($_POST['password_user'], $user['password_user'])) { // Verify the password

            // If the password matches, then set session variables
            $_SESSION['login'] = TRUE;
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['usertype'] = $user['usertype'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['password_user'] = $user['password_user'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['photo_profile'] = $user['photo_profile'];

            // Redirect based on usertype
            if ($user['usertype'] === 'admin') {
                // Redirect admin to games.php
                header('Location: index.php');
            } else {
                // Redirect user to index.php
                header('Location: index.php');
            }
            exit(); // Stop execution after redirection
        } else { // Password didn't match
            // Wrong password message, then redirect to the login form
            echo "<script>alert('Login failed, wrong password !');window.location.replace('form_login.php');</script>";
        }
    } else { // User not found 
        // Login failed message, then redirect to the login form
        echo "<script>alert('Login failed, user not found !');window.location.replace('form_login.php');</script>";
    }
}
?>
