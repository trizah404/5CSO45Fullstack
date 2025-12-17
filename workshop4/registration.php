<?php
// Initialize variables
$name = $email = $password = $confirm_password = "";
$nameErr = $emailErr = $passwordErr = $confirmPasswordErr = "";
$successMsg = $fileErr = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Name validation
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = htmlspecialchars(trim($_POST["name"]));
    }

    // Email validation
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = htmlspecialchars(trim($_POST["email"]));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // Password validation
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
        if (strlen($password) < 8) {
            $passwordErr = "Password must be at least 8 characters long";
        } elseif (!preg_match("/[0-9]/", $password)) {
            $passwordErr = "Password must contain at least one number";
        } elseif (!preg_match("/[!@#$%^&*(),.?\":{}|<>]/", $password)) {
            $passwordErr = "Password must contain at least one special character";
        }
    }

    // Confirm password validation
    if (empty($_POST["confirm_password"])) {
        $confirmPasswordErr = "Please confirm your password";
    } else {
        $confirm_password = $_POST["confirm_password"];
        if ($password !== $confirm_password) {
            $confirmPasswordErr = "Passwords do not match";
        }
    }

    // If no errors, proceed to save user
    if (empty($nameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmPasswordErr)) {
        try {
            // Read existing users
            $file = "users.json";
            if (!file_exists($file)) {
                file_put_contents($file, "[]");
            }

            $data = file_get_contents($file);
            if ($data === false) {
                throw new Exception("Error reading users.json");
            }

            $users = json_decode($data, true);
            if ($users === null) {
                throw new Exception("Error decoding JSON data");
            }

            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Create new user record
            $newUser = [
                "name" => $name,
                "email" => $email,
                "password" => $hashedPassword
            ];

            $users[] = $newUser;

            // Write back to file
            $jsonData = json_encode($users, JSON_PRETTY_PRINT);
            if (file_put_contents($file, $jsonData) === false) {
                throw new Exception("Error writing to users.json");
            }

            $successMsg = "Registration successful! Your account has been created.";
            // Clear form values
            $name = $email = $password = $confirm_password = "";

        } catch (Exception $e) {
            $fileErr = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Registration</title>
  <style>
    body { 
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
      background: linear-gradient(to right, #e0eafc, #cfdef3); 
      display: flex; justify-content: center; align-items: center; height: 100vh; 
    }
    .registration-container {
      background: #fff; padding: 25px 30px; border-radius: 10px;
      width: 350px; box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }
    .registration-container h2 {
      text-align: center; margin-bottom: 20px; color: #333;
      font-family: 'Arial Black', sans-serif;
    }
    .registration-container label {
      display: block; margin-top: 12px; font-weight: bold;
    }
    .registration-container input {
      width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc;
      border-radius: 5px; box-sizing: border-box;
    }
    .registration-container button {
      margin-top: 20px; width: 100%; padding: 12px;
      background-color: #28a745; color: white; border: none; border-radius: 5px;
      font-size: 1em; cursor: pointer;
    }
    .registration-container button:hover {
      background-color: #218838;
    }
    .error { color: red; font-size: 0.85em; }
    .success { color: green; font-size: 0.95em; margin-bottom: 15px; }
  </style>
</head>
<body>
  <div class="registration-container">
    <h2>Create Account</h2>

    <?php if (!empty($successMsg)) echo "<div class='success'>$successMsg</div>"; ?>
    <?php if (!empty($fileErr)) echo "<div class='error'>$fileErr</div>"; ?>

    <form action="registration.php" method="post">
      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
      <span class="error"><?php echo $nameErr; ?></span>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
      <span class="error"><?php echo $emailErr; ?></span>

      <label for="password">Password</label>
      <input type="password" id="password" name="password">
      <span class="error"><?php echo $passwordErr; ?></span>

      <label for="confirm_password">Confirm Password</label>
      <input type="password" id="confirm_password" name="confirm_password">
      <span class="error"><?php echo $confirmPasswordErr; ?></span>

      <button type="submit">Sign Up</button>
    </form>
  </div>
</body>
</html>
