<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./image/logotitle.png">
    <link rel="stylesheet" href="./style/addusercss.css">
    <link rel="stylesheet" href="./style/footercss.css">
    <title>SIGN UP - STEAM</title>
    
    <style>
    body {
        font-family: "Motiva Sans", sans-serif;
        margin: 0;
        padding: 0;
        background-image: url(./image/backgroundformlogin.jpg);
        background-repeat: no-repeat;
        background-size: 10%;
        background-size: contain;
        background-color: #181a21;
        }
        
    h1 {
        font-size: 36px;
        color: #fff;
        text-align: center;
    }
    </style>
</head>

<body>

    <header>
        <img src="./image/header_logo.png">
        <nav><a href="index.php">STORE</a></nav>
        <nav><a href="library.php">LIBRARY</a></nav>
    </header>

    <h1>CREATE YOUR ACCOUNT</h1>
    <main>
        <form method="post" action="create_user.php">
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" required />
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" required />
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password_user" required />
            </div>
            <div>
                <label for="fullname">Fullname</label>
                <input type="text" name="fullname" required />
            </div>
            <div>
                <input type="submit" name="save" value="Continue" />
            </div>
        </form>
    </main>

</body>

    <footer>
        <?php
        include "footer.php";
        ?>
    </footer>

</html>
