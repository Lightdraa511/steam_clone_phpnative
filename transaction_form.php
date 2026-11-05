<?php
session_start(); // Start the session
include "connection.php";

// Function to check if the user is logged in
function isLoggedIn() {
    return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

// Check if the user is not logged in, then redirect to the login page
if (!isLoggedIn()) {
    header('Location: form_login.php'); 
    exit();
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

// Dapatkan user_id dari sesi
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

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

// Process purchase if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['purchase_submit'])) {
    // Validate purchase amount
    $purchaseAmount = isset($_POST['purchase_amount']) ? floatval($_POST['purchase_amount']) : 0.00;

    // Validate that purchase amount is greater than 0
    if ($purchaseAmount < 0) {
        echo '<script>alert("Please enter a valid purchase amount.");</script>';
    } else {
        // Check if purchase amount matches game price
        $gamePrice = floatval($gameDetails['price']);
        if ($purchaseAmount != $gamePrice) {
            echo '<script>alert("Purchase amount must match the game price.");</script>';
        } else {
            // Check if the user already owns the game
            $checkOwnershipSql = "SELECT * FROM library WHERE user_id = '$userId' AND game_id = '$gameId'";
            $checkOwnershipResult = $db_connection->query($checkOwnershipSql);

            if ($checkOwnershipResult->num_rows > 0) {
                echo '<script>alert("You already own this game.");</script>';
            } else {
                // Insert transaction record
                $insertTransactionSql = "INSERT INTO transaction (user_id, game_id, purchase_amount, purchase_date) 
                                         VALUES ('$userId', '$gameId', '$purchaseAmount', NOW())";

                $insertTransactionResult = $db_connection->query($insertTransactionSql);

                if ($insertTransactionResult) {
                    // Insert game into library
                    $insertLibrarySql = "INSERT INTO library (user_id, game_id) VALUES ('$userId', '$gameId')";
                    $insertLibraryResult = $db_connection->query($insertLibrarySql);

                    if ($insertLibraryResult) {
                        '<script>alert("Purchase successful! The game has been added to your library.");</script>';
                       header('Location: library.php');
                    } else {
                        '<script>alert("Error adding game to library.");</script>';
                    }
                } else {
                     '<script>alert("Error processing purchase.");</script>';
                }
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
    <title><?php echo $gameDetails['name']; ?> - STEAM</title>
    <link rel="stylesheet" href="./style/transactionformcss.css">
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

    <div class="buy-section">
        <div class="buy-title">
            <h2>Buy <?php echo $gameDetails['name']; ?></h2>
        </div>
        <p><strong>Price :</strong> Rp <?php echo $gameDetails['price']; ?></p>
            <form method="POST" action="">
                <label for="purchase_amount">Purchase Amount:</label>
                <input type="number" id="purchase_amount" name="purchase_amount" min="0" step="0.01" required>
                <button type="submit" name="purchase_submit">Purchase</button>
            </form>
            <a href="index.php"><button class="cancel-btn" type="button">Cancel</button></a>
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