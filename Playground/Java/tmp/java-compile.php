<?php
if (!isset($_POST['input']))
	Header("location:./");

session_start();
$username = $_SESSION['username'];

$CC = "javac ";
$out = "java -classpath ./$username "; //it was out="java Main"; //////////////   .\$username 
$code = $_POST["input"];
$input = $_POST["Args"];

mkdir($username);

//for getting the class name to create java file with the same name
$string = explode(" ", strstr($code, "class"));
$filename_code = preg_replace("/[{]/", "", $string[1]);
$filename_code = preg_replace("/[\r\n]*/", "", $filename_code);
$Namawa = $filename_code;

$filename_code = $username . "/" . $filename_code;

$out = $out . $Namawa;
//$outt = $out;
$filename_code = $filename_code . ".java";

// echo $filename_code; // maintenenace

$filename_in = $username . "/input.txt";
$filename_error = $username . "/error.txt";
$runtime_file = $username . "/runtime.txt";
$executable = $username . "/" . $Namawa . ".class";
$command = $CC . $filename_code;
$command_error = $command . " 2>" . $filename_error;
$runtime_error_command = $out . " 2>" . $runtime_file;


//if(trim($code)=="")
//die("The code area is empty");

$file_code = fopen($filename_code, "w+");
fwrite($file_code, $code);
fclose($file_code);
$file_in = fopen("./" . $filename_in, "w+");
fwrite($file_in, $input);
fclose($file_in);
exec("cacls  $executable /g everyone:f");
exec("cacls  $filename_error /g everyone:f");

shell_exec($command_error);
$error = file_get_contents($filename_error);

if (trim($error) == "") {
	if (trim($input) == "") {
		shell_exec($runtime_error_command);
		$runtime_error = file_get_contents($runtime_file);
		$output = shell_exec($out);
	} else {
		shell_exec($runtime_error_command);
		$runtime_error = file_get_contents($runtime_file);
		$out = $out . " < " . $filename_in;
		$output = shell_exec($out);
	}
	//echo "<pre>$runtime_error</pre>"; /// Uncomment this :D to see runtime errors 
	//echo "<pre>$output</pre>";
	echo "$output";
} else if (!strpos($error, "error")) {
	echo " $error ";
	if (trim($input) == "") {
		$output = shell_exec($out);
	} else {
		$out = $out . " < " . $filename_in;
		$output = shell_exec($out);
	}
	//echo "<pre>$output</pre>";
	echo "$output";
	//echo "<textarea id='div' class=\"form-control\" name=\"output\" rows=\"10\" cols=\"50\">$output</textarea><br><br>";
} else {
	echo " $error ";
}

unlink($filename_in);
unlink($filename_error);
unlink($runtime_file);
unlink($filename_code);
unlink($username . "/" . $Namawa . ".class");
rmdir($username);
