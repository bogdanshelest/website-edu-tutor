<?php
$subject=$_POST['subject'];
$type_subject=$_POST['type_subject'];

$target_dir = "../materials/$subject/$type_subject/";

if ($type_subject === 'answers') {
  $target_dir = "../materials/$subject/variants/answers/";
}


$uploadOk = 1;
//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {

}

// Check if file already exists
//if (file_exists($target_file)) {
  //echo "Sorry, file already exists.";
  //$uploadOk = 0;
//}

// Check file size
//if ($_FILES["fileToUpload"]["size"] > 50000000) {
  //echo "Sorry, your file is too large.";
  //$uploadOk = 0;
//}

// Allow certain file formats
//($imageFileType != "docx" && $imageFileType != "pdf" && $imageFileType != "jpeg"
//&& $imageFileType != "png" ) {
  //echo "Sorry, only DOCX, PDF, JPEG & PNG files are allowed.";
//$uploadOk = 0;
//}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  //echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {

  echo $_FILES['fileToUpload']['name'];
  $countfiles = count($_FILES['fileToUpload']['name']);

  for($i=0;$i<$countfiles;$i++) {

    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);
    //htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]))
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
      echo "The file ".$target_file . " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}
?>