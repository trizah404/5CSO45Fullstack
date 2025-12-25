<?php
require 'db.php';
$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Edit Student</title></head>
<body>
  <h1>Edit Student</h1>
  <form action="update.php" method="post">
    <input type="hidden" name="id" value="<?= $student['id'] ?>">
    <label>Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required><br>
    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required><br>
    <label>Course:</label>
    <input type="text" name="course" value="<?= htmlspecialchars($student['course']) ?>" required><br>
    <button type="submit">Update</button>
  </form>
</body>
</html> 