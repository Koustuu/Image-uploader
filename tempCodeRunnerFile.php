<?php
// Check if the form was submitted
if(isset($_POST['submit'])){
    // Check if file was uploaded without errors
    if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){
        $file = $_FILES['image'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];

        // Check file extension
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
        if(in_array($fileExt, $allowedExtensions)){
            // Generate unique file name to prevent overwriting
            $newFileName = uniqid('', true) . '.' . $fileExt;
            $uploadPath = 'uploads/' . $newFileName;

            // Move uploaded file to designated folder
            if(move_uploaded_file($fileTmpName, $uploadPath)){
                echo 'File uploaded successfully.';
            } else {
                echo 'Failed to upload file.';
            }
        } else {
            echo 'Unsupported file format. Please upload an image (jpg, jpeg, png, gif).';
        }
    } else {
        echo 'Error uploading file: ' . $_FILES['image']['error'];
    }
}
?>