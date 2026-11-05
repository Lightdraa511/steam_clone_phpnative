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

// Get user details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM user WHERE user_id = '$user_id'";
$result = $db_connection->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    // Handle the case where the user is not found
    die("Error: User not found");
}

// Update profile if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['umum_submit'])) {
    $newUsername = $_POST['new_username'];
    $newFullName = $_POST['new_fullname'];

    // Update the user's information
    $updateSql = "UPDATE user SET username = '$newUsername', fullname = '$newFullName' WHERE user_id = '$user_id'";
    $updateResult = $db_connection->query($updateSql);

    if ($updateResult) {
        // Redirect to the profile page after a successful update
        header('Location: profile.php');
        exit();
    } else {
        // Handle the case where the update fails
        echo "Error updating profile: " . $db_connection->error;
    }
}

// Process avatar update if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['avatar_submit']) && isset($_FILES['new_avatar'])) {
    $uploadDir = 'gambaruser/';
    $uploadFile = $uploadDir . basename($_FILES['new_avatar']['name']);
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

    // Check if the file is an image
    $check = getimagesize($_FILES['new_avatar']['tmp_name']);
    if ($check === false) {
        echo "File is not an image.";
        exit();
    }

    // Check file size
    if ($_FILES['new_avatar']['size'] > 500000) {
        echo "Sorry, your file is too large.";
        exit();
    }

    // Allow certain file formats
    $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedFormats)) {
        echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        exit();
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['new_avatar']['tmp_name'], $uploadFile)) {
        $avatarUpdateSql = "UPDATE user SET photo_profile = '$uploadFile' WHERE user_id = '$user_id'";
        $avatarUpdateResult = $db_connection->query($avatarUpdateSql);

        if ($avatarUpdateResult) {
            // Redirect to the profile page after a successful update
            header('Location: profile.php');
            exit();
        } else {
            // Handle the case where the avatar update fails
            echo "Error updating avatar: " . $db_connection->error;
        }
    } else {
        echo "Error uploading file.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./image/logotitle.png">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="./style/editprofilecss.css">
    <link rel="stylesheet" href="./style/footercss.css">
    <style>
    body {
        display: flex;
        flex-direction: column;
        background-color: #1b2838;
        margin: 0;
        padding: 0;
        font-family: "Motiva Sans", sans-serif;
    }
    </style>

    <script>
        function showSection(sectionId) {
            const sections = ['umum', 'avatar'];
            sections.forEach(section => {
                document.getElementById(section).style.display = section === sectionId ? 'block' : 'none';
            });
        }
    </script>
</head>

<body>

    <header>
        <?php
        include "nav.php";
        ?>
    </header>

    <main>
    <div class="ContentOne">
        <div class="edit-profile-container">
            <div class="edit-profile-nav">
                <a href="javascript:void(0)" onclick="showSection('umum')">Umum</a>
                <a href="javascript:void(0)" onclick="showSection('avatar')">Avatar</a>
            </div>
            <div class="edit-profile-content">
                <div id="umum">
                    <h2>Umum</h2>
                    <form class="edit-profile-form" method="POST" action="">
                        <label for="new_username">Username</label>
                        <input type="text" id="new_username" name="new_username" value="<?php echo $user['username']; ?>" required>

                        <label for="new_fullname">Full Name</label>
                        <input type="text" id="new_fullname" name="new_fullname" value="<?php echo $user['fullname']; ?>" required>

                        <button type="submit" name="umum_submit">Save Changes</button>
                        <a href="profile.php"><button type="button">Cancel</button></a>
                    </form>
                </div>


        <div id="avatar" style="display: none;">
            <h2>Avatar</h2>
            <form class="edit-profile-form" method="POST" action="" enctype="multipart/form-data">
                <div style="display: flex; align-items: center; margin-bottom: 20px;">
                    <div style="flex-shrink: 0; margin-right: 20px;">
                        <img src="<?php echo $user['photo_profile']; ?>" alt="Avatar" style="width: 150px; height: 150px;">
                    </div>
                    <div>
                        <label for="new_avatar" class="custom-file-upload">
                            Upload Your Avatar
                        </label>
                        <input type="file" id="new_avatar" name="new_avatar" accept="image/*" required style="display: none;">
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end;">
                    <button type="button" onclick="showSection('umum')">Cancel</button>
                    <button type="submit" name="avatar_submit">Save Changes</button>
                </div>
            </form>
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
