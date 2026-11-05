<?php
$current_page = basename($_SERVER['PHP_SELF'] ?? '');

$isGameActive = in_array($current_page, ['games.php', 'add_game.php', 'edit_game.php']);
$isUserActive = ($current_page === 'users.php');
$isTransactionActive = ($current_page === 'transaction.php');
?>
<style>
    nav a.active {
        color: #1a56e2 !important;
    }
</style>
    <img src="./image/header_logo.png">
    <nav><a href="games.php" class="<?php echo $isGameActive ? 'active' : ''; ?>">GAME</a></nav>
    <nav><a href="users.php" class="<?php echo $isUserActive ? 'active' : ''; ?>">USER</a></nav>
    <nav><a href="transaction.php" class="<?php echo $isTransactionActive ? 'active' : ''; ?>">TRANSACTION</a></nav>
    <nav><a href="index.php">BACK TO STORE</a></nav>
    <div class="header-right">
        <?php
        if (isLoggedIn()) {
            displayUserMenu();
        } else {
            echo '<nav style="margin-top: -40px;"><a href="form_login.php">login</a></nav>';
        }
        ?>
    </div>