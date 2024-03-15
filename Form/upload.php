<?php
$errorMessage = "";
$displayName = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["image"])) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        //Check image using getimagesize function and get size. If a valid number is obtained then uploaded file is an image.
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
            $errorMessage = "File is not an image.";
        }
    }
    // Check for uploaded file formats and allow only jpg, png, jpeg and webp.
    if ($uploadOk === 1 && $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $uploadOk = 0;
        $errorMessage = "Sorry, only JPG, JPEG, PNG files are allowed.";
    }
    // Check if $uploadOk is 1 and proceed further.
    if ($uploadOk === 1) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $displayName = htmlspecialchars(basename($_FILES["image"]["name"]));
        } else {
            $errorMessage = "Sorry, there was an error uploading your file.";
        }
    }
}