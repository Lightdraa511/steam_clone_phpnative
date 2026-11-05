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

// Function to get search results
function searchGames($searchTerm) {
    global $db_connection;

    $searchTerm = mysqli_real_escape_string($db_connection, $searchTerm);
    $sql = "SELECT * FROM game WHERE name LIKE '%$searchTerm%'";
    $result = $db_connection->query($sql);

    return $result;
}

// Get search term if provided in the URL
$searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';
$searchResults = searchGames($searchTerm);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./image/logotitle.png">
    <title>SEARCH RESULTS - STEAM</title>
    <link rel="stylesheet" href="./style/resultcss.css">
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
                            <button type="submit"
                                    style="background-image: url('./image/search_icon_btn.png'); float: left;  width: 26px;  height: 26px; margin-left: 190px;"></button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="search-results-container">
    <?php
    if ($searchResults && $searchResults->num_rows > 0) {
        while ($row = $searchResults->fetch_assoc()) {
            echo '<a href="game_detail.php?game_id=' . $row['game_id'] . '" style="text-decoration: none; color: #fff;">';
            echo '<div class="search-result">';
            echo '<img src="' . $row['picture'] . '" alt="' . $row['name'] . '">';
            echo '<div class="search-result-details">';
            echo '<h3>' . $row['name'] . '</h3>';
            echo '<p>' . $row['release_date'] . '</p>';
            echo '<div class="price-container">';
            echo '<p><strong></strong> Rp ' . $row['price'] . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</a>';
        }
    } else {
        echo '<p>No results found.</p>';
    }
    ?>

</div>

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
