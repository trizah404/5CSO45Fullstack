<?php
include 'includes/header.php';

$file = 'users.json';

if (!file_exists($file)) {
    echo "<p class='error'>User data file not found.</p>";
} else {
    $data = file_get_contents($file);
    $users = json_decode($data, true);

    if (empty($users)) {
        echo "<p>No registered users found.</p>";
    } else {
        echo "<h2>Registered Users</h2>";
        echo "<ul>";
        foreach ($users as $user) {
            echo "<li>" .
                 htmlspecialchars($user['name']) . " — " .
                 htmlspecialchars($user['email']) .
                 "</li>";
        }
        echo "</ul>";
    }
}

include 'includes/footer.php';
