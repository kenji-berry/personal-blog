<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "ecs417";
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("failed to connect");
}
session_start();

$query = "SELECT `dateTime`, `BLOGTITLE`, `BLOGTEXT`, `ID` FROM `blogposts`"; //where email = ...
$result = mysqli_query($conn, $query);
$datas = array();


if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $datas[] = $row;
    }
}

if (array_key_exists("refresh-session", $_SESSION)) {
    if ($_SESSION["refresh-session"] == true) {
        $_SESSION["refresh-session"] = false;
    }
} else {
    $refresh = false;
}

//checks which date is more recent out of two
function compareNumbers($a, $b)
{
    preg_match_all('/\d+/', $a, $matches);
    $numbers_array = $matches[0];

    preg_match_all('/\d+/', $b, $matches2);
    $numbers_array2 = $matches2[0];
    for ($i = 0; $i < count($numbers_array); $i++) {
        //compare year 
        if ($numbers_array[2] >= $numbers_array2[2]) {
            if ($numbers_array[2] == $numbers_array2[2]) {
                //month
                if ($numbers_array[1] >= $numbers_array2[1]) {
                    if ($numbers_array[1] == $numbers_array2[1]) {
                        //day
                        if ($numbers_array[0] >= $numbers_array2[0]) {
                            if ($numbers_array[0] == $numbers_array2[0]) {
                                //hours
                                if ($numbers_array[3] >= $numbers_array2[3]) {
                                    if ($numbers_array[3] == $numbers_array2[3]) {
                                        //minutes
                                        if ($numbers_array[4] >= $numbers_array2[4]) {
                                            if ($numbers_array[4] == $numbers_array2[4]) {
                                                return true;
                                            } else {
                                                return true;
                                            }
                                        } else {
                                            return false;
                                        }
                                    } else {
                                        return true;
                                    }
                                } else {
                                    return false;
                                }
                            } else {
                                return true;
                            }
                        } else {
                            return false;
                        }
                    } else {
                        return true;
                    }
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
//bubble sort using compare numbers function
$n = count($datas);
for ($i = 0; $i < $n - 1; $i++) {
    for ($j = 0; $j < $n - $i - 1; $j++) {
        if (!compareNumbers($datas[$j]['dateTime'], $datas[$j + 1]['dateTime'])) {
            // Swap elements at indices $j and $j+1
            $temp = $datas[$j];
            $datas[$j] = $datas[$j + 1];
            $datas[$j + 1] = $temp;
        }
    }
}

//sort posts by month
function classifyMonth($month, $datas)
{
    $month_array = array();
    for ($i = 0; $i < count($datas); $i++) {
        preg_match_all('/\d+/', $datas[$i]['dateTime'], $matches);
        $numbers_array = $matches[0];
        if ($numbers_array[1] == $month) {
            array_push($month_array, $datas[$i]);
        }
    }
    return $month_array;
}

//if a month rewrite page
if (isset($_POST['change-months-reset'])) {
    if ($_POST['change-months'] == "Jan") {
        $month_array = classifyMonth("01", $datas);
        printMonths($month_array, $conn);
    } else if ($_POST['change-months'] == "Feb") {
        $month_array = classifyMonth("02", $datas);
        printMonths($month_array, $conn);
    } else if ($_POST['change-months'] == "Mar") {
        $month_array = classifyMonth("03", $datas);
        printMonths($month_array, $conn);
    } else if ($_POST['change-months'] == "Apr") {
        $month_array = classifyMonth("04", $datas);
        printMonths($month_array, $conn);
    } else if ($_POST['change-months'] == "May") {
        $month_array = classifyMonth("05", $datas);
        printMonths($month_array, $conn);
    } else if ($_POST['change-months'] == "Jun") {
        $month_array = classifyMonth("06", $datas);
        printMonths($month_array, $conn);
    } else if ($_POST['change-months'] == "Jul") {
        $month_array = classifyMonth("07", $datas);
        printMonths($month_array, $conn);
    } else if ($_POST['change-months'] == "Aug") {
        $month_array = classifyMonth("08", $datas);
        printMonths($month_array, $conn);
    } else if ($_POST['change-months'] == "Sep") {
        $month_array = classifyMonth("09", $datas);
        printMonths($month_array, $conn);
    } else if ($_POST['change-months'] == "Oct") {
        $month_array = classifyMonth("10", $datas);
        printMonths($month_array, $conn);
    } else if ($_POST['change-months'] == "Nov") {
        $month_array = classifyMonth("11", $datas);
    } else if ($_POST['change-months'] == "Dec") {
        $month_array = classifyMonth("12", $datas);
        printMonths($month_array, $conn);
    } else {
        $_SESSION["refresh-session"] = false;
    }
}
//write page
if (array_key_exists("refresh-session", $_SESSION)) {
    if ($_SESSION["refresh-session"] == false) {
        echo "<div id=whole-blog-og class=sans>";
        if (array_key_exists("logged-in", $_SESSION)) {
            echo "<div id=top-right-button2><a href=logout.php><p>LOG OUT</p></a></div>";
            if (array_key_exists("email", $_SESSION)) {
                if ($_SESSION["email"] == "ec22459@qmul.ac.uk") {
                    echo "<div id=top-right-button><a href=addPost.html><p>ADD POST</p></a></div>";
                }
            }
        } else {
            echo "<div id=top-right-button><a href=login.php><p>LOG IN</p></a></div>";
        }
        echo  "<div id=view-blog >";
        echo "<div id=posts-months>";
        echo "<h1>Posts:</h1>";
        echo "<div>";
        echo "<form method=POST>
    <select placeholder=MM name='change-months'>
    <option name= value= style=display:none;>MM</option>
    <option name=January value=Jan>January</option>
    <option name=February value=Feb>February</option>
    <option name=March value=Mar>March</option>
    <option name=April value=Apr>April</option>
        <option name=May value=May>May</option>
    <option name=June value=Jun>June</option>
    <option name=July value=Jul>July</option>
    <option name=August value=Aug>August</option>
        <option name=September value=Sep>September</option>
    <option name=October value=Oct>October</option>
    <option name=November value=Nov>November</option>
    <option name=December value=Dec>December</option>
    </select>";
        echo " <input type=submit name=change-months-reset onclick='test();'></form>";
        echo "</div>";
        echo "</div>";
        for ($i = 0; $i < count($datas); $i += 1) {
            $temptitle = $datas[$i]['BLOGTITLE'];
            $temptext = $datas[$i]['BLOGTEXT'];
            $temptime = $datas[$i]['dateTime'];
            $usedId = $datas[$i]['ID'];
            echo  "<div id=view-blog1>";
            if (array_key_exists("email", $_SESSION)) {
                if ($_SESSION["email"] == "ec22459@qmul.ac.uk") {
                    echo "<form method=POST id=deleteform><button type=submit id=deletebutton name=deletebuttonpost>DELETE POST</button>";
                    echo "<input type=hidden name=blog3 value=" . $datas[$i]["ID"] . "></form>";
                }
            }
            echo "<div id=blog-info>";
            echo "<div id=inside-view-blog>";
            echo "<h2>" .  $temptitle . "</h2>";
            echo "<h2>" . $temptime . "</h2>";
            echo "</div>";
            echo "<p>" .  $temptext . "</p>";
            echo "</div>";
            echo "<div id=blog-comment>";
            echo "<h3 id=comments-seperate> Comments: </h3>";
            if (array_key_exists("logged-in", $_SESSION)) {
                echo "<form method=POST id=add-comment-box>";
                echo "<textarea name=comment-box id=comment-box placeholder='Add a comment' required></textarea>";
                echo "<input type=hidden name=blog-id value=" . $usedId . ">";
                echo "<input type=hidden name=email value=" . $_SESSION["email"] . ">";
                echo "<input type=submit name=blog-comment-submit id=blog-comment-submit>";
                echo "</form>";
            } else {
                echo "<p>log in to comment<p>";
            }

            $commentquery = "SELECT `BLOGCOMMENT`, `dateTimeComment`,`COMMENTID` FROM `blogcomments` WHERE ID=" . $usedId . "";
            $result2 = mysqli_query($conn, $commentquery);
            $blogcom = array();
            if (mysqli_num_rows($result2) > 0) {
                while ($row1 = mysqli_fetch_assoc($result2)) {
                    $blogcom[] = $row1;
                }
            }

            $blogcom = array_reverse($blogcom);
            for ($j = 0; $j < count($blogcom); $j++) {

                if (array_key_exists("email", $_SESSION)) {
                    if ($_SESSION["email"] == "ec22459@qmul.ac.uk") {
                        echo "<form method=POST id=deleteform><button type=submit id=deletebutton name=deletebuttoncom>DELETE COMMENT</button>";
                        echo "<input type=hidden name=comment-id2 value=" . $blogcom[$j]["COMMENTID"] . "></form>";
                    }
                }
                echo "<div id=comment>";
                echo "<div id=comment-content>";
                echo "<p>" . $blogcom[$j]['EMAIL'] . "</p>";
                echo "<p>" . $blogcom[$j]['dateTimeComment'] . "</p>";
                echo "</div>";
                echo "<p>" . $blogcom[$j]['BLOGCOMMENT'] . "</p>";
                echo "</div>";
            }

            echo "</div>";
            if ($i < count($datas) - 1) {
                echo "<hr>";
            }
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<div id=whole-blog-og class=sans>";
    if (array_key_exists("logged-in", $_SESSION)) {
        echo "<div id=top-right-button2><a href=logout.php><p>LOG OUT</p></a></div>";
        if (array_key_exists("email", $_SESSION)) {
            if ($_SESSION["email"] == "ec22459@qmul.ac.uk") {
                echo "<div id=top-right-button><a href=addPost.html><p>ADD POST</p></a></div>";
            }
        }
    } else {
        echo "<div id=top-right-button><a href=login.php><p>LOG IN</p></a></div>";
    }

    echo  "<div id=view-blog >";
    echo "<div id=posts-months>";
    echo "<h1>Posts:</h1>";
    echo "<div>";
    echo "<form method=POST>
        <select placeholder=MM name='change-months'>
        <option name= value= style=display:none;>MM</option>
        <option name=January value=Jan>January</option>
        <option name=February value=Feb>February</option>
        <option name=March value=Mar>March</option>
        <option name=April value=Apr>April</option>
            <option name=May value=May>May</option>
        <option name=June value=Jun>June</option>
        <option name=July value=Jul>July</option>
        <option name=August value=Aug>August</option>
            <option name=September value=Sep>September</option>
        <option name=October value=Oct>October</option>
        <option name=November value=Nov>November</option>
        <option name=December value=Dec>December</option>
        </select>";
    echo "<input type=submit name=change-months-reset onclick='test();'></form>";
    echo "</div>";
    echo "</div>";
    for ($i = 0; $i < count($datas); $i += 1) {
        $temptitle = $datas[$i]['BLOGTITLE'];
        $temptext = $datas[$i]['BLOGTEXT'];
        $temptime = $datas[$i]['dateTime'];
        $usedId = $datas[$i]['ID'];
        echo  "<div id=view-blog1>";
        if (array_key_exists("email", $_SESSION)) {
            if ($_SESSION["email"] == "ec22459@qmul.ac.uk") {
                echo "<form method=POST id=deleteform><button type=submit id=deletebutton name=deletebuttonpost>DELETE POST</button>";
                echo "<input type=hidden name=blog3 value=" . $datas[$i]["ID"] . "></form>";
            }
        }

        echo "<div id=blog-info>";
        echo "<div id=inside-view-blog>";
        echo "<h2>" .  $temptitle . "</h2>";
        echo "<h2>" . $temptime . "</h2>";
        echo "</div>";
        echo "<p>" .  $temptext . "</p>";
        echo "</div>";
        echo "<div id=blog-comment>";
        echo "<h3 id=comments-seperate> Comments: </h3>";
        if (array_key_exists("logged-in", $_SESSION)) {
            echo "<form method=POST id=add-comment-box>";
            echo "<textarea name=comment-box id=comment-box placeholder='Add a comment' required></textarea>";
            echo "<input type=hidden name=blog-id value=" . $usedId . ">";
            echo "<input type=hidden name=email value=" . $_SESSION["email"] . ">";
            echo "<input type=submit name=blog-comment-submit id=blog-comment-submit>";
            echo "</form>";
        } else {
            echo "<p>log in to comment<p>";
        }

        $commentquery = "SELECT `BLOGCOMMENT`, `dateTimeComment`,`COMMENTID`, `EMAIL` FROM `blogcomments` WHERE ID=" . $usedId . "";
        $result2 = mysqli_query($conn, $commentquery);
        $blogcom = array();
        if (mysqli_num_rows($result2) > 0) {
            while ($row1 = mysqli_fetch_assoc($result2)) {
                $blogcom[] = $row1;
            }
        }
        $blogcom = array_reverse($blogcom);
        for ($j = 0; $j < count($blogcom); $j++) {
            if (array_key_exists("email", $_SESSION)) {
                if ($_SESSION["email"] == "ec22459@qmul.ac.uk") {
                    echo "<form method=POST id=deleteform><button type=submit id=deletebutton name=deletebuttoncom>DELETE COMMENT</button>";
                    echo "<input type=hidden name=comment-id2 value=" . $blogcom[$j]["COMMENTID"] . "></form>";
                }
            }

            echo "<div id=comment>";
            echo "<div id=comment-content>";
            echo "<p>" . $blogcom[$j]['EMAIL'] . "</p>";
            echo "<p>" . $blogcom[$j]['dateTimeComment'] . "</p>";
            echo "</div>";
            echo "<p>" . $blogcom[$j]['BLOGCOMMENT'] . "</p>";
            echo "</div>";
        }

        echo "</div>";
        if ($i < count($datas) - 1) {
            echo "<hr>";
        }
        echo "</div>";
    }
    echo "</div>";
    echo "</div>";
}

//rewrite page for months 
function printMonths($month_array, $conn)
{
    $_SESSION["refresh-session"] = true;
    echo "<div id=whole-blog-og class=sans>";
    if (array_key_exists("logged-in", $_SESSION)) {
        echo "<div id=top-right-button2><a href=logout.php><p>LOG OUT</p></a></div>";
        if (array_key_exists("email", $_SESSION)) {
            if ($_SESSION["email"] == "ec22459@qmul.ac.uk") {
                echo "<div id=top-right-button><a href=addPost.html><p>ADD POST</p></a></div>";
            }
        }
    } else {
        echo "<div id=top-right-button><a href=login.php><p>LOG IN</p></a></div>";
    }
    echo  "<div id=view-blog >";
    echo "<div id=posts-months>";
    echo "<h1>Posts:</h1>";
    echo "<div>";
    echo "<form method=POST>
        <select placeholder=MM name='change-months'>
        <option name= value= style=display:none;>MM</option>
        <option name=January value=Jan>January</option>
        <option name=February value=Feb>February</option>
        <option name=March value=Mar>March</option>
        <option name=April value=Apr>April</option>
            <option name=May value=May>May</option>
        <option name=June value=Jun>June</option>
        <option name=July value=Jul>July</option>
        <option name=August value=Aug>August</option>
            <option name=September value=Sep>September</option>
        <option name=October value=Oct>October</option>
        <option name=November value=Nov>November</option>
        <option name=December value=Dec>December</option>
        </select>";
    echo " <input type=submit name=change-months-reset onclick='test();'></form>";
    echo "</div>";
    echo " </div>";
    for ($i = 0; $i < count($month_array); $i += 1) {
        $temptitle = $month_array[$i]['BLOGTITLE'];
        $temptext = $month_array[$i]['BLOGTEXT'];
        $temptime = $month_array[$i]['dateTime'];
        $usedId = $month_array[$i]['ID'];
        echo  "<div id=view-blog1>";
        if (array_key_exists("email", $_SESSION)) {
            if ($_SESSION["email"] == "ec22459@qmul.ac.uk") {
                echo "<form method=POST id=deleteform><button type=submit id=deletebutton name=deletebuttonpost>DELETE POST</button>";
                echo "<input type=hidden name=blog3 value=" . $month_array[$i]["ID"] . "></form>";
            }
        }
        echo "<div id=blog-info>";
        echo "<div id=inside-view-blog>";
        echo "<h2>" .  $temptitle . "</h2>";
        echo "<h2>" . $temptime . "</h2>";
        echo "</div>";
        echo "<p>" .  $temptext . "</p>";
        echo "</div>";
        echo "<div id=blog-comment>";
        echo "<h3 id=comments-seperate> Comments: </h3>";
        if (array_key_exists("logged-in", $_SESSION)) {
            echo "<form method=POST id=add-comment-box>";
            echo "<textarea name=comment-box id=comment-box placeholder='Add a comment' required></textarea>";
            echo "<input type=hidden name=blog-id value=" . $usedId . ">";
            echo "<input type=hidden name=email value=" . $_SESSION["email"] . ">";
            echo "<input type=submit name=blog-comment-submit id=blog-comment-submit>";
            echo "</form>";
        } else {
            echo "<p>log in to comment<p>";
        }

        $commentquery = "SELECT `BLOGCOMMENT`, `dateTimeComment`,`COMMENTID` FROM `blogcomments` WHERE ID=" . $usedId . "";
        $result2 = mysqli_query($conn, $commentquery);
        $blogcom = array();
        if (mysqli_num_rows($result2) > 0) {
            while ($row1 = mysqli_fetch_assoc($result2)) {
                $blogcom[] = $row1;
            }
        }
        $blogcom = array_reverse($blogcom);
        for ($j = 0; $j < count($blogcom); $j++) {
            if (array_key_exists("email", $_SESSION)) {
                if ($_SESSION["email"] == "ec22459@qmul.ac.uk") {
                    echo "<form method=POST id=deleteform><button type=submit id=deletebutton name=deletebuttoncom>DELETE COMMENT</button>";
                    echo "<input type=hidden name=comment-id2 value=" . $blogcom[$j]["COMMENTID"] . "></form>";
                }
            }
            echo "<div id=comment>";
            echo "<div id=comment-content>";
            echo "<p>" . $blogcom[$j]['EMAIL'] . "</p>";
            echo "<p>" . $blogcom[$j]['dateTimeComment'] . "</p>";
            echo "</div>";
            echo "<p>" . $blogcom[$j]['BLOGCOMMENT'] . "</p>";
            echo "</div>";
        }

        echo "</div>";
        if ($i < count($month_array) - 1) {
            echo "<hr>";
        }
        echo "</div>";
    }
    echo "</div>";
    echo "</div>";
}

//post comment
if (isset($_POST['blog-comment-submit'])) {
    $submitComment = $_POST['comment-box'];
    $email = $_SESSION["email"];
    $blogID = $_POST['blog-id'];
    $query = "SELECT * FROM blogposts WHERE ID='$blogID'";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);
    $dateTime = date("d/m/Y, H:i");

    $insertquery = "INSERT INTO `blogcomments`(`COMMENTID`, `EMAIL`, `BLOGCOMMENT`, `dateTimeComment`, `ID`) VALUES ('0','$email','$submitComment','$dateTime','$blogID')";
    $resultinput = mysqli_query($conn, $insertquery);
}
//delete commment
if (isset($_POST['deletebuttoncom'])) {
    $commentID = $_POST['comment-id2'];
    $query = "DELETE FROM blogcomments WHERE COMMENTID='$commentID'";
    $result = mysqli_query($conn, $query);
}
//delete post
if (isset($_POST['deletebuttonpost'])) {
    $blogID = $_POST['blog3'];
    $query = "DELETE FROM blogcomments WHERE ID='$blogID'";
    $result = mysqli_query($conn, $query);

    $query = "DELETE FROM blogposts WHERE ID='$blogID'";
    $result = mysqli_query($conn, $query);
}

mysqli_close($conn);
?>



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
    <title>Blog</title>
</head>

<body onload="scroll()" id="container2">

    <header id="header">
        <div id="titlelogo" onclick="changeX(this);">
            <div id="responsive-menu">
                <div class="resp-menu-icon1"></div>
                <div class="resp-menu-icon2"></div>
                <div class="resp-menu-icon3"></div>
            </div>
            <div id="logo-header">
                <a href="index.html#start" id="logoimgheaderlink"><img src="resources/images/Kenji logo transparent.png" id="logoimgheader"></a>
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

    <footer id="footer" class="animatelong mont">
        <h2>© Kenji Berry 2023</h2>
        <div id="contact">
            <p id="footer-email">Email: kenji.k.berry@gmail.com</p>
            <a href="https://www.linkedin.com/in/kenji-berry-5783a8252/" target="_blank"><img src="resources/images/linkedinicon.png" id="footer-linkedin"></a>
            <a href="https://github.com/kenji-berry" target="_blank"><img src="resources/images/github.png" id="footer-github"></a>
        </div>
    </footer>
</body>

</html>