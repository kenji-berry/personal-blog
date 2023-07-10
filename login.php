<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="phonestyle.css" media="screen and (max-width: 768px)">
    <link rel="shortcut icon" href="resources/images/Kenji logo transparent outer.png" type="image/x-icon">
    <script src="index.js"></script>
    <title>Log in</title>
</head>

<body onload="scroll();" id="container2">

    <header id="header">
        <div id="titlelogo" onclick="changeX(this);">
            <div id="responsive-menu">
                <div class="resp-menu-icon1"></div>
                <div class="resp-menu-icon2"></div>
                <div class="resp-menu-icon3"></div>
            </div>
            <div id="logo-header">
                <a href="#start" id="logoimgheaderlink"><img src="resources/images/Kenji logo transparent.png" id="logoimgheader"></a>
                <h1 id="logoname">Kenji Berry</h1>
            </div>
            <div id="header-spacer"></div>
        </div>
        </div>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a href="index.html#about-me" class="animate">About me</a></li>
                <li><a href="index.html#education" class="animate">Education</a></li>
                <li><a href="index.html#skills" class="animate">Skills</a></li>
                <li><a href="viewBlog.php" class="animate">Blog</a></li>
            </ul>
        </nav>
    </header>

    <div id=login-register>
        <form id="login-form" method="POST">
            <div id="log-in-top-close">
                <h2 class="mont">LOG IN</h2>
            </div>
            <div id="loginemail" class="form-element">
                <input type="email" id="email" name="email" placeholder="Email" class="split" required>
            </div>
            <div id="loginpassword" class="form-element">
                <input type="password" id="password" name="password" placeholder="Password" class="split" required>
            </div>
            <div id="signinbutton" class="form-element">
                <input type="submit" name="submit-btn">

            </div>
        </form>
        <form id="register-form" method="POST">
            <div id=register-top-close>
                <h2 class="mont">REGISTER</h2>
            </div>
            <div>
                <input type="email" name="register-email" placeholder="Email" required>
            </div>
            <div>
                <input type="password" name="register-password" placeholder="Password" required>
            </div>
            <div>
                <input type="submit" name="register-submit-btn">
            </div>
        </form>
    </div>

    <footer id="footer1" class="animatelong mont">
        <h2>© Kenji Berry 2023</h2>
        <div id="contact">
            <p id="footer-email">Email: kenji.k.berry@gmail.com</p>
            <a href="https://www.linkedin.com/in/kenji-berry-5783a8252/" target="_blank"><img src="resources/images/linkedinicon.png" id="footer-linkedin"></a>
            <a href="https://github.com/kenji-berry" target="_blank"><img src="resources/images/github.png" id="footer-github"></a>
        </div>
    </footer>

    <?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "ecs417";

    $conn = mysqli_connect($servername, $username, $password, $database);

    if (!$conn) {
        die("failed to connect");
    }
    //log in to existing account
    if (isset($_POST['submit-btn'])) {
        $submitEmail = $_POST['email'];
        $submitPassword = $_POST['password'];
        $query = "SELECT * FROM users WHERE email='$submitEmail'";
        $result = mysqli_query($conn, $query);

        $userdata = mysqli_fetch_assoc($result);

        if ($userdata != null) {
            if (array_key_exists("PASSWORD", $userdata)) {
                if (password_verify($submitPassword, $userdata['PASSWORD']) && $result != null) {
                    session_start();
                    $_SESSION["logged-in"] = "hello";
                    $_SESSION["email"] = $submitEmail;
                    if ($_SESSION["email"] == "ec22459@qmul.ac.uk") {
                        exit(header("Location:addPost.html"));
                    } else {
                        exit(header("Location:viewBlog.php"));
                    }
                } else {
                    echo "log in failed";
                }
            }
        }
    }
    //register account
    if (isset($_POST['register-submit-btn'])) {
        $submitEmail = $_POST['register-email'];
        $submitPassword = $_POST['register-password'];

        $query = "SELECT * FROM users WHERE email='$submitEmail'";
        $result = mysqli_query($conn, $query);
        $count = mysqli_num_rows($result);

        if ($count > 0) {
            echo "email in database";
        } else {
            $submitPassword = password_hash($submitPassword, PASSWORD_DEFAULT);
            $insertquery = "INSERT INTO `users`(`EMAIL`, `PASSWORD`) VALUES ('$submitEmail','$submitPassword')";
            $resultinput = mysqli_query($conn, $insertquery);
            session_start();
            $_SESSION["logged-in"] = true;
            exit(header("Location:viewBlog.php"));
        }
    }
    mysqli_close($conn);
    ?>
</body>

</html>