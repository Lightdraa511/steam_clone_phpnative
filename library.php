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

// Function to get user's library
function getUserLibrary($userId) {
    global $db_connection;

    if (!$userId) {
        return null;
    }

    $userId = mysqli_real_escape_string($db_connection, (string)$userId);
    $sql = "SELECT game.*, library.user_id
            FROM game
            JOIN library ON game.game_id = library.game_id
            WHERE library.user_id = '$userId'";
    $result = $db_connection->query($sql);

    return $result;
}

// Dapatkan user_id dari sesi
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$userLibrary = getUserLibrary($userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./image/logotitle.png">
    <title>LIBRARY - STEAM</title>
    <link rel="stylesheet" href="./style/librarycss.css">
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
    <div class="library-container">
        <?php
        if ($userLibrary && $userLibrary->num_rows > 0) {
            while ($row = $userLibrary->fetch_assoc()) {
                echo '<a href="game_detail.php?game_id=' . $row['game_id'] . '" style="text-decoration: none; color: #fff;">';
                echo '<div class="game-container">';
                echo '<img class="game-image" src="' . $row['picture'] . '" alt="' . $row['name'] . '">';
                echo '<div class="game-details">';
                echo '<h2>' . $row['name'] . '</h2>';
                echo '</div>';
                echo '</div>';
                echo '</a>';
            }
        } else {
            echo '<p>Your library is empty.</p>';
        }
        ?>
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
