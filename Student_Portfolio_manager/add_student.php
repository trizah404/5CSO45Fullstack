<?php
include 'includes/header.php';

$name = $email = '';
$errors = [];
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1️⃣ Get form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // 2️⃣ Validation
    if (empty($name)) {
        $errors['name'] = "Name is required";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters";
    }

    if ($password !== $confirmPassword) {
        $errors['confirm_password'] = "Passwords do not match";
    }

    // 3️⃣ If no validation errors
    if (empty($errors)) {

        // 4️⃣ Read JSON file
        $file = 'users.json';

        if (!file_exists($file)) {
            $errors['file'] = "User data file not found";
        } else {
            $jsonData = file_get_contents($file);
            if ($jsonData === false) {
                $errors['file'] = "Failed to read user data";
            } else {

                $users = json_decode($jsonData, true);
                if (!is_array($users)) {
                    $users = [];
                }

                // 5️⃣ Hash password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // 6️⃣ Create user array
                $newUser = [
                    "name" => $name,
                    "email" => $email,
                    "password" => $hashedPassword
                ];

                $users[] = $newUser;

                // 7️⃣ Write back to JSON
                if (file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT))) {
                    $success = "Registration successful!";
                    $name = $email = '';
                } else {
                    $errors['file'] = "Failed to save user data";
                }
            }
        }
    }
}
?>

<!-- 8️⃣ Success Message -->
<?php if ($success): ?>
    <div class="success"><?php echo $success; ?></div>
<?php endif; ?>

<!-- Registration Form -->
<form method="post" action="upload.php" enctype="multipart/form-data">
    <label>Name</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
    <span class="error"><?php echo $errors['name'] ?? ''; ?></span>

    <label>Profile Photo</label>
    <input type="file" name="photo" accept="image/*">

    <label>Email</label>
    <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
    <span class="error"><?php echo $errors['email'] ?? ''; ?></span>

    <label>Password</label>
    <input type="password" name="password">
    <span class="error"><?php echo $errors['password'] ?? ''; ?></span>

    <label>Confirm Password</label>
    <input type="password" name="confirm_password">
    <span class="error"><?php echo $errors['confirm_password'] ?? ''; ?></span>

    <button type="submit">Register</button>
</form>

<?php include 'includes/footer.php'; ?>
