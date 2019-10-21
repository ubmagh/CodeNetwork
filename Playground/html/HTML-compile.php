<?php
if (!isset($_POST['input']))
	Header("location:./");

session_start();

$filename = $_SESSION['username'] . "-html.html";

$code_source = $_POST['input'];

$fileCode = fopen("./tmp/" . $filename, "w+");

fwrite($fileCode, $code_source);

echo $filename;

	//sleep(60);
