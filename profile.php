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

// Get user details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM user WHERE user_id = '$user_id'";
$result = $db_connection->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    // Handle the case where the user is not found
    die("Error: User not found");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./image/logotitle.png">
    <title>PROFILE - STEAM</title>
    <link rel="stylesheet" href="./style/profilecss.css">
    <link rel="stylesheet" href="./style/cssindex.css">
    <link rel="stylesheet" href="./style/footercss.css">
</head>

<body>

    <header>
        <?php
        include "nav.php";
        ?>
    </header>

    <div class="ContentOne">
        <div class="profile-container">
            <div class="profile-info">
                <img src="<?php echo $user['photo_profile']; ?>" alt="Profile" class="profile-img">
                <div>
                    <div class="profile-username"><?php echo $user['username']; ?></div>
                    <a href="edit_profile.php" class="edit-profile-btn">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>

<footer>
        <?php
        include "footer.php";
        ?>
</footer>

</body>
</html>

<?php
// Close the database connection
$db_connection->close();
?>
