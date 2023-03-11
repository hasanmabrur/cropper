<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'file/';
    $fileName = date('YmdHis') . '_' . basename($_FILES['photo']['name']); // add date and time to the file name
    $targetFile = $uploadDir . $fileName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $validExtensions = array('png', 'jpg', 'jpeg', 'gif');

    if (in_array($imageFileType, $validExtensions)) {
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
            $_SESSION['photo'] = $fileName; // use the new file name with date and time for the session
            echo 'File uploaded successfully.';
        } else {
            echo 'Error uploading file.';
        }
    } else {
        echo 'Invalid file type.';
    }
}
?>
