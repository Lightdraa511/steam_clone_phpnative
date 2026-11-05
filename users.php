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

// Check if the user is an admin
if (!isLoggedIn() || !isset($_SESSION['user_id'])) {
    header('Location: form_login.php');
    exit();
}
$user_id = $_SESSION['user_id'];
$sql = "SELECT usertype FROM user WHERE user_id = '$user_id'";
$result = $db_connection->query($sql);

if ($result) {
    $user = $result->fetch_assoc();
    if ($user['usertype'] !== 'admin') {
        // Redirect to another page if not an admin
        header('Location: form_login.php'); // You can change 'form_login.php' to the desired page
        exit();
    }
} else {
    // Handle the case where the SQL query fails
    die("Error: " . $db_connection->error);
}

// Function to get all users
function getAllUsers() {
    global $db_connection;

    $sql = "SELECT user_id, username, usertype FROM user";
    $result = $db_connection->query($sql);

    return $result;
}

// Function to update user type
function updateUserType($userId, $newUserType) {
    global $db_connection;

    $newUserType = mysqli_real_escape_string($db_connection, $newUserType);
    $sql = "UPDATE user SET usertype = '$newUserType' WHERE user_id = $userId";
    $result = $db_connection->query($sql);

    return $result;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['changeUserType'])) {
        $userId = $_POST['userId'];
        $newUserType = $_POST['newUserType'];
        updateUserType($userId, $newUserType);
    }
}

// Get all users
$users = getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./image/logotitle.png">
    <title>USER MANAGEMENT - STEAM</title>
    <link rel="stylesheet" href="./style/userscss.css">
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
        include "navadmin.php";
        ?>
    </header>
    
    <main>
    <div class="ContentOne">
        <div class="user-list-container">
            <h2>User Management</h2>
            <?php
            if ($users && $users->num_rows > 0) {
                while ($user = $users->fetch_assoc()) {
                    echo '<div class="user-item">';
                    echo '<h3>' . $user['username'] . '</h3>';
                    echo '<p>User Type: ' . $user['usertype'] . '</p>';
                    echo '<form method="POST" action="">';
                    echo '<input type="hidden" name="userId" value="' . $user['user_id'] . '">';
                    echo '<select name="newUserType">';
                    echo '<option value="admin">Admin</option>';
                    echo '<option value="user">User</option>';
                    echo '</select>';
                    echo '<button type="submit" name="changeUserType">Change User Type</button>';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo '<p>No users found.</p>';
            }
            ?>
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
