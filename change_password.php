<?php
session_start(); // Start the session
include "connection.php";

// Function to check if the user is logged in
function isLoggedIn() {
    return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

// Function to display the user menu
function displayUserMenu() {
    echo '<div class="user-menu">';
    echo '<span class="user-menu-text">' . $_SESSION['username'] . '</span>';
    echo '<div class="user-menu-content">';
    echo '<a href="profile.php">View Profile</a>';
    echo '<a href="change_password.php">Change Password</a>';
    echo '<a href="logout.php">Logout</a>';
    echo '</div>';
    echo '</div>';
}

// Redirect to login page if not logged in
if (!isLoggedIn()) {
    header('Location: form_login.php');
    exit();
}

// Function to update the user's password
function updateUserPassword($userId, $newPassword) {
    global $db_connection;

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $sql = "UPDATE user SET password_user = '$hashedPassword' WHERE user_id = $userId";
    $result = $db_connection->query($sql);

    return $result;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['changePassword'])) {
        $userId = $_SESSION['user_id'];
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];

        // Check if the current password is correct
        $sql = "SELECT password_user FROM user WHERE user_id = '$userId'";
        $result = $db_connection->query($sql);

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($currentPassword, $user['password_user'])) {
                // Update the password if the current password is correct
                updateUserPassword($userId, $newPassword);
                echo "<script>alert('Password changed successfully!');window.location.replace('profile.php');</script>";
            } else {
                echo "<script>alert('Current password is incorrect!');window.location.replace('change_password.php');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./image/logotitle.png">
    <title>CHANGE PASSWORD - STEAM</title>
    <link rel="stylesheet" href="./style/changepasswordcss.css">
    <link rel="stylesheet" href="./style/footercss.css">
    <style>
    body {
    font-family: "Motiva Sans", sans-serif;
    margin: 0;
    padding: 0;
    background-color: #1b2838;
    color: #fff;
    }
    </style>
</head>

<body>

    <header>
        <?php
        include "nav.php";
        ?>
    </header>

    <main>
    <div class="ContentOne">
        <div class="change-password-container">
            <h2>Change Password</h2>
            <form class="change-password-form" method="POST" action="">
                <label for="currentPassword">Current Password:</label>
                <input type="password" name="currentPassword" required>
                <label for="newPassword">New Password:</label>
                <input type="password" name="newPassword" required>
                <button type="submit" name="changePassword">Change Password</button>
            </form>
        </div>
    </div>
    </main>
    
</body>

    <footer>
        <?php
        include "footer.php";
        ?>
    </footer>

</html>

<?php
// Close the database connection
$db_connection->close();
?>
