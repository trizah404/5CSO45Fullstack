<?php require 'db.php'; ?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Add Student</title></head>
<body>
  <h1>Add Student</h1>
  <form action="store.php" method="post">
    <label>Name:</label>
    <input type="text" name="name" required><br>
    <label>Email:</label>
    <input type="email" name="email" required><br>
    <label>Course:</label>
    <input type="text" name="course" required><br>
    <button type="submit">Save</button>
  </form>
  <p><a href="index.php">Back to list</a></p>
</body>
</html> 