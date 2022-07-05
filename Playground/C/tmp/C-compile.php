<?php
if (!isset($_POST['input']))
	Header("location:./");
session_start();
$username = $_SESSION['username'];

$win_platform = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

$CC = "gcc";
if ($win_platform) {
	$out = $username . ".exe";
}else{
	$out = "./".$username . ".out";
}
$code = $_POST["input"];

/// Disallow some functions :DD

if (strstr($code, "system('") || strstr($code, 'system("')) {
	echo "System Function is not allowed ! ";
	exit();
}
if (strstr($code, 'remove("') || strstr($code, "remove('")) {
	echo "remove Function is not allowed ! ";
	exit();
}
if (strstr($code, 'fopen("') || strstr($code, "fopen('")) {
	echo "File Function is not allowed ! ";
	exit();
}


$input = $_POST["Args"];
$filename_code = $username . "main.c";
$filename_in = $username . "input.txt";
$filename_error = $username . "error.txt";
if ($win_platform) {
	$executable = $username . ".exe";
}else{
	$executable = $username . ".out";
}
$command = $CC . " -lm " . $filename_code . " -o " . $out;
$command_error = $command . " 2> " . $filename_error;

if (empty($code)) {
	echo "no code to compile ! ";
	return;
}

$file_code = fopen($filename_code, "w+");
fwrite($file_code, $code);
fclose($file_code);
$file_in = fopen($filename_in, "w+");
fwrite($file_in, $input);
fclose($file_in);
if( $win_platform ){ //win 
	exec("cacls  $executable /g everyone:f"); // modifies discretionary access control lists  on specified files. to give file permission to run 
	exec("cacls  $filename_error /g everyone:f");	// or modify by any user(every one)
}else{
	exec("chmod ugo+rwx $executable");
	exec("chmod ugo+rwx  $filename_error");
}
shell_exec($command_error);
$error = file_get_contents($filename_error);

if (trim($error) == "") {
	if (trim($input) == "") {
		$output = shell_exec($out);
	} else {
		$out = $out . " < " . $filename_in;
		$output = shell_exec($out);
	}
	echo "$output";
} else if (!strpos($error, "error")) {
	echo "<pre>$error</pre>";
	if (trim($input) == "") {
		$output = shell_exec($out);
	} else {
		$out = $out . " < " . $filename_in;
		$output = shell_exec($out);
	}

	echo "$output";
} else {
	echo " $error ";
}

$del = $win_platform? "rem":"rm";
exec($del." ".$executable);
exec($del." ".$filename_code);
exec($del." ".$filename_in);
exec($del." ".$filename_error);
