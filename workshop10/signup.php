<?php
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1) Read & trim inputs
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // 2) Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
    }
    // 3) Validate password
    elseif (empty($password)) {
        $message = "Password cannot be empty.";
    }
    elseif (strlen($password) < 6) { // you can set 8 if you want stronger
        $message = "Password must be at least 6 characters long.";
    }
    else {
        try {
            // 4) Hash password (Part 3)
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // 5) Prepared statement (Part 4)
            $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
            $stmt->execute([
                ':email' => $email,
                ':password' => $hashedPassword
            ]);

            $message = "User signed up successfully";
            header('refresh: 2; url=login.php');
        } catch (Exception $e) {
            // Keep it generic (Part 6 style)
            $message = "Something went wrong.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
</head>
<body>

<h2>Signup</h2>

<?php if ($message): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form method="POST">
    <label>Email:</label><br>
    <input type="text" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>"><br><br>

    <label>Password:</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit">Signup</button>
</form>

<br>
<a href="login.php">Go to Login</a>

</body>
</html>
