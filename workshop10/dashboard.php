<?php
require 'session.php';
require 'db.php';

$user_email = '';
$isLoggedIn = isset($_SESSION['user_id']);

try {
    if ($isLoggedIn) {
        $user_id = $_SESSION['user_id'];

        // PART 4: Prepared statement (prevents SQL injection)
        $stmt = $pdo->prepare("SELECT email FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $user_id]);
        $user = $stmt->fetch();

        if ($user) {
            $user_email = $user['email'];
        } else {
            // If user id is invalid, force logout-like behavior
            $isLoggedIn = false;
            $user_email = '';
            unset($_SESSION['user_id']);
        }
    }

    // PART 7: Logout mechanism
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
        // Unset all session variables
        $_SESSION = [];

        // Delete the session cookie (good practice)
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destroy session
        session_destroy();

        header('Location: login.php');
        exit;
    }

} catch (Exception $e) {
    // Keep dashboard silent / safe
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<h1>Welcome to my site</h1>

<?php if ($isLoggedIn && $user_email): ?>
    <!-- PART 5: Escape output (prevents XSS) -->
    <p>Logged In User: <?php echo htmlspecialchars($user_email); ?></p>

    <!-- PART 7: Logout button for authenticated users -->
    <form method="POST" style="margin-top: 10px;">
        <button type="submit" name="logout">Logout</button>
    </form>

<?php else: ?>
    <!-- Unauthenticated users see Login button -->
    <a href="login.php">
        <button>Login</button>
    </a>
<?php endif; ?>

</body>
</html>
