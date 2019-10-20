<?php

session_start();
include "../includes/config.php";

$username = $_SESSION['username'];

echo '
<table class="table col-10 mx-auto">
    <tbody>
        
';
$i = 1;
$Query = $mysqli->query("SELECT * FROM follows WHERE username='$username' order by id ;");
while ($row = $Query->fetch_assoc()) {
    $followingUsername = $row['following'];
    $following = $mysqli->query("SELECT Fname,Lname,avatarEXT FROM users WHERE Email=(SELECT Email FROM profiles WHERE username='$followingUsername') ;");
    $following = $following->fetch_assoc();
    echo '
    <tr id="list-item-' . $i . '">
            <td scope="row ml-1"></td>
            <td>
                <a href="../members/?username=' . $followingUsername . '" class="tweetEntry-account-group">
                    <img class="tweetEntry-avatar" src="./Avatars/' . $followingUsername . '.' . $following['avatarEXT'] . '">
                    <strong class="tweetEntry-fullname">
                        ' . $following['Fname'] . ' ' . $following['Lname'] . '
                        </strong>
                        
                        <span class="tweetEntry-username">
                            @<b>' . $followingUsername . '</b>
                        </span>
                </a>
            </td>
        <td class="text-danger">
        <i class="fas fa-user-times" style="cursor:pointer;" onclick="Unfollow(' . "'" . $followingUsername . "'" . ',' . $i . ')"></i> <span style="cursor:pointer;" onclick="Unfollow(' . "'" . $followingUsername . "'" . ',' . $i . ')">Unfollow</span>
        </td>
    </tr>
    ';
    $i++;
}
echo '
    </tbody>
</table>
';
