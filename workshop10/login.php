<?php
require 'session.php';
require 'db.php';

$error = '';
$email = '';

/**
 * PART 8: CSRF token generation (for GET page load)
 */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Read inputs safely
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $token = $_POST['csrf_token'] ?? '';

        /**
         * PART 8: CSRF token validation
         */
        if (empty($token) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            $error = "Invalid email or password";
        }
        /**
         * PART 5: Input validation
         */
        elseif (empty($email) || empty($password)) {
            $error = "Invalid email or password";
        }
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email or password";
        }
        else {
            /**
             * PART 4: Prepared statement to prevent SQL injection
             */
            $stmt = $pdo->prepare("SELECT id, email, password FROM users WHERE email = :email LIMIT 1");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();

            /**
             * PART 3: Verify hashed password
             * PART 6: Generic error message only
             */
            if ($user && password_verify($password, $user['password'])) {

                /**
                 * PART 7: Session security - regenerate session ID
                 */
                session_regenerate_id(true);

                // Store only user id (as workshop mentions)
                $_SESSION['user_id'] = $user['id'];

                // (Optional good practice) regenerate CSRF token after login
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                header('Location: dashboard.php');
                exit;
            } else {
                $error = "Invalid email or password";
            }
        }
    }
} catch (Exception $e) {
    $error = "Something went wrong.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<?php if ($error): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

    <label>Email:</label><br>
    <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>"><br><br>

    <label>Password:</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit">Login</button>
</form>

<br>
<a href="signup.php">Go to Signup</a>

</body>
</html>
