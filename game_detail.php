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

// Function to get game details by ID
function getGameDetails($gameId) {
    global $db_connection;

    $gameId = mysqli_real_escape_string($db_connection, $gameId);
    $sql = "SELECT * FROM game WHERE game_id = '$gameId'";
    $result = $db_connection->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

// Get the game details if game_id is provided in the URL
$gameId = isset($_GET['game_id']) ? $_GET['game_id'] : null;
$gameDetails = null;

if ($gameId) {
    $gameDetails = getGameDetails($gameId);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./image/logotitle.png">
    <title><?php echo $gameDetails['name']; ?> - STEAM</title>
    <link rel="stylesheet" href="./style/gamedetailscss.css">
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
                        <button type="submit" style="background-image: url('search_icon_btn.png'); float: left;  width: 26px;  height: 26px; margin-left: 190px;"></button>
                    </form>
                    </div>
                    </li>
                </ul>
            </div>
            </div>                                          
            </div>
    <?php
    echo '<h1>' . $gameDetails['name'] . '</h1>';
    ?>

<!-- Main content -->
<main>
    <?php
    // Display game details if available
    if ($gameDetails) {
        echo '<div class="game-details-container">';
        echo '<img src="' . $gameDetails['picture'] . '" alt="' . $gameDetails['name'] . '">';
        echo '<div class="game-details">';
        echo '<img src="' . $gameDetails['picture'] . '" alt="' . $gameDetails['name'] . '">';
        echo '<p><strong>Description:</strong> ' . $gameDetails['description'] . '</p>';
        echo '<p><strong>Developer:</strong> ' . $gameDetails['developer'] . '</p>';
        echo '<p><strong>Publisher:</strong> ' . $gameDetails['publisher'] . '</p>';
        echo '<p><strong>Genre:</strong> ' . $gameDetails['genre'] . '</p>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<p>Game details not found.</p>';
    }
    ?>
</main>

<!-- Buy section -->
<buysection>
<div class="buy-section">
    <div class="buy-title">
        <h2>Buy <?php echo $gameDetails['name']; ?></h2>
    </div>
</div>
</buysection>

<buydetails>
    <div class="buy-details">
        <div class="price-container">
            <p><strong></strong> <?php echo $gameDetails['price']; ?></p>
        </div>
        <a href="transaction_form.php?game_id=<?php echo $gameDetails['game_id']; ?>" class="add-to-cart-btn">Add to Cart</a>
</div>

<footer>
    <?php
    include "footer.php";
    ?>
</footer>

</body>
</html>
