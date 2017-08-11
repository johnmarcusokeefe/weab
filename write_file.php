<?php
$rootpath = $_SERVER['DOCUMENT_ROOT'];
$txt = $_POST['textarea'];
$writepath = $_POST['writepath'];
$myfile = fopen($writepath, "w") or die("Unable to open file!");
fwrite($myfile, $txt);
fclose($myfile);
echo "you have successfully written".$writepath."<br>";
echo "<a href='edit.php'>back to edit</a><br>";
echo "<a href='/'>home</a><br>";
?>