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

    // Function to get the list of available games
    function getAvailableGames() {
        global $db_connection;

        $sql = "SELECT * FROM game";
        $result = $db_connection->query($sql);

        return $result;
    }

    // Get the list of available games
    $availableGames = getAvailableGames();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./image/logotitle.png">
    <title>AVAILABLE GAMES - STEAM</title>
    <link rel="stylesheet" href="./style/gamescss.css">
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
<div class="game-list-container">
    <a href="add_game.php" id="add-game-button">ADD GAME</a>
    <h2>Available Games</h2>
    <div class="game-grid">
        <?php
        if ($availableGames && $availableGames->num_rows > 0) {
            while ($row = $availableGames->fetch_assoc()) {
                echo '<div class="game-item">';
                // Wrap the game item with an anchor tag
                echo '<a href="edit_game.php?game_id=' . $row['game_id'] . '">';
                echo '<img src="' . $row['picture'] . '" alt="' . $row['name'] . '">';
                echo '<h3>' . $row['name'] . '</h3>';
                echo '<p>' . $row['release_date'] . '</p>';
                echo '<div class="price-container">';
                echo '<p>Rp ' . $row['price'] . '</p>';
                echo '</div>';
                echo '</a>';
                echo '</div>';
            }
        } else {
            echo '<p>No games available.</p>';
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
