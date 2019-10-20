<?php
if (empty($_GET['postID'])) {
    header("location:./");
}

session_start();
include "../includes/config.php";

$username = $_SESSION['username'];
$pid = $_GET['postID'];

$Query = $mysqli->query("SELECT username FROM likes WHERE PostID='$pid' ;");
while ($row = $Query->fetch_assoc()) {
    $likerUsername = $row['username'];
    $liker = $mysqli->query("SELECT Fname,Lname,avatarEXT FROM users WHERE Email=(SELECT Email FROM profiles WHERE username='$likerUsername') ;");
    $liker = $liker->fetch_assoc();
    echo '
    <div class="tweetEntry border-0 rounded my-1">
    <div class="tweetEntry-content mx-auto col-8">
        <a href="./?username=' . $likerUsername . '" class="tweetEntry-account-group">
            <img class="tweetEntry-avatar" src="../Profile/Avatars/' . $likerUsername . '.' . $liker['avatarEXT'] . '">
            <strong class="tweetEntry-fullname">
                ' . $liker['Fname'] . ' ' . $liker['Lname'] . '
                </strong>
                
                <span class="tweetEntry-username">
                    @<b>' . $likerUsername . '</b>
                </span>
        </a>
    </div>
    </div>
    ';
}
