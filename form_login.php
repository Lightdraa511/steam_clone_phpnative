<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./image/logotitle.png">
    <link rel="stylesheet" href="./style/formlogincss.css">
    <link rel="stylesheet" href="./style/footercss.css">
    <title>SIGN IN - STEAM</title>
    <style>
    body {
        font-family: "Motiva Sans", sans-serif;
        margin: 0;
        padding: 0;
        background-image: url(image/backgroundformlogin.jpg);
        background-repeat: no-repeat;
        background-size: 10%;
        background-size: contain;
        background-color: #181a21;
    }
    </style>
</head>

<body>

    <header>
        <img src="./image/header_logo.png">
        <nav><a href="index.php">STORE</a></nav>
        <nav><a href="library.php">LIBRARY</a></nav>
    </header>

    <h1>Sign In</h1>

    <main>
        <form method="post" action="login.php">
            <label class="fontsign" for="username">SIGN IN WITH ACCOUNT NAME</label>
            <input type="text" name="username" id="username" required />

            <label for="pass">PASSWORD</label>
            <input type="password" name="password_user" id="pass" required>

     
            <input type="submit" name="login" value="SIGN IN" />
        </form>
    </main>

<footer>
    <div class="page_content">
			<div class="login_bottom_row">
			<div class="login_btn_ctn login_bottom_row_item">
				<div class="headline">New to Steam ?</div>
				<a target="_top" href="add_user.php" class="login_create_btn btn_blue_steamui btn_medium">
					<span>Create an account</span>
				</a>
			</div>
			<div class="login_bottom_row_item">
				<div class="subtext">It's free and easy. Discover thousands of <br> games to play with millions of new friends.<br><a class="login_join_desc about_link" href="#" >Pelajari lebih lanjut tentang Steam</a>
				</div>
			</div>

		</div>
    </div>
        <?php
        include "footer.php";
        ?>
</footer>

</body>
</html>
