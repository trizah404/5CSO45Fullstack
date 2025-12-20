<?php
include 'includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Form fields
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    $errors = [];

    // Validation (basic)
    if (empty($name) || empty($email) || empty($password)) {
        $errors[] = "All fields are required";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match";
    }

    // File upload handling
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {

        $uploadDir = "uploads/";
        $fileName = time() . "_" . basename($_FILES["photo"]["name"]);
        $targetPath = $uploadDir . $fileName;

        $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png'];

        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Only JPG, JPEG, and PNG files allowed";
        }

        if (empty($errors)) {
            move_uploaded_file($_FILES["photo"]["tmp_name"], $targetPath);
        }
    } else {
        $errors[] = "Photo upload failed";
    }

    // Save data if no errors
    if (empty($errors)) {
        $file = 'users.json';
        $data = file_get_contents($file);
        $users = json_decode($data, true) ?? [];

        $users[] = [
            "name" => $name,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT),
            "photo" => $fileName
        ];

        file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));

        echo "<div class='success'>Registration with photo successful!</div>";
    } else {
        echo "<div class='error'>" . implode("<br>", $errors) . "</div>";
    }
}

include 'includes/footer.php';
