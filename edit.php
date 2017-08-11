 <?php
// Start the session
session_start();
$file = "";
$path = "";
$textloaded = 0;
$is_file = 0;
$filetype = 0;
$displaytext = "";
$size = 1;
$rootpath = $_SERVER['DOCUMENT_ROOT'];
// removes slash from end of rootpath
$rootarray = str_split($rootpath);
array_pop($rootarray);
$rootpath = implode("",$rootarray);

if (isset($_POST['textarea'])){
    echo $_POST['textarea'];
}
$ext = "";
$extensions = array("html", "xhtml", "shtml", "css", "php", "js", "txt", "xml", "jpg", "jpeg", "gif", "png", "pdf", "svg");
 
$txtextensions = array("html","xhtml","shtml","css","php","js","txt","xml");
$imgextensions = array("jpg","jpeg","gif","png","svg");


// transfer post variables
if (isset($_GET['path'])){
    $path = $_GET['path'];
}
if (isset($_GET['file'])) {   
    $file = $_GET['file'];
}
// testing
//echo "<br>in path: ".$path;
//echo "<br>in file: ".$file;
//echo "<br>rootpath: ".$rootpath;

if (is_file($rootpath.$path."/".$file)){
   $is_file = 1;
   $path_bits = pathinfo($rootpath.$path."/".$file);
   $ext = $path_bits['extension'];
}
// add the file to the path if the file value is a directory  
if($is_file == 0){
    // the file would is a directory
    if($path != "/" && $file != "." && $file != "") {        
       $path = $path."/".$file;       
       $file = "";
      }
}
// remove one path element
if($file == '.' && $path != "" && $is_file == 0) {
    $xpath = explode("/",$path);
    array_pop($xpath);
    $path = implode("/",$xpath);
}
// set file display type
if (in_array($ext, $imgextensions)) {
    $filetype = 2;
}
if (in_array($ext, $txtextensions)) {
    $filetype = 1;
}
if($ext == "pdf"){
    $filetype = 3;
} 
$scanpath = $rootpath.$path;
?>
<!DOCTYPE html>
<html>
<head>
<title>Editor</title>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.w3-flat-turquoise
{color:#fff;background-color:#1abc9c}
.w3-flat-emerald
{color:#fff;background-color:#2ecc71}
.w3-flat-peter-river
{color:#fff;background-color:#3498db}
.w3-flat-amethyst
{color:#fff;background-color:#9b59b6}
.w3-flat-wet-asphalt
{color:#fff;background-color:#34495e}
.w3-flat-green-sea
{color:#fff;background-color:#16a085}
.w3-flat-nephritis
{color:#fff;background-color:#27ae60}
.w3-flat-belize-hole
{color:#fff;background-color:#2980b9}
.w3-flat-wisteria
{color:#fff;background-color:#8e44ad}
.w3-flat-midnight-blue
{color:#fff;background-color:#2c3e50}
.w3-flat-sun-flower
{color:#fff;background-color:#f1c40f}
.w3-flat-carrot
{color:#fff;background-color:#e67e22}
.w3-flat-alizarin
{color:#fff;background-color:#e74c3c}
.w3-flat-clouds
{color:#000;background-color:#ecf0f1}
.w3-flat-concrete
{color:#fff;background-color:#95a5a6}
.w3-flat-orange
{color:#fff;background-color:#f39c12}
.w3-flat-pumpkin
{color:#fff;background-color:#d35400}
.w3-flat-pomegranate
{color:#fff;background-color:#c0392b}
.w3-flat-silver
{color:#000;background-color:#bdc3c7}
.w3-flat-asbestos
{color:#fff;background-color:#7f8c8d}
.filename {
    font-size: 1.1em;
    padding: 0.5em;
}
a {
    font-size: 1.1em;
    line-height: 2.0;
}
a:hover {
    opacity: 0.5;
}
.banner {
    padding-left: 0.5em;
    padding-bottom: 0.5em;
}
body {
    margin: 0;
    padding: 0;
    font-family: Arial, helvetica sans-serif;
}
.clearfix {
    clear: both;
}
#currentpath {
    padding-left: 2em;
}
#dir-select {
    float: right;
    margin-right: 1em;
    margin-top: 1em;
}
.directory {
    color: white;
    text-decoration: none;
    font-weight: 450;
}
#editor {
    display: block;
    font-family: Menlo;
    margin: auto;
    font-size: 0.8em;
    line-height: 1.8;
}
.fa-arrow-left {
    margin-right: 1em !important;
    margin-bottom: 1em !important;
}
#file-browser {
    position: relative;
    padding-left: 1em;
    padding-right: 1em;
}
.file {
    color: lightyellow;
}

h1 {
    font-family: arial;
    font-weight: lighter;
    font-size: 4em;
    line-height: 1.2;
    margin: 0;
    padding: 0;
    letter-spacing: 0.9em;
}
h2 {
    margin: 0;
    font-weight: lighter;
    line-height: 1.0;
    padding: 0;
    font-size: 1.2em;
    word-spacing: 2.9em;
}

.info {
  min-width: 10%;
  padding-top: 1em;
  padding-bottom: 1em;
  font-family: Menlo;
  font-size: 1.2em;
  color: grey;
}
img {
    display: block;
    margin: auto;
    height: 100%;
}
.image-window {
     display: block;
     height: 60vh;
}
.floatleft {
   float: left;
}

#save-text {
    margin-top: 1em;
    margin-left: 5%;
}
textarea {
    resize: none;
    min-width: 700px;
    min-height: 600px;
}
.write-button {
    margin-top: 1.5em;
    margin-right: 7em;
    float: right;
}
.write-button:hover {
    background: red;
    color: white;
    opacity: 0.9;
    border: 2px solid white;
}
.my-column {
    display: block;
    min-height: 800px;
    padding-top: 10px;
}
.browser-label {
    border-bottom: 1px solid lightgray;
}
</style>
</head>
<body>
<div class="container">
<?php // echo "scanpath: ".$scanpath; ?>
<?php // echo "<br>path: ".$path; ?>
<?php // echo "<br>file: ".$file; ?>
<div class="banner w3-flat-clouds">
<h1 class="w3-text-white">we&b</h1>
<h2 class="w3-text-white">web editor and browser</h2>
</div>
<div class="w3-medium row" id="currentpath">
<div class="info w3-left"><?php echo "selected path: ".$rootpath.$path."/".$file ?></div>
</div>
</div>
<div class="clearfix"></div>
<div class="container">
<div class="w3-col m9 w3-flat-clouds my-column">
<!-- display area -->
<form action="write_file.php" method="post" >
<input type="hidden" name="writepath" value="<?php echo $rootpath.$path."/".$file; ?>" >
<?php 
if ($is_file == 1 && $filetype == 1) {
    $displaytext = file_get_contents($rootpath.$path."/".$file);
} 
?>
<div class="display">
<?php
if($filetype == 1 || $filetype == 0) {
    echo "<textarea id='editor' name='textarea'>";
    echo htmlentities($displaytext); 
    echo "</textarea>";
    }
//
$image = $path.'/'.$file;
if($filetype == 2) {
    echo "<div class='image-window'>";
    echo "<img src='$image' >";
    echo "</div>";
 }
 if($filetype == 3) {
    echo "<div id='imagewindow'>";
    echo "<object width='100%' height='500' data='$image' ></object>";
    echo "</div>";
 }
?>
</div>
<?php
if($filetype == 1) {
echo "<input class='write-button' type='submit' value='overwrite $file'>";
}
?>
</form>
</div>
<div class="w3-col m3 w3-flat-concrete my-column" id="file-browser">
<div>
<h3 class="browser-label">File Browser</h3>
<?php
if(is_dir($scanpath)) {    
    $files = scandir($scanpath);
    // file could be a file or a path
    foreach($files as $file){
    if($file == ".") {
    echo "<a class='w3-left' href='edit.php?path=$path&amp;file=$file' ><i class='fa fa-arrow-left w3-xlarge'></i></a>";  
    echo "<a class='w3-left' href='edit.php' ><i class='fa fa-home w3-xlarge'></i></a>";  
    echo "<div class='clearfix'></div>";
    }
    if($file != ".." && $file != "."){ 
         if(is_file($rootpath.$path."/".$file)){
            echo "<a class='file' href='edit.php?path=$path&amp;file=$file' >".$file."</a><br>";
         }
        else{
        if($file != "Edit") {
            echo "<a class='directory' href='edit.php?path=$path&amp;file=$file' >".$file."</a><br>";
            }
        }
        }
    }
}
?>
</div>
</div>
</body>
</html>