<?php
// session.php

// IMPORTANT: Must be set BEFORE session_start()
session_set_cookie_params([
    'httponly' => true,   // Prevent JS access to session cookie
    'samesite' => 'Lax',  // Reduce CSRF risk
    // 'secure' => true,  // Enable this ONLY if you are using HTTPS
]);

session_start();
