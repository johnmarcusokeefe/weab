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
$txt = "";
$rootpath = $_SERVER['DOCUMENT_ROOT'];
// write update
// test and transfer post variables
if (isset($_POST['path'])){
    $path = $_POST['path'];
}
if (isset($_POST['file'])) {   
    $file = $_POST['file'];
}
// ********************************
// update file that has been edited
// ********************************
function update_file($writepath,$txt) {
    $myfile = fopen($writepath, "w") or die("Unable to open file!");
    fwrite($myfile, $txt);
    fclose($myfile);
}
//
if (isset($_POST['textarea'])) {
    $txt = $_POST['textarea'];
    }
$writepath = $rootpath.$path."/".$file;    
if($txt != "") {
  update_file($writepath, $txt);  
}
$ext = "";
$extensions = array("html", "xhtml", "shtml", "css", "php", "js", "txt", "xml", "jpg", "jpeg", "gif", "png", "pdf", "svg");
$txtextensions = array("html","xhtml","shtml","css","php","js","txt","xml");
$imgextensions = array("jpg","jpeg","gif","png","svg","eps");
if (isset($_GET['path'])){
    $path = $_GET['path'];
}
if (isset($_GET['file'])) {   
    $file = $_GET['file'];
}
if (is_file($rootpath.$path."/".$file)){
   $is_file = 1;
   $path_bits = pathinfo($rootpath.$path."/".$file);
   $ext = $path_bits['extension'];
}
//
// add the file to the path if the file value is a directory  
//
if($is_file == 0){
    // the file value is a directory
    if($path != "/" && $file != "." && $file != "") {        
       $path = $path."/".$file;       
       $file = "";
      }
}
//
// remove one path element when navigating back
//
if($file == '.' && $path != "" && $is_file == 0) {
    $xpath = explode("/",$path);
    array_pop($xpath);
    $path = implode("/",$xpath);
}
//
// set file display type
//
if (in_array($ext, $imgextensions)) {$filetype = 2;}
if (in_array($ext, $txtextensions)) {$filetype = 1;}
if($ext == "pdf"){ $filetype = 3;}
//
// scanpath is used to display the file browser list
// 
$scanpath = $rootpath.$path;
?>
<!DOCTYPE html>
<html>
<head>
<title>Editor</title>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<div class="banner w3-flat-clouds">
<h1 class="w3-text-white">we&b</h1>
<h2 class="w3-text-white">web editor and browser</h2>
</div>
<div class="w3-medium row" id="currentpath">
<?php
if($file != "") {
    $slash = "/";
}
else {
    $slash = "";
}
?>
<div class="info w3-left"><?php echo "selected path: ".$path.$slash.$file; ?></div>
</div>
</div>
<div class="clearfix"></div>
<!-- ****************************** -->
<!-- text display and editor window -->
<!-- ****************************** -->
<div class="container">
<div class="w3-col m9 w3-flat-clouds my-column">
<div id="status-bar"></div>
<form action="edit.php" method="post" >
<input type="hidden" name="path" value="<?php echo $path; ?>" >
<input type="hidden" name="file" value="<?php echo $file; ?>" >
<?php 
if ($is_file == 1 && $filetype == 1) {
    $displaytext = file_get_contents($rootpath.$path."/".$file);
} 
echo "<div class='display'>";
if($filetype == 1 || $filetype == 0) {
    echo "<textarea id='editor' name='textarea'>";
    echo htmlentities($displaytext); 
    echo "</textarea>";
}
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
echo "</div>"; 
?>
</div>
<!-- ************ -->
<!-- file browser -->
<!-- ************ -->
<div class="w3-col m3 w3-flat-concrete my-column" id="file-browser">
<div>
<h3 class="browser-label">File Browser</h3>
<?php
if(is_dir($scanpath)) {    
    $files = scandir($scanpath);
    // file could be a file or a path
    $savefile = $file;
    foreach($files as $file){
    if($file == ".") {
		echo "<a class='w3-left' href='edit.php?path=$path&amp;file=$file' ><i class='fa fa-arrow-left w3-xlarge'></i></a>";  
		echo "<a class='w3-left' href='edit.php' ><i class='fa fa-home w3-xlarge'></i></a>";
		echo "<a class='w3-left' href='/' target='blank_'><i class='fa fa-eye w3-xlarge'></i></a>";
		// ********************************************
		// save icon only visible on file load and text
		// ******************************************** 
		if($filetype == 1) {
		   echo "<button class='w3-left w3-flat-concrete' type='submit'><i class='fa fa-floppy-o w3-xlarge'></i></button>";     
		}  
        echo "<div class='clearfix'></div>";
    }
    if($file != ".." && $file != "."){ 
        if(is_file($rootpath.$path."/".$file)){
            echo "<a class='file' href='edit.php?path=$path&amp;file=$file' >".$file."</a><br>";
        } else{
            if($file != "Edit") {
                echo "<a class='directory' href='edit.php?path=$path&amp;file=$file' >".$file."</a><br>";
             }
         }
      }
    }
}
?>
<!-- **************** -->
<!-- end file browser -->
<!-- **************** -->
</form>
</div>
</div>
<script>
</script>
</body>
</html>
