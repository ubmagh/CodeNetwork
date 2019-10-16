<?php

if (empty($_GET['Keywords'])) {
    header("location:./");
}

$keyword = $_GET['Keywords'];
$keyword = str_replace("@", "", $keyword);
include "../includes/config.php";
session_start(); //// to exclude this user from results
$username = $_SESSION['username'];

$checkNotFound = true; // Nothing found
$ToEcho = '';

//Check for first results if no one exists Return quickly nothing found

$getter = $mysqli->query("SELECT Email From profiles WHERE username like '%$keyword%';");
$getter = $getter->fetch_assoc();

if (!empty($getter['Email']))
    $checkNotFound = false; /// break the case

$getter = $mysqli->query("SELECT id,Email from users WHERE Fname like '%$keyword%' OR Lname like '%$keyword%' ; ");
$getter = $getter->fetch_assoc();

if (!empty($getter['id']))
    $checkNotFound = false; /// break the case

if ($checkNotFound == true) {
    $ToEcho = "nothing";
}

//DONT FIND ME ! imean current user /// removing current user from single results
$getter = $mysqli->query("SELECT count(username) as num,Email,username FROM profiles WHERE Email='" . $getter['Email'] . "' ;");
$getter = $getter->fetch_assoc();
if ($getter['num'] == 1) {
    if ($getter['username'] == $username) {
        $ToEcho = "nothing";
    }
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($ToEcho != "nothing") {
    $i = 0;
    $Col1 = '';
    $Col2 = '';
    $Col3 = '';
    $getter = $mysqli->query("SELECT Fname,Lname,Email,City,Country,avatarEXT FROM users where Fname like '%$keyword%' or Lname like '%$keyword%' ; ");
    while ($row = $getter->fetch_assoc()) {

        //removing current user from multiple Results
        $memberEmail = $row['Email'];
        $GetUsername = $mysqli->query("SELECT username FROM profiles WHERE Email='$memberEmail';");
        $GetUsername = $GetUsername->fetch_assoc();
        $GetUsername = $GetUsername['username'];

        if ($GetUsername == $username)
            continue;

        if (($i % 3) == 0) {
            $Col1 = $Col1 . '
            <div class="card m-2 p-2 bg-white">
                
                    <div class="mt-1">
                        <a href="./?username=' . $GetUsername . '">
                            <img src="../Profile/Avatars/' . $GetUsername . '.' . $row['avatarEXT'] . '" alt="' . $GetUsername . '-Avatar" style="max-width:150px;">
                        </a>
                    </div>
                    <div>
                        <a href="./?username=' . $GetUsername . '">
                            <h4 class="mt-1 text-dark mb-0">' . $row['Fname'] . ' ' . $row['Lname'] . '</h4>
                            <p class="text-center m-0 p-0 text-secondary">@' . $GetUsername . '</p>
                        </a>
                         <p class="text-secondary"> ' . $row['City'] . ' - ' . $row['Country'] . '</p>
                    </div>
                </a>
            </div>
        ';
        }

        if (($i % 3) == 1) {
            $Col2 = $Col2 . '
            <div class="card m-2 p-2 bg-white">
                
                    <div class="mt-1">
                        <a href="./?username=' . $GetUsername . '">
                            <img src="../Profile/Avatars/' . $GetUsername . '.' . $row['avatarEXT'] . '" alt="' . $GetUsername . '-Avatar" style="max-width:150px;">
                        </a>
                    </div>
                    <div>
                        <a href="./?username=' . $GetUsername . '">
                            <h4 class="mt-1 text-dark mb-0">' . $row['Fname'] . ' ' . $row['Lname'] . '</h4>
                            <p class="text-center m-0 p-0 text-secondary">@' . $GetUsername . '</p>
                        </a>
                         <p class="text-secondary"> ' . $row['City'] . ' - ' . $row['Country'] . '</p>
                    </div>
                </a>
            </div>
        ';
        }

        if (($i % 3) == 2) {
            $Col3 = $Col3 . '
            <div class="card m-2 p-2 bg-white">
                
                    <div class="mt-1">
                        <a href="./?username=' . $GetUsername . '">
                            <img src="../Profile/Avatars/' . $GetUsername . '.' . $row['avatarEXT'] . '" alt="' . $GetUsername . '-Avatar" style="max-width:150px;">
                        </a>
                    </div>
                    <div>
                    <a href="./?username=' . $GetUsername . '">
                    <h4 class="mt-1 text-dark mb-0">' . $row['Fname'] . ' ' . $row['Lname'] . '</h4>
                    <p class="text-center m-0 p-0 text-secondary">@' . $GetUsername . '</p>
                </a>
                 <p class="text-secondary"> ' . $row['City'] . ' - ' . $row['Country'] . '</p>
                    </div>
                </a>
            </div>
        ';
        }

        $i++;
    }


    //// if searching using Username

    $getter2 = $mysqli->query("SELECT Email,username From profiles WHERE username like '%$keyword%' and username <>'".$username."' AND Email not in(SELECT Email FROM users where Fname like '%$keyword%' or Lname like '%$keyword%');");
    while ($row2 = $getter2->fetch_assoc()) {
        $getter = $mysqli->query("SELECT Fname,Lname,Email,City,Country,avatarEXT FROM users where Email='" . $row2['Email'] . "' ;");
        $row = $getter->fetch_assoc();
        $GetUsername=$row2['username'];

        if (($i % 3) == 0) {
            $Col1 = $Col1 . '
            <div class="card m-2 p-2 bg-white">
                
                    <div class="mt-1">
                        <a href="./?username=' . $GetUsername . '">
                            <img src="../Profile/Avatars/' . $GetUsername . '.' . $row['avatarEXT'] . '" alt="' . $GetUsername . '-Avatar" style="max-width:150px;">
                        </a>
                    </div>
                    <div>
                        <a href="./?username=' . $GetUsername . '">
                            <h4 class="mt-1 text-dark mb-0">' . $row['Fname'] . ' ' . $row['Lname'] . '</h4>
                            <p class="text-center m-0 p-0 text-secondary">@' . $GetUsername . '</p>
                        </a>
                         <p class="text-secondary"> ' . $row['City'] . ' - ' . $row['Country'] . '</p>
                    </div>
                </a>
            </div>
        ';
        }

        if (($i % 3) == 1) {
            $Col2 = $Col2 . '
            <div class="card m-2 p-2 bg-white">
                
                    <div class="mt-1">
                        <a href="./?username=' . $GetUsername . '">
                            <img src="../Profile/Avatars/' . $GetUsername . '.' . $row['avatarEXT'] . '" alt="' . $GetUsername . '-Avatar" style="max-width:150px;">
                        </a>
                    </div>
                    <div>
                        <a href="./?username=' . $GetUsername . '">
                            <h4 class="mt-1 text-dark mb-0">' . $row['Fname'] . ' ' . $row['Lname'] . '</h4>
                            <p class="text-center m-0 p-0 text-secondary">@' . $GetUsername . '</p>
                        </a>
                         <p class="text-secondary"> ' . $row['City'] . ' - ' . $row['Country'] . '</p>
                    </div>
                </a>
            </div>
        ';
        }

        if (($i % 3) == 2) {
            $Col3 = $Col3 . '
            <div class="card m-2 p-2 bg-white">
                
                    <div class="mt-1">
                        <a href="./?username=' . $GetUsername . '">
                            <img src="../Profile/Avatars/' . $GetUsername . '.' . $row['avatarEXT'] . '" alt="' . $GetUsername . '-Avatar" style="max-width:150px;">
                        </a>
                    </div>
                    <div>
                    <a href="./?username=' . $GetUsername . '">
                    <h4 class="mt-1 text-dark mb-0">' . $row['Fname'] . ' ' . $row['Lname'] . '</h4>
                    <p class="text-center m-0 p-0 text-secondary">@' . $GetUsername . '</p>
                </a>
                 <p class="text-secondary"> ' . $row['City'] . ' - ' . $row['Country'] . '</p>
                    </div>
                </a>
            </div>
        ';
        }

        $i++;


    }



    $ToEcho = $ToEcho . '<div class="col" id="Col1">
' . $Col1 . '
</div>

<div class="col" id="Col2">
' . $Col2 . '
</div>

<div class="col" id="Col3">
' . $Col3 . '
</div>';
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////return results
echo $ToEcho;
/////
