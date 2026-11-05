<?php
$current_page = basename($_SERVER['PHP_SELF'] ?? '');

$isStoreActive = in_array($current_page, ['index.php', 'game_detail.php', 'result.php', 'transaction_form.php', '']);
$isLibraryActive = ($current_page === 'library.php');
$isAdminActive = in_array($current_page, ['games.php', 'add_game.php', 'edit_game.php', 'users.php', 'transaction.php']);
$isLoginActive = ($current_page === 'form_login.php');
?>
<style>
    nav a.active {
        color: #1a56e2 !important;
    }
</style>
        <img src="./image/header_logo.png">
        <nav><a href="index.php" class="<?php echo $isStoreActive ? 'active' : ''; ?>">STORE</a></nav>
        <nav><a href="library.php" class="<?php echo $isLibraryActive ? 'active' : ''; ?>">LIBRARY</a></nav>

        <?php
        // Check if the user is logged in
        if (isLoggedIn()) {
            // Display "ADMIN MODE" link only if the user type is admin
            if ($_SESSION['usertype'] === 'admin') {
                echo '<nav><a href="games.php" class="' . ($isAdminActive ? 'active' : '') . '">ADMIN MODE</a></nav>';
            }

            // Display user menu
            displayUserMenu();
        } else {
            // Display login link for users who are not logged in
            echo '<div class="header-right"><nav style="margin-top: -40px;"><a href="form_login.php" class="' . ($isLoginActive ? 'active' : '') . '">login</a></nav></div>';
        }
        ?>
