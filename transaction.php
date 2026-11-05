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

// Function to get all transactions
function getAllTransactions() {
    global $db_connection;

    $sql = "SELECT t.*, g.name as game_name, u.username FROM `transaction` t 
            INNER JOIN user u ON t.user_id = u.user_id
            INNER JOIN game g ON t.game_id = g.game_id";
    $result = $db_connection->query($sql);

    return $result;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./image/logotitle.png">
    <title>TRANSACTION HISTORY - STEAM</title>
    <link rel="stylesheet" href="./style/transactioncss.css">
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
        <div class="transaction-container">
            <h2>Transaction History</h2>
            <?php
            $transactions = getAllTransactions();

            if ($transactions && $transactions->num_rows > 0) {
                while ($transaction = $transactions->fetch_assoc()) {
                    echo '<div class="transaction-entry">';
                    echo '<h3>' . $transaction['username'] . '</h3>';
                    echo '<p>Game : ' . $transaction['game_name'] . '</p>';
                    echo '<p>Purchase Amount : Rp ' . $transaction['purchase_amount'] . '</p>';
                    echo '<p>Purchase Date : ' . $transaction['purchase_date'] . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No transactions found.</p>';
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
