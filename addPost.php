<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "ecs417";

$conn = mysqli_connect($servername,$username,$password,$database);

if(!$conn){
    die("failed to connect");
}
session_start();

$_POST['blog-submit-btn'];
$submitName = $_POST['blog-name'];
$submitText = $_POST['blog-text'];

$query = "SELECT * FROM blogposts WHERE blogtitle='$submitName'";
$result = mysqli_query($conn,$query);
$count = mysqli_num_rows($result);
$dateTime = date("d/m/Y, H:i");

if($count>0){
    echo "name used";
}
else{
    $insertquery = "INSERT INTO `blogposts`(`ID`, `BLOGTITLE`, `BLOGTEXT`, `dateTime`) VALUES ('0','$submitName','$submitText','$dateTime')";
    $resultinput = mysqli_query($conn,$insertquery);
    exit(header("Location:viewBlog.php"));
}

mysqli_close($conn);
?>