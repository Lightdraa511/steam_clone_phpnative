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

// Fungsi untuk menampilkan semua game
function displayAllGames() {
    global $db_connection;

    $sql = "SELECT * FROM game";
    $result = $db_connection->query($sql);

    if ($result->num_rows > 0) {
        echo '<div class="game-container">';
        while ($row = $result->fetch_assoc()) {
            echo '<div class="game-card">';
            echo '<a href="game_detail.php?game_id=' . $row['game_id'] . '">';
            echo '<img src="' . $row['picture'] . '" alt="' . $row['name'] . '">';
            echo '<p>' . $row['price'] . '</p>';
            echo '</a>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<p>No games found.</p>';
    }
}
    
    // Fungsi untuk menampilkan game berdasarkan genre dengan link ke halaman detail
    function displayGamesByGenre($genre) {
        global $db_connection;

        $sql = "SELECT * FROM game WHERE genre = '$genre'";
        $result = $db_connection->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="game-container">';
            while ($row = $result->fetch_assoc()) {
                displayGameDetails($row['game_id'], $row['name'], $row['picture'], $row['price']);
            }
            echo '</div>';
        } else {
            echo '<p>No games found in this genre.</p>';
        }
    }

    // Fungsi untuk menampilkan detail game dengan link
    function displayGameDetails($gameId, $gameName, $gamePicture, $gamePrice) {
        echo '<div class="game-card">';
        echo '<a href="game_detail.php?game_id=' . $gameId . '">';
        echo '<img src="' . $gamePicture . '" alt="' . $gameName . '">';
        echo '<p>' . $gamePrice . '</p>';
        echo '</a>';
        echo '</div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./image/logotitle.png">
    <title>STEAM</title>
    <link rel="stylesheet" href="./style/cssindex.css">
    <link rel="stylesheet" href="./style/cssindexcss.css">
    <link rel="stylesheet" href="./style/footercss.css">
    <style>
    </style>
</head>

<body>
    <header>
        <?php
        include "nav.php";
        ?>
    </header>

    
     <div class="ContentOne">
        <div class="kong">
            <div class="storeNav">
                <ul>
                    <li class="emptyNav">
                        <div></div>
                    </li>
                    <li class="search">
                    <div class="searchFor">
                    <form method="GET" action="result.php">
                        <input type="text" name="searchTerm" placeholder="search" size="22">
                        <button type="submit" style="background-image: url('./image/search_icon_btn.png'); float: left;  width: 26px;  height: 26px; margin-left: 190px;"></button>
                    </form>
                    </div>
                    </li>
                </ul>
            </div>
            </div>                                          
            </div>
    <main>
            <!-- Tampilkan semua game -->
        <?php displayAllGames(); ?>

        <!-- Tampilkan game berdasarkan genre -->
        <p>SURVIVAL GAME</p>
        <?php displayGamesByGenre('Survival'); ?>
        <p>FPS GAME</p>
        <?php displayGamesByGenre('FPS'); ?>
        <p>ACTION GAME</p>
        <?php displayGamesByGenre('Action'); ?>
        <p>SPORT GAME</p>
        <?php displayGamesByGenre('Sports'); ?>

    </main>
<footer>
    <?php
    include "footer.php";
    ?>
</footer>

</body>
</html>
<?php
// Tutup koneksi setelah selesai
$db_connection->close();
?>

