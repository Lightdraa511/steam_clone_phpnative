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

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate and process the form data
        $name = mysqli_real_escape_string($db_connection, $_POST['name']);
        $description = mysqli_real_escape_string($db_connection, $_POST['description']);
        $release_date = mysqli_real_escape_string($db_connection, $_POST['release_date']);
        $developer = mysqli_real_escape_string($db_connection, $_POST['developer']);
        $publisher = mysqli_real_escape_string($db_connection, $_POST['publisher']);
        $genre = mysqli_real_escape_string($db_connection, $_POST['genre']);
        $price = mysqli_real_escape_string($db_connection, $_POST['price']);

        // File upload handling
        $picture_path = 'gambargame/default.png'; // Default picture path
        if (isset($_FILES['game_picture']) && $_FILES['game_picture']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'gambargame/';
            $upload_file = $upload_dir . basename($_FILES['game_picture']['name']);
            $picture_path = $upload_file;

            // Move the uploaded file to the specified directory
            if (move_uploaded_file($_FILES['game_picture']['tmp_name'], $upload_file)) {
                echo "File is valid, and was successfully uploaded.\n";
            } else {
                echo "Upload failed.\n";
            }
        }

        // Insert the data into the 'game' table
        $insert_sql = "INSERT INTO game (name, description, release_date, developer, publisher, genre, price, picture)
                    VALUES ('$name', '$description', '$release_date', '$developer', '$publisher', '$genre', '$price', '$picture_path')";

        if ($db_connection->query($insert_sql)) {
            echo "Game added successfully!";
        } else {
            echo "Error: " . $db_connection->error;
        }

        // After processing the form, redirect to a different page
        header("Location: add_game.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./image/logotitle.png">
    <title>ADD GAME - STEAM</title>
    <link rel="stylesheet" href="./style/addgamecss.css">
    <link rel="stylesheet" href="./style/footercss.css">
</head>
<body>

    <header>
        <?php
        include "navadmin.php";
        ?>
    </header>

    <div>
        <h1>FORM ADD GAME</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="name">Game Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="release_date">Release Date:</label>
            <input type="date" id="release_date" name="release_date" required>

            <label for="developer">Developer:</label>
            <input type="text" id="developer" name="developer" required>

            <label for="publisher">Publisher:</label>
            <input type="text" id="publisher" name="publisher" required>

            <label for="genre">Genre:</label>
            <select name="genre" id="genre">
                <option value="action">Action</option>
                <option value="sports">Sports</option>
                <option value="survival">Survival</option>
                <option value="fps">FPS</option>
            </select>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required>

            <label for="game_picture">Game Picture:</label>
            <input type="file" id="game_picture" name="game_picture" accept="image/*">

            <button type="submit">Add Game</button>
            <a href="games.php"><button type="button">Cancel</button></a>
        </form>
    </div>

</body>

    <footer>
        <?php
        include "footer.php";
        ?>
    </footer>

</html>