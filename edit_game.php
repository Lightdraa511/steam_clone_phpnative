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

    // Update game details if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Perform necessary form handling and database update here
    // For simplicity, let's assume you have form fields like name, description, release_date, etc.

    $name = mysqli_real_escape_string($db_connection, $_POST['name']);
    $description = mysqli_real_escape_string($db_connection, $_POST['description']);
    $releaseDate = mysqli_real_escape_string($db_connection, $_POST['release_date']);
    $developer = mysqli_real_escape_string($db_connection, $_POST['developer']);
    $publisher = mysqli_real_escape_string($db_connection, $_POST['publisher']);
    $genre = mysqli_real_escape_string($db_connection, $_POST['genre']);
    $price = mysqli_real_escape_string($db_connection, $_POST['price']);
    
    // Handle image upload
    $picture = $gameDetails['picture']; // Default to the existing picture
    if ($_FILES['game_picture']['size'] > 0) {
        $uploadDir = 'gambargame/';
        $uploadFile = $uploadDir . basename($_FILES['game_picture']['name']);
        move_uploaded_file($_FILES['game_picture']['tmp_name'], $uploadFile);
        $picture = $uploadFile;
    }

    // Add other fields as needed

    $updateSql = "UPDATE game SET 
        name='$name', 
        description='$description', 
        release_date='$releaseDate', 
        developer='$developer', 
        publisher='$publisher', 
        genre='$genre', 
        price='$price',
        picture='$picture'
        WHERE game_id='$gameId'";

    if ($db_connection->query($updateSql) === TRUE) {
        echo "Game details updated successfully";
        // You can redirect the user or perform other actions after successful update
    } else {
        echo "Error updating game details: " . $db_connection->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./image/logotitle.png">
    <title>EDIT GAME - STEAM</title>
    <link rel="stylesheet" href="./style/editgamecss.css">
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
    <?php
    if ($gameDetails) {
        echo '<h1>Edit Game: ' . $gameDetails['name'] . '</h1>';
        echo '<form method="POST" action="" enctype="multipart/form-data">';
        echo '<label for="name">Name:</label>';
        echo '<input type="text" id="name" name="name" value="' . $gameDetails['name'] . '" required>';
        echo '<label for="description">Description:</label>';
        echo '<textarea id="description" name="description" required>' . $gameDetails['description'] . '</textarea>';
        echo '<label for="release_date">Release Date:</label>';
        echo '<input type="date" id="release_date" name="release_date" value="' . $gameDetails['release_date'] . '" required>';
        echo '<label for="developer">Developer:</label>';
        echo '<input type="text" id="developer" name="developer" value="' . $gameDetails['developer'] . '" required>';
        echo '<label for="publisher">Publisher:</label>';
        echo '<input type="text" id="publisher" name="publisher" value="' . $gameDetails['publisher'] . '" required>';
        echo '<label for="genre">Genre:</label>';
        echo '<select id="genre" name="genre" required>';
        echo '<option value="action" ' . ($gameDetails['genre'] === 'action' ? 'selected' : '') . '>Action</option>';
        echo '<option value="sports" ' . ($gameDetails['genre'] === 'sports' ? 'selected' : '') . '>Sports</option>';
        echo '<option value="survival" ' . ($gameDetails['genre'] === 'survival' ? 'selected' : '') . '>Survival</option>';
        echo '<option value="fps" ' . ($gameDetails['genre'] === 'fps' ? 'selected' : '') . '>FPS</option>';
        echo '</select>';
        echo '<label for="price">Price:</label>';
        echo '<input type="number" id="price" name="price" value="' . $gameDetails['price'] . '" required>';
        echo '<label for="game_picture">Game Picture:</label>';
        echo '<input type="file" id="game_picture" name="game_picture">';
        // Add other form fields for additional game details
        echo '<button type="submit">Save Changes</button>';
        echo '<a href="games.php"><button type="button" class="cancel-button">Cancel</button></a>';
        echo '</form>';
    } else {
        echo '<p>Game details not found.</p>';
    }
    ?>
    </main>

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